drop database if exists BOTSTARTER;
create database if not exists BOTSTARTER;
use BOTSTARTER; 

-- Creazione delle tabelle
CREATE TABLE Utente (
    email VARCHAR(255) PRIMARY KEY,
    nome VARCHAR(100),
    cognome VARCHAR(100),
    luogo_nascita VARCHAR(100),
    anno_nascita INT,
    nickname VARCHAR(50),
    password VARCHAR(255)
);

CREATE TABLE Amministratore (
    emailAmministratore VARCHAR(255) PRIMARY KEY,
    codice INT UNIQUE,
    FOREIGN KEY (emailAmministratore) REFERENCES Utente(email)
);

CREATE TABLE Creatore (
    emailCreatore VARCHAR(255) PRIMARY KEY,
    affidabilita INT DEFAULT 0,
    FOREIGN KEY (emailCreatore) REFERENCES Utente(email)
);

CREATE TABLE Progetto (
    nome VARCHAR(255) PRIMARY KEY,
    data_inserimento DATE,
    data_limite DATE,
    descr TEXT,
    stato ENUM('aperto', 'chiuso'),
    budget_limite DECIMAL(10,2),
    tipoProgetto ENUM('Hardware', 'Software'),
    emailCreatore VARCHAR(255),
    FOREIGN KEY (emailCreatore) REFERENCES Creatore(emailCreatore)
);

CREATE TABLE Finanziamento (
    data DATE,
    emailUtente VARCHAR(255),
    nomeProgetto VARCHAR(255),
    importo DECIMAL(10,2),
    codiceReward INT,
    PRIMARY KEY (data, emailUtente, nomeProgetto),
    FOREIGN KEY (emailUtente) REFERENCES Utente(email),
    FOREIGN KEY (nomeProgetto) REFERENCES Progetto(nome)
);

CREATE TABLE Reward (
    codice INT PRIMARY KEY,
    foto TEXT,
    descr TEXT,
    nomeProgetto VARCHAR(255),
    FOREIGN KEY (nomeProgetto) REFERENCES Progetto(nome)
);

CREATE TABLE Skill (
    nome VARCHAR(100) PRIMARY KEY
);

CREATE TABLE Profilo (
    nome VARCHAR(100),
    nomeProgetto VARCHAR(255),
    numero_posizioni INT CHECK (numero_posizioni > 0),
    PRIMARY KEY (nome, nomeProgetto),
    FOREIGN KEY (nomeProgetto) REFERENCES Progetto(nome)
);

CREATE TABLE Skill_Possesso (
    emailUtente VARCHAR(255),
    nomeSkill VARCHAR(100),
    livello INT CHECK (livello BETWEEN 0 AND 5),
    PRIMARY KEY (emailUtente, nomeSkill),
    FOREIGN KEY (emailUtente) REFERENCES Utente(email),
    FOREIGN KEY (nomeSkill) REFERENCES Skill(nome)
);

CREATE TABLE Skill_Requisito (
    nomeSkill VARCHAR(100),
    nomeProfilo VARCHAR(100),
    nomeProgetto VARCHAR(255),
    livello INT CHECK (livello BETWEEN 0 AND 5),
    PRIMARY KEY (nomeSkill, nomeProfilo, nomeProgetto),
    FOREIGN KEY (nomeSkill) REFERENCES Skill(nome),
    FOREIGN KEY (nomeProfilo, nomeProgetto) REFERENCES Profilo(nome, nomeProgetto)
);

CREATE TABLE Candidatura (
    id INT PRIMARY KEY,
    stato VARCHAR(50),
    nomeProfilo VARCHAR(100),
    nomeProgetto VARCHAR(255),
    emailUtente VARCHAR(255),
    FOREIGN KEY (nomeProfilo, nomeProgetto) REFERENCES Profilo(nome, nomeProgetto),
    FOREIGN KEY (emailUtente) REFERENCES Utente(email)
);

CREATE TABLE Commento (
    id INT PRIMARY KEY,
    data DATE,
    testo TEXT,
    emailUtente VARCHAR(255),
    nomeProgetto VARCHAR(255),
    FOREIGN KEY (emailUtente) REFERENCES Utente(email),
    FOREIGN KEY (nomeProgetto) REFERENCES Progetto(nome)
);

CREATE TABLE Risposta (
    idCommento INT PRIMARY KEY,
    contenuto TEXT,
    emailCreatore VARCHAR(255),
    FOREIGN KEY (idCommento) REFERENCES Commento(id),
    FOREIGN KEY (emailCreatore) REFERENCES Creatore(emailCreatore)
);

CREATE TABLE Foto_Progetto (
    id INT PRIMARY KEY,
    descrizione TEXT,
    nomeProgetto VARCHAR(255),
    FOREIGN KEY (nomeProgetto) REFERENCES Progetto(nome)
);

CREATE TABLE Componente (
    nome VARCHAR(255),
    nomeProgetto VARCHAR(255),
    prezzo DECIMAL(10,2),
    descr TEXT,
    quantita INT CHECK (quantita > 0),
    PRIMARY KEY (nome, nomeProgetto),
    FOREIGN KEY (nomeProgetto) REFERENCES Progetto(nome)
);

-- Popolamento delle tabelle con dati di esempio
INSERT INTO Utente VALUES ('mario.rossi@email.com', 'Mario', 'Rossi', 'Roma', 1985, 'marior85', 'pass123');
INSERT INTO Utente VALUES ('giulia.bianchi@email.com', 'Giulia', 'Bianchi', 'Milano', 1990, 'giuly90', 'securePass');

INSERT INTO Amministratore VALUES ('mario.rossi@email.com', 1001);

INSERT INTO Creatore VALUES ('giulia.bianchi@email.com', 5);

INSERT INTO Progetto VALUES ('SmartWatch AI', '2024-01-01', '2024-12-31', 'Progetto innovativo di AI per smartwatch', 'aperto', 50000.00, 'Hardware', 'giulia.bianchi@email.com');

INSERT INTO Finanziamento VALUES ('2024-02-01', 'mario.rossi@email.com', 'SmartWatch AI', 1000.00, NULL);

INSERT INTO Reward VALUES (1, 'reward1.jpg', 'T-shirt esclusiva', 'SmartWatch AI');

INSERT INTO Skill VALUES ('Python');
INSERT INTO Skill VALUES ('Machine Learning');

INSERT INTO Skill_Possesso VALUES ('mario.rossi@email.com', 'Python', 4);

INSERT INTO Profilo VALUES ('Data Scientist', 'SmartWatch AI', 2);

INSERT INTO Candidatura VALUES (1, 'in attesa', 'Data Scientist', 'SmartWatch AI', 'mario.rossi@email.com');

INSERT INTO Commento VALUES (1, '2024-02-02', 'Sembra un progetto interessante!', 'mario.rossi@email.com', 'SmartWatch AI');

INSERT INTO Risposta VALUES (1, 'Grazie per il supporto!', 'giulia.bianchi@email.com');

-- Operazioni	che	riguardano	tutti	gli	utenti:

-- Autenticazione Utente normale: se non viene trovato l'utente ritorna 0, se la psw è errata ritorna 1, se è corretta torna 2
DELIMITER $
CREATE PROCEDURE AutenticazioneNormale(IN emailI VARCHAR(255), IN passwordI VARCHAR(255), OUT esito INT)
BEGIN	
	declare esisteUtente boolean;
	declare passwordCorretta boolean;
    
    set esisteUtente = emailI IN (SELECT email FROM Utente);
   
    if (NOT esisteUtente) then
		set esito = 0;
	else 
		set passwordCorretta = passwordI = (SELECT password FROM Utente WHERE email = emailI);
        if(NOT passwordCorretta) then
			set esito = 1;
		else
			set esito = 2;
		end if;
	end if;
END;
$ DELIMITER ;

-- Autenticazione Amministratore: se non viene trovato l'utente ritorna 0, se la psw è errata ritorna 1, se è corretta torna ma il codice errato torna 2, mentre se tutto giusto 3
DELIMITER $
CREATE PROCEDURE AutenticazioneAmministratore(IN emailI VARCHAR(255), IN passwordI VARCHAR(255), IN codiceI INT, OUT esito INT)
BEGIN	
	declare esisteUtente boolean;
	declare passwordCorretta boolean;
    declare codiceCorretto boolean;
    
    set esisteUtente = emailI IN (SELECT email FROM Amministratore);
   
    if (NOT esisteUtente) then
		set esito = 0;
	else 
		set passwordCorretta = passwordI = (SELECT password FROM Utente WHERE email = emailI);
        if(NOT passwordCorretta) then
			set esito = 1;
		else
			set codiceCorretto = codiceI = (SELECT codice FROM Amministratore WHERE email = emailI);
           
           if (NOT codiceCorretto) then
				set esito = 2;
			else
				set esito = 3;
			end if;
		end if;
	end if;
END;
$ DELIMITER ;

 DELIMITER $
CREATE PROCEDURE RegistrazioneNormale(
	IN emailI VARCHAR(255),
    IN passwordI VARCHAR(255),
    IN nomeI VARCHAR(100),
    IN cognomeI VARCHAR(100),
    IN luogo_nascitaI VARCHAR(100),
    IN anno_nascitaI INT,
    IN nicknameI VARCHAR(50),
    OUT esito INT)
BEGIN
	declare esisteUtente boolean;
	set esisteUtente = emailI IN (SELECT email from Utente);
	
	if(NOT esisteUtente) then
		INSERT INTO Utente VALUES (emailI, nomeI, cognomeI, luogo_nascitaI, anno_nascitaI, nicknameI, passwordI);
		set esito = 1; -- utente registrato
	else
		set esito = 0; -- utente non registrato
	end if;
END;
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE RegistrazioneCreatore(
	IN emailI VARCHAR(255),
    IN passwordI VARCHAR(255),
    IN nomeI VARCHAR(100),
    IN cognomeI VARCHAR(100),
    IN luogo_nascitaI VARCHAR(100),
    IN anno_nascitaI INT,
    IN nicknameI VARCHAR(50),
    OUT esito INT)
BEGIN
	declare esisteCreatore INT;
    CALL RegistrazioneNormale(emailI, passwordI, nomeI, cognomeI, luogo_nascitaI, anno_nascitaI, nicknameI, esitoNormale);
	set esisteCreatore = esitoNormale;
    
    if (esisteCreatore = 0) then
		set esito = 0; -- creatore non registrato
	else
		set esito = 1; -- creatore registrato
        INSERT INTO Creatore (emailCreatore) VALUES (emailI);
	end if;
END;
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE RegistrazioneAmministratore(
	IN emailI VARCHAR(255),
    IN passwordI VARCHAR(255),
    IN nomeI VARCHAR(100),
    IN cognomeI VARCHAR(100),
    IN luogo_nascitaI VARCHAR(100),
    IN anno_nascitaI INT,
    IN nicknameI VARCHAR(50),
    IN codice INT,
    OUT esito INT)
BEGIN
	declare esisteAmministratore INT;
    CALL RegistrazioneNormale(emailI, passwordI, nomeI, cognomeI, luogo_nascitaI, anno_nascitaI, nicknameI, esitoNormale);
	set esisteAmministratore = esitoNormale;
    
    if (esisteAmministratore = 0) then
		set esito = 0; -- amministratore non registrato
	else
		set esito = 1; -- amministratore registrato
        INSERT INTO Amministratore  VALUES (emailI, codiceI);
	end if;
END;
$ DELIMITER ;
	
    
    