DROP SCHEMA IF EXISTS GreentalkDB;
CREATE SCHEMA GreentalkDB;

USE GreentalkDB;

CREATE TABLE brukertype (
	idbrukertype INT NOT NULL,
    brukertypenavn VARCHAR(45),
    CONSTRAINT brukertypePK PRIMARY KEY (idbrukertype)
);

CREATE TABLE bruker (
	idbruker INT AUTO_INCREMENT NOT NULL,
    brukernavn VARCHAR(45) UNIQUE NOT NULL,
    passord VARCHAR(45) NOT NULL,
    fnavn VARCHAR(45),
    enavn VARCHAR(45),
    epost VARCHAR(90) NOT NULL,
	feillogginnteller INT,
    feillogginnsiste DATETIME,
    telefonnummer VARCHAR(45),
    beskrivelse VARCHAR(1024),
    brukertype INT NOT NULL,
    CONSTRAINT brukerPK PRIMARY KEY (idbruker),
    CONSTRAINT brukerbrukertypeFK FOREIGN KEY (brukertype) REFERENCES brukertype(idbrukertype)
);

CREATE TABLE fylke (
	idfylke INT AUTO_INCREMENT NOT NULL,
    fylkenavn VARCHAR(45),
    CONSTRAINT fylkePK PRIMARY KEY(idfylke)
);

CREATE TABLE `event` (
	idevent INT AUTO_INCREMENT NOT NULL,
    eventnavn VARCHAR(45),
    eventtekst VARCHAR(1000),
    tidspunkt DATETIME,
    veibeskrivelse VARCHAR(250),
    idbruker INT NOT NULL,
    fylke INT NOT NULL,
    CONSTRAINT eventPK PRIMARY KEY (idevent),
    CONSTRAINT eventbrukerFK FOREIGN KEY (idbruker) REFERENCES bruker(idbruker),
    CONSTRAINT eventfylkeFK FOREIGN KEY (fylke) REFERENCES fylke(idfylke)
);

CREATE TABLE bilder (
	idbilder INT AUTO_INCREMENT NOT NULL,
    hvor VARCHAR(128),
    bilde BLOB,
    CONSTRAINT bilderPK PRIMARY KEY(idbilder)
);

CREATE TABLE eventbilde (
	`event` INT NOT NULL,
    bilde INT NOT NULL,
    CONSTRAINT eventbildeeventFK FOREIGN KEY(`event`) REFERENCES `event`(idevent),
    CONSTRAINT eventbildebilder FOREIGN KEY(bilde) REFERENCES bilder(idbilder),
    CONSTRAINT eventbildePK PRIMARY KEY (`event`,bilde)
);

CREATE TABLE brukerbilde (
	bruker INT NOT NULL,
    bilde INT NOT NULL,
    CONSTRAINT brukerbildebrukerFK FOREIGN KEY(bruker) REFERENCES bruker(idbruker),
    CONSTRAINT brukerbildebildeFK FOREIGN KEY(bilde) REFERENCES bilder(idbilder),
    CONSTRAINT brukerbildePK PRIMARY KEY(bruker, bilde)
);

CREATE TABLE interesse (
	idinteresse INT NOT NULL AUTO_INCREMENT,
    interessenavn VARCHAR(45),
    CONSTRAINT interessePK PRIMARY KEY (idinteresse)
);

CREATE TABLE brukerinteresse (
	bruker INT NOT NULL,
    interesse INT NOT NULL,
    CONSTRAINT brukerinteressebrukerFK FOREIGN KEY (bruker) REFERENCES bruker(idbruker),
    CONSTRAINT brukerinteresseinteresseFK FOREIGN KEY (interesse) REFERENCES interesse(idinteresse),
    CONSTRAINT brukerinteressePK PRIMARY KEY (bruker, interesse)
);

CREATE TABLE artikkel (
	idartikkel INT AUTO_INCREMENT NOT NULL,
    artnavn VARCHAR(45),
    artingress VARCHAR(255),
    arttekst VARCHAR(1000),
    bruker INT NOT NULL,
    tid DATETIME,
    slutt DATETIME,
    CONSTRAINT artikkelbrukerFK FOREIGN KEY (bruker) REFERENCES bruker(idbruker),
    CONSTRAINT artikkelPK PRIMARY KEY(idartikkel,bruker)
);

CREATE TABLE påmelding (
	event_id INT NOT NULL,
    bruker_id INT NOT NULL,
    interessert VARCHAR(25),
    CONSTRAINT påmeldingeventFK FOREIGN KEY (event_id) REFERENCES `event`(idevent),
    CONSTRAINT påmeldingbrukerFK FOREIGN KEY (bruker_id) REFERENCES bruker(idbruker),
    CONSTRAINT påmeldingPK PRIMARY KEY (event_id, bruker_id)
);

CREATE TABLE preferanse (
    idpreferanse INT AUTO_INCREMENT NOT NULL,
    visfnavn INT,
    visenavn INT,
    visepost INT,
    vistelefonnummer INT,
    visinteresser INT,
    visbeskrivelse INT,
    bruker INT NOT NULL,
    CONSTRAINT brukervisBrukerFK FOREIGN KEY (bruker) REFERENCES bruker(idbruker),
    CONSTRAINT brukervisPK PRIMARY KEY (idpreferanse)
);

CREATE TABLE melding (
    idmelding INT AUTO_INCREMENT NOT NULL,
    tittel VARCHAR(45),
    tekst VARCHAR(1024),
    tid DATETIME,
    lest CHAR(1),
    papirkurv CHAR(1),
    sender INT NOT NULL,
    mottaker INT NOT NULL,
    CONSTRAINT meldingBrukerFK FOREIGN KEY (sender) REFERENCES bruker(idbruker),
    CONSTRAINT meldingMotakkerFK FOREIGN KEY (mottaker) REFERENCES bruker(idbruker),
    CONSTRAINT meldingPK PRIMARY KEY(idmelding)
);

CREATE TABLE kommentar (
    idkommentar INT AUTO_INCREMENT NOT NULL,
    ingress VARCHAR(255),
    tekst VARCHAR(1024),
    tid DATETIME,
    artikkel INT NOT NULL,
    bruker INT NOT NULL,
    CONSTRAINT kommentarArtikkel FOREIGN KEY (artikkel) REFERENCES artikkel(idartikkel),
    CONSTRAINT kommentarBruker FOREIGN KEY (bruker) REFERENCES bruker(idbruker),
    CONSTRAINT kommentar PRIMARY KEY (idkommentar)
);


CREATE TABLE artikkelbilde (
    idartikkel INT NOT NULL,
    idbilde INT NOT NULL,
    CONSTRAINT artikkelbildeArtikkel FOREIGN KEY (idartikkel) REFERENCES artikkel(idartikkel),
    CONSTRAINT artikkelbildeBilde FOREIGN KEY (idbilde) REFERENCES bilder(idbilder),
    CONSTRAINT artikkelbildePK PRIMARY KEY (idartikkel, idbilde)
);

CREATE TABLE `advarsel` (
  `idadvarsel` int(11) NOT NULL AUTO_INCREMENT,
  `advarseltekst` varchar(1024) DEFAULT NULL,
  `bruker` int(11) NOT NULL,
  `administrator` int(11) NOT NULL,
  PRIMARY KEY (`idadvarsel`),
  KEY `adv_bruker_idx` (`bruker`),
  KEY `adv_admin_idx` (`administrator`),
  CONSTRAINT `adv_admin` FOREIGN KEY (`administrator`) REFERENCES `bruker` (`idbruker`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `adv_bruker` FOREIGN KEY (`bruker`) REFERENCES `bruker` (`idbruker`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE `brukerrapport` (
  `idbrukerrapport` int(11) NOT NULL AUTO_INCREMENT,
  `tekst` varchar(1024) DEFAULT NULL,
  `rapportbuker` int(11) NOT NULL,
  `rapportertav` int(11) NOT NULL,
  `dato` datetime DEFAULT NULL,
  PRIMARY KEY (`idbrukerrapport`),
  KEY `rapp_bruker_idx` (`rapportbuker`),
  KEY `rapp_av_idx` (`rapportertav`),
  CONSTRAINT `rapp_av` FOREIGN KEY (`rapportertav`) REFERENCES `bruker` (`idbruker`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `rapp_bruker` FOREIGN KEY (`rapportbuker`) REFERENCES `bruker` (`idbruker`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE `eksklusjon` (
  `ideksklusjon` int(11) NOT NULL AUTO_INCREMENT,
  `grunnlag` varchar(1024) DEFAULT NULL,
  `bruker` int(11) NOT NULL,
  `administrator` int(11) NOT NULL,
  `datofra` datetime DEFAULT NULL,
  `datotil` datetime DEFAULT NULL,
  PRIMARY KEY (`ideksklusjon`),
  KEY `eks_bruker_idx` (`bruker`),
  KEY `eks_admin_idx` (`administrator`),
  CONSTRAINT `eks_admin` FOREIGN KEY (`administrator`) REFERENCES `bruker` (`idbruker`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `eks_bruker` FOREIGN KEY (`bruker`) REFERENCES `bruker` (`idbruker`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE `misbruk` (
  `idmisbruk` int(11) NOT NULL AUTO_INCREMENT,
  `tekst` varchar(255) DEFAULT NULL,
  `bruker` int(11) NOT NULL,
  PRIMARY KEY (`idmisbruk`),
  KEY `mis_bruker_idx` (`bruker`),
  CONSTRAINT `mis_bruker` FOREIGN KEY (`bruker`) REFERENCES `bruker` (`idbruker`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE `regel` (
  `idregel` int(11) NOT NULL AUTO_INCREMENT,
  `regeltekst` varchar(255) DEFAULT NULL,
  `idbruker` int(11) DEFAULT NULL,
  PRIMARY KEY (`idregel`),
  KEY `bruker_idx` (`idbruker`),
  CONSTRAINT `admbruker` FOREIGN KEY (`idbruker`) REFERENCES `bruker` (`idbruker`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

INSERT INTO brukertype VALUES (1,"Administratør");
INSERT INTO brukertype VALUES (2,"Redaktør");
INSERT INTO brukertype VALUES (3,"Bruker");
INSERT INTO brukertype VALUES (4,"Bruker slettet");


INSERT INTO bruker (brukernavn, passord, fnavn, enavn,epost,telefonnummer,brukertype, beskrivelse) VALUES
	("mordi", "aca56ad314f0a4cc371e328067a7ec3168703326", "Mor", "Di", "mordi@gmail.com",NULL, 1,NULL),
    ("stifla", "aca56ad314f0a4cc371e328067a7ec3168703326", "Stian", "Flatset", "stian@gmail.com", NULL, 2, NULL),
    ("erlhol", "aca56ad314f0a4cc371e328067a7ec3168703326", "Erlend", "Hollund", "erlend.hollund29@gmail.com", NULL, 1, NULL),
    ("sanmaa", "aca56ad314f0a4cc371e328067a7ec3168703326", "Sonon", "Mårufs", "sonon.måruf@gmail.com", NULL, 1, NULL),
    ("hansin", "aca56ad314f0a4cc371e328067a7ec3168703326", "Hannah", "Singueo", "hannah.philadelphia@kremost.com", NULL, 1, NULL),
    ("sigeil", "aca56ad314f0a4cc371e328067a7ec3168703326", "Sogve", "Eilertsen", "sogve.voff@gmail.com", NULL, 1, NULL),
    ("mikmoh", "aca56ad314f0a4cc371e328067a7ec3168703326", "Mikkel", "Mohaugen", "mikkel.mohaugen@gmail.com", NULL, 1, NULL);

INSERT INTO preferanse VALUES
    (1,1,1,1,1,1,1,1),
    (2,1,1,1,1,1,1,2),
    (3,1,1,1,1,1,1,3),
    (4,1,1,1,1,1,1,4),
    (5,1,1,1,1,1,1,5),
    (6,1,1,1,1,1,1,6),
    (7,1,1,1,1,1,1,7);

INSERT INTO interesse (interessenavn) VALUES
	("Fisking"),
    ("Bil"),
    ("Fotball"),
    ("Liverpool"),
    ("Spilling"),
    ("Håndball"),
    ("Ishockey"),
    ("Riding"),
    ("Øl"),
    ("Raketter");
     


INSERT INTO brukerinteresse (bruker, interesse) VALUES
	(1,1),
    (1,3),
    (2,6),
    (2,3),
    (2,8),
    (4,1),
    (5,2),
    (3,1),
    (3,5),
    (3,10),
    (6,1),
    (6,4),
    (7,1),
    (7,4),
    (6,5);

INSERT INTO artikkel (artnavn, artingress, bruker) VALUES
    ("Gretas Ønsker", "Ønsker at alle resirkulerer", 1),
    ("Flaskepost i Båtsfjord", "Ny miljøvennlig transportmetode gjør at posten kommer fortere enn noen gang!", 1),
    ("Oljeborring i Lofoten", "Kommunene i ueninghet om oljeborring", 1),
    ("Plastposer bannlyst", "Nord-Korea har bannlyst bruk av plastposer", 1),
    ("Oppholdsvær meldt i Bergen", "'Veldig unormalt og tydelig tegn på at klimaet er i endring' - sier ekspert fra feltet", 1),
    ("Gretas Ønsker", "Ønsker at alle resirkulerer", 1),
    ("Gretas Ønsker", "Ønsker at alle resirkulerer", 1);

INSERT INTO fylke (fylkenavn) VALUES
    ("Oslo"),
    ("Rogaland"),
    ("Møre og Romsdal"),
    ("Nordland"),
    ("Troms og Finnmark"),
    ("Innlandet"),
    ("Vestfold og Telemark"),
    ("Agder"),
    ("Vestland"),
    ("Trøndelag"),
    ("Viken");
    
