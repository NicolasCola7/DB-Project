#rimuovo il database "BOTSTARTER" se esiste già o creo il database "BOTSTARTER" se non esiste già
DROP DATABASE IF exists BOTSTARTER;
CREATE database IF NOT exists BOTSTARTER;
USE BOTSTARTER;

-- Creazione delle tabelle
CREATE TABLE Utente (
    email VARCHAR(255) PRIMARY KEY,
    nome VARCHAR(100),
    cognome VARCHAR(100),
    luogo_nascita VARCHAR(100),
    anno_nascita INT,
    nickname VARCHAR(50) UNIQUE,
    password VARCHAR(255)
) ENGINE=INNODB;

CREATE TABLE Amministratore (
    emailAmministratore VARCHAR(255) PRIMARY KEY,
    codice INT UNIQUE,
    FOREIGN KEY (emailAmministratore) REFERENCES Utente(email)
) ENGINE=INNODB;

CREATE TABLE Creatore (
    emailCreatore VARCHAR(255) PRIMARY KEY,
    num_progetti INT DEFAULT 0,
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
    foto BLOB,
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
    numero_posizioni INT,
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
    stato ENUM('aperta', 'chiusa'),
    accettata BOOLEAN default false,
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

-- Il trigger per cambiare lo stato del progetto da "aperto" a "chiuso"
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

-- Il trigger che permette di aggiornare l'affidabilità dopo ogni volta che l'utente crea un progetto
DELIMITER $
CREATE TRIGGER AggiornaAffidabilitaProgetto AFTER INSERT ON Progetto FOR EACH ROW
BEGIN
	declare numProgetti INT;
    declare numProgettiFinanziati INT;
    
    -- Il numero totale di progetti creati dall'utente creatore
	set numProgetti = (SELECT COUNT(*) FROM Progetto WHERE emailCreatore = NEW.emailCreatore);
	-- Il numero di progetti dell'utente creatore che hanno ricevuto almeno un finanziamento
    set numProgettiFinanziati = (SELECT COUNT(DISTINCT nomeProgetto) FROM Finanziamento WHERE nomeProgetto IN (SELECT nome FROM Progetto WHERE emailCreatore = NEW.emailCreatore));
    
    -- Se l'utente ha almeno un progetto creato, aggiorno l'affidabilità dopo l'inserimento del progetto
    IF(numProgetti > 0) THEN
		UPDATE Creatore SET affidabilita = (numProgettiFinanziati / numProgetti * 100) WHERE emailCreatore = NEW.emailCreatore;
	END IF;
END;
$ DELIMITER ;

-- Il trigger che permette di aggiornare l'affidabilità dopo ogni volta il progetto riceve un finanziamento
DELIMITER $
CREATE TRIGGER AggiornaAffidabilitaFinanziamento AFTER INSERT ON Finanziamento FOR EACH ROW
BEGIN
    declare emailCreatoreProgetto VARCHAR(255);
	declare numProgetti INT;
    declare numProgettiFinanziati INT;
    
    -- La email del creatore del progetto finanziato
	set emailCreatoreProgetto = (SELECT emailCreatore FROM Progetto WHERE nome = NEW.nomeProgetto);
    -- Il numero totale di progetti creati dall'utente creatore
	set numProgetti = (SELECT COUNT(*) FROM Progetto WHERE emailCreatore = emailCreatoreProgetto);
	-- Il numero di progetti dell'utente creatore che hanno ricevuto almeno un finanziamento
    set numProgettiFinanziati = (SELECT COUNT(DISTINCT nomeProgetto) FROM Finanziamento WHERE nomeProgetto IN (SELECT nome FROM Progetto WHERE emailCreatore = emailCreatoreProgetto));

    -- Se l'utente ha almeno un progetto creato, aggiorno l'affidabilità dopo l'inserimento del finanziamento
    IF(numProgetti > 0) THEN
		UPDATE Creatore SET affidabilita = (numProgettiFinanziati / numProgetti * 100) WHERE emailCreatore = emailCreatoreProgetto;
	END IF;
END;
$ DELIMITER ;

-- Il trigger per aggiornare il numero di progetti dell'utente creatore
DELIMITER $
CREATE TRIGGER AggiornaNumProgetti AFTER INSERT ON Progetto FOR EACH ROW
BEGIN
	UPDATE Creatore SET num_progetti = num_progetti + 1 WHERE emailCreatore = NEW.emailCreatore;
END;
$ DELIMITER ;

DELIMITER $
CREATE EVENT CambiaStatoProgetto on schedule every 1 day starts date_format(curdate(), '%Y-%m-%d 00:00:00') do
begin
	update Progetto P set P.stato = 'chiuso' where P.data_limite < curdate() and stato <> 'chiuso';
end
$ DELIMITER ;

-- OPERAZIONI RIGARDANTI GLI UTENTI:
-- Autenticazione Utente normale: se non viene trovato l'utente ritorna 0, se la psw è errata ritorna 1, se è corretta torna 2
DELIMITER $
CREATE PROCEDURE AutenticazioneNormale(IN emailI VARCHAR(255), IN passwordI VARCHAR(255), OUT esito INT)
BEGIN	
	declare esisteUtente boolean;
	declare passwordCorretta boolean;
    
    set esisteUtente = emailI IN (SELECT email FROM Utente);
	set passwordCorretta = (SELECT count(*) FROM Utente WHERE email = emailI AND password = MD5(passwordI)) > 0;

    if (esisteUtente AND passwordCorretta) then
		set esito = 1;
	else 
		set esito = 0;
	end if;
END;
$ DELIMITER ;

-- Autenticazione Amministratore: se non viene trovato l'utente ritorna 0, se la psw è errata ritorna 1, se è corretta torna ma il codice errato torna 2, mentre se tutto giusto 3
DELIMITER $
CREATE PROCEDURE AutenticazioneAmministratore(IN emailI VARCHAR(255), IN passwordI VARCHAR(255), IN codiceI VARCHAR(50), OUT esito INT)
BEGIN
	declare esisteUtente boolean;
	declare passwordCorretta boolean;
    declare codiceCorretto boolean;
    
    set codiceI = CAST(codiceI AS UNSIGNED);
    set esisteUtente = emailI IN (SELECT emailAmministratore FROM Amministratore);
	set passwordCorretta = (SELECT count(*) FROM Utente WHERE email = emailI and MD5(passwordI) = password) > 0;
    set codiceCorretto = (SELECT count(*) FROM Amministratore WHERE emailAmministratore = emailI AND codice = codiceI);

    if ((NOT esisteUtente) OR (NOT passwordCorretta) OR (NOT codiceCorretto)) then
		set esito = 0;
	else 
		set esito = 1;
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
    IN anno_nascitaI VARCHAR(4),
    IN nicknameI VARCHAR(50),
    OUT esito INT)
BEGIN
	declare esisteUtente boolean;
    declare esisteNickname boolean;
    
	set esisteUtente = emailI IN (SELECT email from Utente);
	set esisteNickname = nicknameI IN (SELECT nickname from Utente);
    
	if((NOT esisteUtente) AND (NOT esisteNickname)) then
		set anno_nascitaI = CAST(anno_nascitaI AS UNSIGNED);
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
    IN anno_nascitaI VARCHAR(4),
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
    IN anno_nascitaI VARCHAR(4),
    IN nicknameI VARCHAR(50),
    IN codiceI VARCHAR(50),
    OUT esito INT)
BEGIN
    CALL RegistrazioneNormale(emailI, passwordI, nomeI, cognomeI, luogo_nascitaI, anno_nascitaI, nicknameI, @esitoNormale);
    
    if ( @esitoNormale = 0) then
		set esito = 0; -- amministratore non registrato
	else
		set esito = 1; -- amministratore registrato
        set codiceI = (CAST(codiceI AS UNSIGNED));
        INSERT INTO Amministratore  VALUES (emailI, codiceI);
	end if;
END;
$ DELIMITER ;
	
DELIMITER $
CREATE PROCEDURE InserimentoSkillCurriculum (IN emailI VARCHAR(255), IN nomeSkillI VARCHAR(255), IN livelloI CHAR, OUT esito INT)
BEGIN
    declare emailCorretta boolean;
	declare nomeCorretto boolean;
    declare livelloCorretto boolean;
    
    set emailCorretta = emailI IN (SELECT email from Utente);
    set nomeCorretto = nomeSkillI IN (SELECT nome from Skill);
    set livelloCorretto = (livelloI REGEXP '^[0-5]$');
    
    if (emailCorretta and nomeCorretto and livelloCorretto) then
		set livelloI = (CAST(livelloI AS UNSIGNED));
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
CREATE PROCEDURE InserimentoFinanziamento(IN nomeProgettoI VARCHAR(255), IN importoI VARCHAR(50), IN emailI VARCHAR(255), OUT esito INT)
BEGIN
	
	declare progettoValido boolean;
    declare emailCorretta boolean;
    declare utenteValido boolean; -- valido se il finanziamento che sta venendo fatto è in una data diversa dagli altri finanziamenti fatti dallo stesso utente
    declare importoValido boolean; -- l'importo del finanziamento sommato a tutti gli altri finanziamenti non deve eccedere il budget di avvio
    declare budgetCorrente decimal;
    declare budgetAvvio decimal;
    declare haFinanziamenti boolean;  --  controllo se ha finanziamenti in quanto, se cerco di inserirene uno in un progetto 
										-- che non ne ha, tale procedura non funziona ed è come se l'imorto eccedesse il budget
                                        
    set progettoValido = nomeProgettoI IN (SELECT nome FROM Progetto WHERE stato = 'aperto');
    set emailCorretta = emailI IN (SELECT email FROM Utente);
    set utenteValido = emailI NOT IN (SELECT emailUtente FROM Finanziamento WHERE nomeProgetto = nomeProgettoI AND data = current_date());
    set budgetAvvio = (SELECT budget_avvio FROM Progetto WHERE nome = nomeProgettoI);
    set haFinanziamenti = nomeProgettoI IN (SELECT nomeProgetto FROM Finanziamento);
    
    if(haFinanziamenti) then
		set budgetCorrente = (SELECT SUM(importo) FROM Finanziamento WHERE nomeProgetto = nomeProgettoI);
    else
		set budgetCorrente = 0.0;
	end if;
	
    if(CAST(importoI AS DECIMAL(10,2)) > 0) then
		set importoValido = (importoI + budgetCorrente) <=  budgetAvvio; 
    end if;
	
    if(NOT(progettoValido AND emailCorretta AND utenteValido)) then
		set esito = 0; -- errore: progetto o utente non trovati o utente ha gia eseguito finanziamento
	else
		if(importoValido) then
			set esito = 2; -- finanziamento eseguito correttamente
			INSERT INTO Finanziamento (data, emailUtente, nomeProgetto, importo) VALUES (current_date(), emailI, nomeProgettoI, importoI);
		else
			set esito = 1; -- importo eccedente al budget di avvio
		end if;
	end if;
END;
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE MostraRewardDisponibili (IN nomeProgettoI VARCHAR(255))
BEGIN
	SELECT codice, foto, descr 
    FROM Reward LEFT JOIN Finanziamento ON codice = codiceReward AND Finanziamento.nomeProgetto = nomeProgettoI
    WHERE Reward.nomeProgetto = nomeProgettoI AND codiceReward IS NULL;
END;
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE SceltaReward (IN codiceRewardI VARCHAR(50), IN emailUtenteI VARCHAR(255), IN nomeProgettoI VARCHAR(255))
BEGIN
	declare rewardCorretta boolean;
    
	-- set rewardCorretta = codiceRewardI IN (SELECT codice FROM Reward WHERE nomeProgetto = nomeProgettoI AND codice NOT IN (SELECT codiceReward FROM Finanziamento WHERE nomeProgetto = nomeProgettoI));
	if (codiceRewardI REGEXP '^[0-9]+$') then
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
    set testoNonVuoto = LENGTH(trim(testoI)) > 0;
    
    if (progettoEsistente AND autoreEsistente AND testoNonVuoto) then
		set esito = 1;
		INSERT INTO Commento (data, testo, emailUtente, nomeProgetto) VALUES (current_date(), testoI, emailAutoreI, nomeProgettoI);
	else
		set esito = 0;
	end if;
END;
$ DELIMITER ;
		
DELIMITER $ 
CREATE PROCEDURE InserimentoCandidatura(IN nomeProfiloI VARCHAR(100), IN nomeProgettoI VARCHAR(255), IN emailUtenteI VARCHAR(255))
BEGIN
	declare correttezzaNomeEProgetto boolean;
    declare correttezzaEmail boolean;
    declare candidaturaGiaPresente boolean default false;

    -- variabili da usare in fase di controllo della correttezza della candidatura
    declare livelloRichiesto int;
    declare livelloPosseduto int;
    declare nomeSkillRichiesta varchar(100);
    -- di default l'utente possiede tutte le skill richieste con il livello minimo
    declare skillsCorrette boolean default true;
    declare fineCursor boolean default false;

	-- cursore che scorre tutte le skill richieste dal profilo con il loro livello minimo richiesto
    declare cursore_skillRichiestaProfilo CURSOR FOR SELECT Sk_r.nomeSkill, Sk_r.livello
                                from Skill_Requisito Sk_r join Profilo P
                                    on Sk_r.nomeProfilo = P.nome and Sk_r.nomeProgetto = P.nomeProgetto;
	
	-- quando il cursore non trova più righe questa variabile viene impostata a true
	declare continue handler for not found set fineCursor = true;

    -- il campo profilo deve coincidere un profilo esistente nel sistema
    set correttezzaNomeEProgetto = (SELECT count(*) from Profilo where Profilo.nome = nomeProfiloI and Profilo.nomeProgetto = nomeProgettoI) > 0;
    -- il campo email dell'utente deve esistere
    set correttezzaEmail = (SELECT count(*) from Utente where Utente.email = emailUtenteI) > 0;
    -- non deve esistere già una candidatura identica ancora aperta nel db
    set candidaturaGiaPresente = (SELECT count(*) from Candidatura C where
                                    C.nomeProfilo = nomeProfiloI and
                                    C.nomeProgetto = nomeProgettoI and
                                    C.emailUtente = emailUtenteI and
                                    C.stato = 'aperta') > 0;

    if(correttezzaNomeEProgetto and correttezzaEmail and not candidaturaGiaPresente) then
        -- inizia il ciclo che scorre tutte le skill possedute 
        open cursore_skillRichiestaProfilo;

        ciclo_skill: loop
            fetch cursore_skillRichiestaProfilo into nomeSkillRichiesta, livelloRichiesto;

			if(fineCursor) then
				leave ciclo_skill;
			end if;
            
            -- leggo il livello posseduto dell'i-esima skill dell'utente
            set livelloPosseduto = (SELECT Sk_p.livello from Skill_Possesso Sk_p 
                                    where Sk_p.emailUtente = emailUtenteI and
                                          Sk_p.nomeSkill = nomeSkillRichiesta);
            
            -- se il livello non è almeno uguale a quello richiesto mi salvo questa info ed esco dal ciclo
            if(livelloPosseduto < livelloRichiesto) then
                set skillsCorrette = false;
                leave ciclo_skill;
            end if;
        end loop;

        close cursore_skillRichiestaProfilo;

        -- se tutte le skill possedute hanno un livello minimo superiore a quello richiesto dalle skill del profilo la candidatura
        -- è accettabile e quindi la si inserisce
        if(skillsCorrette) then
            INSERT INTO Candidatura (stato, nomeProfilo, nomeProgetto, emailUtente) 
                   values ('aperta', nomeProfiloI, nomeProgettoI, emailUtenteI);
        end if;
    end if;
END;
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE CreazioneProgetto(IN nomeI VARCHAR(255), IN dataLimiteI VARCHAR(255), IN descrI TEXT, IN budgetI VARCHAR(255), IN TipoI VARCHAR(255), IN emailCreatoreI VARCHAR(255))
BEGIN
    declare correttezzaNome boolean;
	declare correttezzaBudget boolean;
    declare correttezzaData boolean;
    declare correttezzaEmailCreatore boolean;
    declare correttezzaTipo boolean;
    
    set correttezzaData = false;
    
    -- il nome deve essere compilato e non già presente
    set correttezzaNome = (LENGTH(nomeI) > 0 AND (nomeI IS NOT NULL));
    
	-- controllo che il campo budget sia convertibile in un numero e che sia positivo
	set correttezzaBudget = (budgetI REGEXP '^[0-9]+(\.[0-9]{1,2})?$' AND CAST(budgetI AS DECIMAL(10,2)) > 0);
    
    -- controllo che il campo data sia in formato YYYY-MM-DD
    if(dataLimiteI REGEXP '^[0-9]{2,4}-[0-9]{1,2}-[0-9]{1,2}$')then
		-- controllo che sia un valore convertibile in data
		if(STR_TO_DATE(dataLimiteI,'%Y-%m-%d') is not null) then
			-- controllo che la data inserita sia futura
			if(dataLimiteI > curdate()) then
				set correttezzaData = true;
			end if;
		end if;
	end if;
    
    -- il creatore del progetto deve esistere
	set correttezzaEmailCreatore = (SELECT COUNT(*) FROM Creatore WHERE emailCreatore = emailCreatoreI) > 0;
    -- il tipo deve essere o hardware o software
    set correttezzaTipo = (tipoI IN ('Hardware','Software'));
    
    if (correttezzaNome and correttezzaBudget and correttezzaData and correttezzaEmailCreatore and correttezzaTipo) then
		INSERT IGNORE INTO Progetto VALUES (nomeI, CURDATE(), dataLimiteI, IFNULL(NULLIF(descrI, ''), 'descrizione assente'), 'aperto', budgetI, TipoI, emailCreatoreI);
	end if;
END;
$ DELIMITER ; 

DELIMITER $
CREATE PROCEDURE CreazioneReward(IN FotoI TEXT, IN descrI TEXT, IN nomeI VARCHAR(255), IN emailCreatoreI VARCHAR(255))
BEGIN
    declare correttezzaFoto boolean;
    declare correttezzaNomeProg boolean;

    -- la foto deve avere una estensione valida
    set correttezzaFoto = (FotoI REGEXP '\\.(jpg|jpeg|png|gif|bmp|webp)$');
    -- se la query ritorna zero significa che non esiste alcun progetto con quel determinato nome creato da quell'utente e quindi non è possibile
    -- creare la reward
    set correttezzaNomeProg = (SELECT count(*) from Progetto where Progetto.nome = nomeI and Progetto.emailCreatore = emailCreatoreI) > 0;
    
    if(correttezzaFoto and correttezzaNomeProg) then
        -- se descrI è vuoto o null imposto di default la descrizione
		INSERT INTO Reward (foto, descr, nomeProgetto) values (FotoI, IFNULL(NULLIF(descrI, ''), 'descrizione assente'), nomeI);
	end if;
END
$ DELIMITER ; 

DELIMITER $
CREATE PROCEDURE rispondiACommento(IN idCommentoI VARCHAR(255), IN contenutoI TEXT, IN emailCreatoreI VARCHAR(255))
BEGIN
    declare correttezzaCommento boolean;
    declare correttezzaContenuto boolean;
    declare correttezzaEmail boolean;

    -- il codice deve essere un numero positivo (utilizzo di espressione regolare che mi ritorna vero se il codiceI è un numero)
    -- (unsigned ammette interi senza segno quindi per forza positivi)
    set correttezzaCommento = (idCommentoI REGEXP '^[0-9]+$' and CAST(idCommentoI AS UNSIGNED) > 0);

    -- se descrI è una stringa vuota la imposto a null altrimenti restituisce il valore stesso (uso di nullif)
    -- sul risultato interno poi verifico ancora se esso è null -> se è null ritorno false altrimenti true (uso di ifnull)
    set correttezzaContenuto = IF(contenutoI = '' or contenutoI is null, false, true);

    -- se la query ritorna zero significa che non esiste nessun utente creatore con quell'email che ha creato un progetto
    set correttezzaEmail = (SELECT count(*) from Progetto where Progetto.emailCreatore = emailCreatoreI) > 0;

    if(correttezzaCommento and correttezzaContenuto and correttezzaEmail) then
        INSERT IGNORE INTO Risposta values (idCommentoI, contenutoI, emailCreatoreI);
    end if;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE InserimentoProfilo(IN nomeProfiloI VARCHAR(100), IN nomeProgettoI VARCHAR(255), IN numeroPosizioniI VARCHAR(255), IN skillsRichiestaI TeXT)
BEGIN
    declare correttezzaProfilo boolean;
    declare correttezzaProgetto boolean;
    declare correttezzaNPosizioni boolean;
    declare correttezzaLivello boolean;
    declare correttezzaSkill boolean;

    -- nome dell'i-esima skill della lista passata come parametro alla procedura
    declare skillNome varchar(100);
    declare livelloSkill int;
    declare fineCursor boolean default false;

    -- definisco un cursore che scorrerà una tabella con n righe e una colonna contenente le skills passate come parametro
    -- il metodo json_table prende in input un oggetto json e ne ritorna una tabella
    declare skillCursore cursor for 
		select skill, livello from json_table(skillsRichiestaI,'$[*]' 
			columns (skill varchar(100) path '$.skill', livello varchar(1) path '$.livello')) as tabella;

    -- quanto il cursore non troverà righe da leggere imposterà la variabile booleana fineCursor a true
    declare continue handler for not found set fineCursor = true;

    -- il campo del profilo deve essere compilato e non deve contenere esclusivamente cifre
    set correttezzaProfilo = IF(nomeProfiloI = '' or nomeProfiloI is null or nomeProfiloI REGEXP '^[0-9]+$', false, true);
    -- se la query ritorna zero significa che non esiste nessun progetto avente il nome specificato
    set correttezzaProgetto = (SELECT count(*) from Progetto where Progetto.nome = nomeProgettoI and Progetto.tipoProgetto = "Software") > 0;
    -- il campo delle posizioni deve essere un numero intero positivo (unsigned ammette interi senza segno quindi per forza positivi)
    set correttezzaNPosizioni = (numeroPosizioniI REGEXP '^[0-9]+$' and CAST(numeroPosizioniI AS UNSIGNED));
   
    if(correttezzaProfilo and correttezzaProgetto and correttezzaNPosizioni) then
        INSERT IGNORE INTO Profilo VALUES (nomeProfiloI, nomeProgettoI, numeroPosizioniI);

        OPEN skillCursore;
        skill_loop: loop
            fetch skillCursore into skillNome, livelloSkill;

            -- se non ci sono ulteriori righe da leggere nella tabella esco dal ciclo
            if(fineCursor) then
                leave skill_loop;
            end if;

            -- controllo se la skill esiste
            set correttezzaSkill = (SELECT count(*) from Skill S where S.nome = skillNome) > 0;
            -- il campo livello deve essere un numero intero compreso tra 1 e 5
			set correttezzaLivello = (livelloSkill REGEXP '^[0-9]+$' and CAST(livelloSkill AS UNSIGNED) and livelloSkill < 6);
            
            if(correttezzaSkill and correttezzaLivello) then
                INSERT INTO Skill_Requisito VALUES (skillNome, nomeProfiloI, nomeProgettoI, livelloSkill);
            end if;
        end loop;
        CLOSE skillCursore;
    end if;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE checkCandidatura(IN nomeProfiloI VARCHAR(100), IN nomeProgettoI VARCHAR(255), IN emailUtenteI VARCHAR(255), IN sceltaCreatoreI VARCHAR(5))
BEGIN
    declare correttezzaNomeEProgetto boolean;
    declare correttezzaEmail boolean;
    declare candidaturaGiaPresente boolean default false;
	declare correttezzaSceltaCreatore boolean default false;
    
    -- il campo profilo deve coincidere un profilo esistente nel sistema
    set correttezzaNomeEProgetto = (SELECT count(*) from Profilo where Profilo.nome = nomeProfiloI and Profilo.nomeProgetto = nomeProgettoI) > 0;
    -- il campo email dell'utente deve esistere
    set correttezzaEmail = (SELECT count(*) from Utente where Utente.email = emailUtenteI) > 0;
    -- non deve esistere già una candidatura identica ancora aperta nel db
    set candidaturaGiaPresente = (SELECT count(*) from Candidatura C where
                                    C.nomeProfilo = nomeProfiloI and
                                    C.nomeProgetto = nomeProgettoI and
                                    C.emailUtente = emailUtenteI and
                                    C.stato = 'aperta') > 0;
	if(CAST(sceltaCreatoreI AS decimal(1,0))) then
		if(sceltaCreatoreI = 0 or sceltaCreatoreI = 1) then
			set correttezzaSceltaCreatore = true;
		end if;
    end if;

    if(correttezzaNomeEProgetto and correttezzaEmail and correttezzaSceltaCreatore and candidaturaGiaPresente) then
        UPDATE Candidatura C SET C.accettata = sceltaCreatoreI, C.stato = 'chiusa' where C.nomeProfilo = nomeProfiloI and 
																	 C.nomeProgetto = nomeProgettoI and 
                                                                     C.emailUtente = emailUtenteI and
                                                                     C.stato = 'aperta';
    end if;
END
$ DELIMITER ;

-- Inserimento di una competenza da parte di un utente amministratore
DELIMITER $ 
CREATE PROCEDURE InserimentoCompetenza(IN emailAmministratoreI VARCHAR(255), IN nomeCompetenzaI VARCHAR(255), OUT esito INT)
BEGIN
	declare amministratoreEsistente boolean;
    declare competenzaEsistente boolean;

    -- Controllo se l'utente è un amministratore
	set amministratoreEsistente = (SELECT COUNT(*) FROM Amministratore WHERE emailAmministratore = emailAmministratoreI) > 0;
    -- Controllo se la comptetenza non è già presente all'interno del sistema
	set competenzaEsistente = (SELECT COUNT(*) FROM Skill WHERE nome = nomeCompetenzaI) > 0;
    
    if (NOT(amministratoreEsistente) OR (competenzaEsistente)) then
		-- Restituisco 0 che indica che l'utente non è un amministratore o la competenza è già esistente
		set esito = 0; 
	else 
		INSERT INTO Skill (nome) VALUES (nomeCompetenzaI);
		-- Restituisco 1 che indica che l'inserimento della competenza è andata bene
		set esito = 1;
	end if;
END;
$ DELIMITER ;

-- Inserimento di una componente di tipo Hardware
DELIMITER $ 
CREATE PROCEDURE InserimentoComponenteHardware(IN nomeComponenteI VARCHAR(255), IN nomeProgettoI VARCHAR(255), IN descrI VARCHAR(255), IN prezzoI VARCHAR(255), IN quantitaI VARCHAR(255), OUT esito INT)
BEGIN
	declare progettoEsistente boolean;
    declare progettoHardware boolean;
    declare componenteEsistente boolean;
    
    -- Controllo se il progetto è esistente e se è di tipo "Hardware"
	set progettoEsistenteHardware = (SELECT COUNT(*) FROM Progetto WHERE nome = nomeProgettoI AND tipoProgetto = "Hardware") > 0;
	-- Controllo se il componente è già esistente per il progetto (non possono esserci duplicati ma per lo stesso componente possono esserci più quantita)
	set componenteEsistente = (SELECT COUNT(*) FROM Componente WHERE nome = nomeComponenteI AND nomeProgetto = nomeProgettoI) > 0;
    
    if ((NOT(progettoEsistenteHardware)) OR (componenteEsistente)) then
		-- Restituisco 0 che indica che il progetto non esiste o il progetto è software o il componente hardware è già presente
		set esito = 0; 
	else 
    	-- Cast dei parametri
        SET prezzoI = CAST(prezzoI AS DECIMAL(10,2));
        SET quantitaI = CAST(quantitaI AS UNSIGNED);
		INSERT INTO Componente (nome, nomeProgetto, prezzo, descr, quantita) VALUES (nomeComponenteI, nomeProgettoI, prezzoI, descrI, quantitaI);
		-- Restituisco 1 che indica che l'inserimento della componente hardware è andata a buon fine
		set esito = 1;
	end if;
END;
$ DELIMITER ;

-- Statistiche che vengono calcolate tramite le viste
-- Vista che visualizza la classifica degli utenti creatori, in base al loro valore di affidabilità (mostra solo i primi 3 nickname)
CREATE VIEW ClassificaCreatoriAffidabilita AS
SELECT Utente.nickname, Creatore.affidabilita
FROM Utente 
JOIN Creatore ON Utente.email = Creatore.emailCreatore
-- Ordino i creatori in base all'affidabilità in ordine decrescente
ORDER BY Creatore.affidabilita DESC
-- Restituisco solo i primi 3 come richiesto dalla consegna
LIMIT 3;  

-- Vista che visualizza i progetti aperti che sono più vicini al completamento, minore differenza tra budget_avvio e somma totale dei finanziamenti ricevuti (mostra solo i primi 3 progetti)
CREATE VIEW ProgettiApertiCompletamentoFinanziamento AS
 -- Calcolo la differenza tra budget e fondi ricevuti. COALESCE indica che se il progetto non ha ricevuto finanziamenti, la funzione non restituisce null ma 0
SELECT Progetto.nome, (Progetto.budget_avvio - COALESCE(SUM(Finanziamento.importo), 0)) AS budget_mancante 
FROM Progetto 
-- Utilizzo il LEFT JOIN per visualizzare anche eventuali progetti che non hanno ancora ricevuto un finanziamento (valore 0)
LEFT JOIN Finanziamento ON Progetto.nome = Finanziamento.nomeProgetto
WHERE Progetto.stato = "aperto"
GROUP BY Progetto.nome, Progetto.budget_avvio
-- Ordino in ordine crescente per vedere il budget dei progetti più vicini al completamento
ORDER BY budget_mancante ASC 
LIMIT 3;  

-- Vista che visualizza la classifica degli utenti ordinati in base al totale di finanziamenti erogati (mostra solo i primi 3 nickname)
CREATE VIEW ClassificaUtentiFinanziatori AS
 -- Sommo il totale dei vari finanziamenti del singolo utente con COALESCE che, nel caso non siano presenti finanziamenti, non restituisce null ma 0 
SELECT Utente.nickname, COALESCE(SUM(Finanziamento.importo), 0) AS totale_finanziamento 
FROM Utente 
-- Utilizzo il LEFT JOIN per visualizzare anche eventuali utenti che non hanno ancora fatto un finanziamento (valore 0)
LEFT JOIN Finanziamento ON Utente.email = Finanziamento.emailUtente
GROUP BY Utente.nickname
-- Ordino in modo decrescente per trovare quali utenti hanno finanziato di più
ORDER BY totale_finanziamento DESC  
LIMIT 3;

-- Popolamento delle tabelle con dati di esempio
CALL RegistrazioneAmministratore('mario.rossi@email.com', 'pass123', 'Mario', 'Rossi', 'Roma', 1985, 'marior85', 1001, @esito);
CALL RegistrazioneCreatore('giulia.bianchi@email.com', 'securePass', 'Giulia', 'Bianchi', 'Milano', 1990, 'giuly90', @esito);
CALL RegistrazioneCreatore('giulia.bianchi2@email.com', 'securePass', 'Giulia', 'Bianchi', 'Milano', 1990, 'giuly9015', @esito);
CALL RegistrazioneNormale('normal.user@email.com', 'userpw', 'User', 'Normal', 'Rimini', 2025, 'normalUser', @esito);

CALL CreazioneProgetto('SmartWatch AI', '25-9-2', 'Progetto innovativo di AI per smartwatch', 100000.00, 'Software', 'giulia.bianchi@email.com');
CALL CreazioneProgetto('Robot AI', '2025-05-10', "Progetto all'avanguardia per creare un robot con intelligenza artificiale", 200000.00, 'Hardware', 'giulia.bianchi@email.com');
CALL CreazioneProgetto('Robot AI2', '2025-05-10', "Progetto all'avanguardia per creare un robot con intelligenza artificiale", 300000.00, 'Hardware', 'giulia.bianchi2@email.com');

CALL InserimentoComponenteHardware('CPU Intel', 'SmartWatch AI', 'Processore Intel i9', '350.00', '5', @esito);
CALL InserimentoComponenteHardware('Scheda Madre', 'Robot AI', 'ASUS ROG STRIX', '200.00', '10', @esito);
CALL InserimentoComponenteHardware('SSD 1TB', 'Robot AI2', 'Unità SSD NVMe', '120.00', '15', @esito);

CALL CreazioneReward('reward1.jpg', 'T-shirt esclusiva1', 'SmartWatch AI', 'giulia.bianchi@email.com');
CALL CreazioneReward( 'reward2.jpg', 'T-shirt esclusiva2', 'SmartWatch AI', 'giulia.bianchi@email.com');
CALL CreazioneReward('reward3.jpg', 'T-shirt esclusiva3', 'SmartWatch AI', 'giulia.bianchi@email.com');
CALL CreazioneReward('reward4.jpg', 'T-shirt esclusiva4', 'SmartWatch AI', 'giulia.bianchi@email.com');

CALL InserimentoFinanziamento('SmartWatch AI', 10000.00, 'mario.rossi@email.com', @esito);
CALL SceltaReward(1, 'mario.rossi@email.com', 'SmartWatch AI');
-- questo secondo finanziamento non andrà a buon fine perchè lo stesso utente ne ha inviato uno per lo stesso progetto lo stesso giorno
CALL InserimentoFinanziamento('SmartWatch AI', 5000.00, 'mario.rossi@email.com', @esito);
CALL SceltaReward('1', 'mario.rossi@email.com', 'SmartWatch AI');
CALL InserimentoFinanziamento('SmartWatch AI', 20000.00, 'giulia.bianchi2@email.com', @esito);

CALL SceltaReward('2', 'giulia.bianchi2@email.com', 'SmartWatch AI');
CALL InserimentoCompetenza('mario.rossi@email.com', 'Machine Learning', @esito);
CALL InserimentoCompetenza('mario.rossi@email.com', 'Conoscenza lingua inglese', @esito);
CALL InserimentoCompetenza('mario.rossi@email.com', 'Cybersecurity', @esito);

CALL InserimentoSkillCurriculum('mario.rossi@email.com', 'Python', 5, @esito);
CALL InserimentoSkillCurriculum('mario.rossi@email.com', 'Machine Learning', 4, @esito);
CALL InserimentoSkillCurriculum('mario.rossi@email.com', 'Conoscenza lingua inglese', 2, @esito);
CALL RimozioneSkillCurriculum('mario.rossi@email.com', 'Conoscenza lingua inglese', @esito);

CALL InserimentoProfilo('Data Scientist', 'SmartWatch AI', 3,'[{"skill":"Python", "livello": 4},{"skill":"Machine Learning", "livello": 3}]');

CALL InserimentoCandidatura('Data Scientist', 'SmartWatch AI', 'mario.rossi@email.com');

CALL checkCandidatura('Data Scientist', 'SmartWatch AI', 'mario.rossi@email.com', true);

CALL CommentaProgetto('SmartWatch AI', 'mario.rossi@email.com', 'Sembra un progetto interessante', @esito);

CALL rispondiACommento(1, 'Grazie per il supporto!', 'giulia.bianchi@email.com');