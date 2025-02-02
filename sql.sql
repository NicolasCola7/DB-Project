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
) ENGINE=INNODB;

CREATE TABLE Amministratore (
    emailAmministratore VARCHAR(255) PRIMARY KEY,
    codice INT UNIQUE,
    FOREIGN KEY (emailAmministratore) REFERENCES Utente(email)
) ENGINE=INNODB;

CREATE TABLE Creatore (
    emailCreatore VARCHAR(255) PRIMARY KEY,
    affidabilita INT DEFAULT 0,
    FOREIGN KEY (emailCreatore) REFERENCES Utente(email)
) ENGINE=INNODB;

CREATE TABLE Progetto (
    nome VARCHAR(255) PRIMARY KEY,
    data_inserimento DATE,
    data_limite DATE,
    descr TEXT,
    stato ENUM('aperto', 'chiuso'),
    budget_avvio DECIMAL(10,2),
    tipoProgetto ENUM('Hardware', 'Software'),
    emailCreatore VARCHAR(255),
    FOREIGN KEY (emailCreatore) REFERENCES Creatore(emailCreatore)
) ENGINE=INNODB;

CREATE TABLE Reward (
    codice INT PRIMARY KEY auto_increment,
    foto TEXT,
    descr TEXT,
    nomeProgetto VARCHAR(255),
    FOREIGN KEY (nomeProgetto) REFERENCES Progetto(nome)
) ENGINE=INNODB;

CREATE TABLE Finanziamento (
    data DATE,
    emailUtente VARCHAR(255),
    nomeProgetto VARCHAR(255),
    importo DECIMAL(10,2),
    codiceReward INT,
    PRIMARY KEY (data, emailUtente, nomeProgetto),
    FOREIGN KEY (emailUtente) REFERENCES Utente(email),
    FOREIGN KEY (nomeProgetto) REFERENCES Progetto(nome),
    FOREIGN KEY (codiceReward) REFERENCES Reward(codice)
) ENGINE=INNODB;

CREATE TABLE Skill (
    nome VARCHAR(100) PRIMARY KEY
) ENGINE=INNODB;

CREATE TABLE Profilo (
    nome VARCHAR(100),
    nomeProgetto VARCHAR(255),
    numero_posizioni INT CHECK (numero_posizioni > 0),
    PRIMARY KEY (nome, nomeProgetto),
    FOREIGN KEY (nomeProgetto) REFERENCES Progetto(nome)
) ENGINE=INNODB;

CREATE TABLE Skill_Possesso (
    emailUtente VARCHAR(255),
    nomeSkill VARCHAR(100),
    livello INT CHECK (livello BETWEEN 0 AND 5),
    PRIMARY KEY (emailUtente, nomeSkill),
    FOREIGN KEY (emailUtente) REFERENCES Utente(email),
    FOREIGN KEY (nomeSkill) REFERENCES Skill(nome)
) ENGINE=INNODB;

CREATE TABLE Skill_Requisito (
    nomeSkill VARCHAR(100),
    nomeProfilo VARCHAR(100),
    nomeProgetto VARCHAR(255),
    livello INT CHECK (livello BETWEEN 0 AND 5),
    PRIMARY KEY (nomeSkill, nomeProfilo, nomeProgetto),
    FOREIGN KEY (nomeSkill) REFERENCES Skill(nome),
    FOREIGN KEY (nomeProfilo, nomeProgetto) REFERENCES Profilo(nome, nomeProgetto)
) ENGINE=INNODB;

CREATE TABLE Candidatura (
    id INT PRIMARY KEY AUTO_INCREMENT,
    stato ENUM('Aperta', 'Chiusa') DEFAULT 'Aperta',
    nomeProfilo VARCHAR(100),
    nomeProgetto VARCHAR(255),
    emailUtente VARCHAR(255),
    FOREIGN KEY (nomeProfilo, nomeProgetto) REFERENCES Profilo(nome, nomeProgetto),
    FOREIGN KEY (emailUtente) REFERENCES Utente(email)
) ENGINE=INNODB;

CREATE TABLE Commento (
    id INT PRIMARY KEY AUTO_INCREMENT,
    data DATE,
    testo TEXT,
    emailUtente VARCHAR(255),
    nomeProgetto VARCHAR(255),
    FOREIGN KEY (emailUtente) REFERENCES Utente(email),
    FOREIGN KEY (nomeProgetto) REFERENCES Progetto(nome)
) ENGINE=INNODB;

CREATE TABLE Risposta (
    idCommento INT PRIMARY KEY,
    contenuto TEXT,
    emailCreatore VARCHAR(255),
    FOREIGN KEY (idCommento) REFERENCES Commento(id),
    FOREIGN KEY (emailCreatore) REFERENCES Creatore(emailCreatore)
) ENGINE=INNODB;

CREATE TABLE Foto_Progetto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    descrizione TEXT,
    nomeProgetto VARCHAR(255),
    FOREIGN KEY (nomeProgetto) REFERENCES Progetto(nome)
) ENGINE=INNODB;

CREATE TABLE Componente (
    nome VARCHAR(255),
    nomeProgetto VARCHAR(255),
    prezzo DECIMAL(10,2),
    descr TEXT,
    quantita INT CHECK (quantita > 0),
    PRIMARY KEY (nome, nomeProgetto),
    FOREIGN KEY (nomeProgetto) REFERENCES Progetto(nome)
) ENGINE=INNODB;


-- TRIGGERS
DELIMITER $
CREATE TRIGGER CambioStatoProgetto AFTER INSERT ON Finanziamento FOR EACH ROW
BEGIN
	declare budgetRaggiunto decimal(10,2);
    declare budgetAvvio decimal(10,2);
    
	set budgetRaggiunto = (SELECT SUM(importo) FROM Finanziamento WHERE nomeProgetto = NEW.nomeprogetto);
    set budgetAvvio = (SELECT budget_avvio FROM Progetto WHERE nome = NEW.nomeProgetto);
    
    if(budgetraggiunto = budgetAvvio) then
		UPDATE Progetto SET stato = 'chiuso' WHERE nome = NEW.nomeProgetto;
	end if;
END;
$ DELIMITER ;

-- TODO: cambio affidabilità dopo inserimento progetto e ricezione finanziamento

-- Popolamento delle tabelle con dati di esempio
INSERT INTO Utente VALUES ('mario.rossi@email.com', 'Mario', 'Rossi', 'Roma', 1985, 'marior85', md5('pass123'));
INSERT INTO Utente VALUES ('giulia.bianchi@email.com', 'Giulia', 'Bianchi', 'Milano', 1990, 'giuly90', md5('securePass'));
INSERT INTO Amministratore VALUES ('mario.rossi@email.com', 1001);
INSERT INTO Creatore VALUES ('giulia.bianchi@email.com', 5);
INSERT INTO Progetto VALUES ('SmartWatch AI', '2024-01-01', '2024-12-31', 'Progetto innovativo di AI per smartwatch', 'aperto', 50000.00, 'Hardware', 'giulia.bianchi@email.com');
INSERT INTO Reward VALUES (1, 'reward1.jpg', 'T-shirt esclusiva1', 'SmartWatch AI');
INSERT INTO Finanziamento VALUES ('2024-02-01', 'mario.rossi@email.com', 'SmartWatch AI', 1000.00, 1);
INSERT INTO Reward VALUES (2, 'reward2.jpg', 'T-shirt esclusiva2', 'SmartWatch AI');
INSERT INTO Reward VALUES (3, 'reward3.jpg', 'T-shirt esclusiva3', 'SmartWatch AI');
INSERT INTO Reward VALUES (4, 'reward4.jpg', 'T-shirt esclusiva4', 'SmartWatch AI');
INSERT INTO Skill VALUES ('Python');
INSERT INTO Skill VALUES ('Machine Learning');
INSERT INTO Skill_Possesso VALUES ('mario.rossi@email.com', 'Python', 4);
INSERT INTO Profilo VALUES ('Data Scientist', 'SmartWatch AI', 2);
INSERT INTO Candidatura VALUES (1, 'Aperta', 'Data Scientist', 'SmartWatch AI', 'mario.rossi@email.com');
INSERT INTO Commento VALUES (1, '2024-02-02', 'Sembra un progetto interessante!', 'mario.rossi@email.com', 'SmartWatch AI');
INSERT INTO Risposta VALUES (1, 'Grazie per il supporto!', 'giulia.bianchi@email.com');

-- OPERAZIONI RIGARDANTI GLI UTENTI:

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
		set passwordCorretta = (SELECT count(*) FROM Utente WHERE email = emailI AND password = MD5(passwordI)) > 0;
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
		set passwordCorretta = (SELECT count(*) FROM Utente WHERE email = emailI and MD5(passwordI) = password) > 0;
        if(NOT passwordCorretta) then
			set esito = 1;
		else
			set codiceCorretto = (SELECT count(*) FROM Amministratore WHERE email = emailI AND codice = codiceI);
           
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
		INSERT INTO Utente VALUES (emailI, nomeI, cognomeI, luogo_nascitaI, anno_nascitaI, nicknameI, MD5(passwordI));
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
    CALL RegistrazioneNormale(emailI, passwordI, nomeI, cognomeI, luogo_nascitaI, anno_nascitaI, nicknameI, @esitoNormale);
    
    if ( @esitoNormale = 0) then
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
    CALL RegistrazioneNormale(emailI, passwordI, nomeI, cognomeI, luogo_nascitaI, anno_nascitaI, nicknameI, @esitoNormale);
    
    if ( @esitoNormale = 0) then
		set esito = 0; -- amministratore non registrato
	else
		set esito = 1; -- amministratore registrato
        INSERT INTO Amministratore  VALUES (emailI, codiceI);
	end if;
END;
$ DELIMITER ;
	
DELIMITER $
CREATE PROCEDURE InserimentoSkillCurriculum (IN emailI VARCHAR(255), IN nomeSkillI VARCHAR(255), IN livelloI INT, OUT esito INT)
BEGIN
	declare nomeCorretto boolean;
    declare livelloCorretto boolean;
    
    set nomeCorretto = nomeSkillI IN (SELECT nome from Skill);
    set livelloCorretto = (livelloI >= 0 and livelloI <= 5);
    
    if (nomeCorretto and livelloCorretto) then
		INSERT INTO Skill_Possesso VALUES (emailI, nomeSkillI, livelloI);
        set esito = 1; -- inserimento con successo
	else
		set esito = 0; -- inserimento con insuccesso
	end if;
END;
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE RimozioneSkillCurriculum(IN emailI VARCHAR(255), IN nomeSkillI VARCHAR(255),  OUT esito INT)
BEGIN
	declare esisteSkill boolean;
    
    set esisteSkill = nomeSkillI IN (SELECT nomeSkill from Skill_Possesso WHERE emailUtente = emailI AND nomeSkill = nomeSkillI);
    
    if (esisteSkill) then
        DELETE FROM Skill_Possesso WHERE emailUtente = emailI AND nomeSkill = nomeSkillI;
        set esito = 1;
    else
        set esito = 0;
    end if;
END;
$ DELIMITER ;
	
DELIMITER $
CREATE PROCEDURE VisualizzaProgettiAperti()
BEGIN
	SELECT * FROM Progetto WHERE stato = "aperto" ORDER BY data_inserimento DESC;
END;
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE InserimentoFinanziamento(IN progettoI VARCHAR(255), IN importoI DECIMAL(10,2), IN emailI VARCHAR(255), OUT esito INT)
BEGIN
	declare progettoValido boolean;
    declare emailCorretta boolean;
    declare utenteValido boolean; -- valido se il finanziamento che sta venendo fatto è in una data diversa dagli altri finanziamenti fatti dallo stesso utente
    declare importoValido boolean; -- l'importo del finanziamento sommato a tutti gli altri finanziamenti non deve eccedere il budget di avvio
    declare budgetCorrente decimal;
    declare budgetAvvio decimal;
    
    set progettoValido = progettoI IN (SELECT nome FROM Progetto WHERE stato = 'aperto');
    set emailCorretta = emailI IN (SELECT email FROM Utente);
    set utenteValido = emailI NOT IN (SELECT emailUtente FROM Finanziamento WHERE nomeProgetto = progettoI AND data = current_date());
    set budgetCorrente = (SELECT SUM(importo) FROM Finanziamento WHERE nomeProgetto = progettoI);
    set budgetAvvio = (SELECT budget_avvio FROM Progetto WHERE nome = progettoI);
    set importoValido = (importoI + budgetCorrente) <=  budgetAvvio; 
    
    if(NOT(progettoValido AND emailCorretta AND utenteValido)) then
		set esito = 0; -- errore: progetto o utente non trovati o utente ha gia eseguito finanziamento
	else
		if(importoValido) then
			set esito = 2; -- finanziamento eseguito correttamente
			INSERT INTO Finanziamento (data, emailUtente, nomeProgetto, importo) VALUES (current_date(), emailI, progettoI, importoI);
		else
			set esito = 1; -- importo eccedente al budget di avvio
		end if;
	end if;
END;
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE MostraRewardDisponibili (IN progettoI VARCHAR(255))
BEGIN
	SELECT * FROM Reward WHERE nomeProgetto = progettoI AND codice NOT IN (SELECT codiceReward FROM Finanziamento WHERE Finanziamento.nomeProgetto = progettoI);
END;
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE SceltaReward (IN codiceRewardI INT, IN emailUtenteI VARCHAR(255), IN nomeProgettoI VARCHAR(255))
BEGIN
	declare rewardCorretta boolean;
    
    set rewardCorretta = codiceRewardI IN (SELECT codice FROM Reward WHERE nomeProgetto = nomeProgettoI AND codice NOT IN (SELECT codiceReward FROM Finanziamento WHERE nomeProgetto = nomeProgettoI));

	if (rewardCorretta) then
		UPDATE Finanziamento SET codiceReward = codiceRewardI WHERE emailUtente = emailUtenteI AND nomeProgetto = nomeProgettoI AND data = current_date();
	end if;
END;
$ DELIMITER ;

DELIMITER $ 
CREATE PROCEDURE CommentaProgetto(IN nomeProgettoI VARCHAR(255), IN emailAutoreI VARCHAR(255), IN testoI TEXT, OUT esito INT)
BEGIN
	declare progettoEsistente boolean;
    declare autoreEsistente boolean;
    declare testoNonVuoto boolean;
    
    set progettoEsistente = nomeProgettoI IN (SELECT nome FROM Progetto WHERE nome = nomeProgettoI);
    set autoreEsistente = emailAutoreI IN (SELECT email FROM Utente WHERE email = emailAutoreI);
    set testoNonVuoto = LENGTH(testoI) > 0;
    
    if (progettoEsistente AND autoreEsistente AND testoNonVuoto) then
		set esito = 1;
		INSERT INTO Commento (data, testo, emailUtente, nomeProgetto) VALUES (current_date(), testoI, emailAutoreI, nomeProgettoI);
	else
		set esito = 0;
	end if;
END;
$ DELIMITER ;
		
DELIMITER $ 
CREATE PROCEDURE InserimentoCandidatura(IN nomeProgettoI VARCHAR(255), IN emailCandidato VARCHAR(255), IN nomeProfiloI VARCHAR(255), OUT esito INT)
BEGIN
	declare progettoValido boolean;
    declare candidatoEsistente boolean;
    declare candidaturaPossibile boolean; -- possibile candidarsi solo se non c'è un'altra candidatura aperta per lo stesso profilo dello stesso progetto
    declare profiloValido boolean; -- le skill devono avere livello >= al livello richiesto, essere uguali ai nomi di quello richiesti, , 
    declare numSkillRichieste int;
    declare profiloDisponibile boolean; -- devono esserci >=1 posizioni disponibili
    
	set progettoValido = nomeProgettoI IN (SELECT nome FROM Progetto WHERE nome = nomeProgettoI AND tipoProgetto = 'Software');
    set candidatoEsistente = emailCandidato IN (SELECT email FROM Utente WHERE email = emailCandidato);
    set candidaturaPossibile = NOT EXISTS (SELECT * FROM Candidatura WHERE nomeProgetto = nomeProgettoI AND emailUtente = emailCandidato AND nomeProfilo = nomeProfiloI AND stato = 'Aperta');
    set numSkillRichieste = (SELECT COUNT(*) FROM Skill_Requisito WHERE nomeProgetto = nomeProgettoI AND nomeProfilo = nomeProfiloI);
    set profiloValido = numSkillRichieste = (SELECT COUNT(*) FROM Skill_Requisito AS sr WHERE nomeProgetto = nomeProgettoI AND nomeProfilo = nomeProfiloI AND EXISTS (
											SELECT 1 FROM Skill_Possesso AS sp WHERE sr.nomeSkill = sp.nomeSkill AND sp.livello >= sr.livello AND emailUtente = emailCandidato));
	set profiloDisponibile = ((SELECT numero_posizioni FROM Profilo WHERE nomeProgetto = nomeProgettoI AND nome = nomeProfiloI) >= 1);
    
    if (NOT(progettoValido AND progettoEsistente)) then
		set esito = 0; -- candidato non trovato o progetto non trovato
	else 
		if (NOT(candidaturaPossibile AND profiloDisponibile)) then
			set esito = 1; -- impossibile candidarsi a causa di candidatura già esistente o nessuna posizione disponibile
		else
			if (NOT(profiloValido)) then
				set esito = 2; -- impossibile candidarsi a causa di skill non compatibili
			else
				set esito = 3; -- candidatura effettuata con successo
                INSERT INTO Candidatura (nomeProfilo, nomeProgetto, emailUtente) VALUES (nomeProfiloI, nomeProgettoI, emailCandidato);
			end if;
		end if;
	end if;
END;
$ DELIMITER ;
