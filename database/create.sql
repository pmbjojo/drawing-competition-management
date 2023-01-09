/* Detruire les tables si elles existent */
drop table if exists JURY;
drop table if exists EVALUATION;
drop table if exists DESSIN;
drop table if exists PARTICIPE_CLUB;
drop table if exists PARTICIPE_COMPETITEUR;
drop table if exists CONCOURS;
drop table if exists DIRIGE;
drop table if exists DIRECTEUR;
drop table if exists ADMINISTRATEUR;
drop table if exists COMPETITEUR;
drop table if exists EVALUATEUR;
drop table if exists PRESIDENT;
drop table if exists UTILISATEUR;
drop table if exists CLUB;

/* Creation table Club */
Create Table CLUB
(    
    numClub Integer auto_increment,
    NomClub Varchar (40),
    adresse Varchar (40),
    numTelephone CHAR(10),
    nombreAdherents Integer,
    ville Varchar (40),
    departement Varchar (40),
    region Varchar (40),
    PRIMARY KEY (numClub)
);

/* Creation table UTILISATEUR */
Create Table UTILISATEUR
(    
    numUtilisateur Integer auto_increment,
    nom Varchar(40),
    prenom Varchar(40),
    age Varchar(3),
    adresse Varchar(40),
    login Varchar(20),
    motDePasse Varchar(40),
    numClub Integer,
    dateInscription DATE,
    PRIMARY KEY (numUtilisateur),
    FOREIGN KEY (numClub) REFERENCES CLUB(numClub)
);

/* Creation table PRESIDENT */
Create Table PRESIDENT
(
    prime Integer ,
    numPresident Integer,
    PRIMARY KEY (numPresident),
    FOREIGN KEY (numPresident) REFERENCES UTILISATEUR(numUtilisateur)
);

/* Creation table EVALUATEUR */
Create Table EVALUATEUR
(
    specialite Varchar (40),
    numEvaluateur Integer,
    PRIMARY KEY (numEvaluateur),
    FOREIGN KEY (numEvaluateur) REFERENCES UTILISATEUR(numUtilisateur)
);

/* Creation table COMPETITEUR */
Create Table COMPETITEUR
(
    datePremiereParticipation DATE,
    numCompetiteur Integer,
    PRIMARY KEY (numCompetiteur),
    FOREIGN KEY (numCompetiteur) REFERENCES UTILISATEUR(numUtilisateur)
);

/* Creation table ADMINISTRATEUR */
Create Table ADMINISTRATEUR
(
    dateDebut DATE,
    numAdministrateur Integer,
    PRIMARY KEY (numAdministrateur),
    FOREIGN KEY (numAdministrateur) REFERENCES UTILISATEUR(numUtilisateur)
);

/* Creation table DIRECTEUR */
Create Table DIRECTEUR
(
    dateDebut DATE,
    numDirecteur Integer,
    PRIMARY KEY (numDirecteur),
    FOREIGN KEY (numDirecteur) REFERENCES UTILISATEUR(numUtilisateur)
);

/* Creation table DIRIGE */
Create Table DIRIGE
(
    numCub Integer,
    numDirecteur Integer,
    PRIMARY KEY (numCub ,numDirecteur),
    FOREIGN KEY (numCub ) REFERENCES CLUB(numClub),
    FOREIGN KEY (numDirecteur) REFERENCES DIRECTEUR(numDirecteur)
);

/* Creation table CONCOURS */
Create Table CONCOURS
(
   numConcours Integer auto_increment,
   theme VARCHAR(40),
   descriptif TEXT,
   dateDebut DATE,
   dateFin DATE,
   etat VARCHAR(40),
   numPresident Integer,
   PRIMARY KEY (numConcours),
   FOREIGN KEY (numPresident) REFERENCES PRESIDENT(numPresident)
);

/* Creation table PARTICIPE_CLUB */
Create table PARTICIPE_CLUB
(
  numClub Integer,
  numConcours Integer,
  FOREIGN KEY (numClub) REFERENCES CLUB(numClub),
  FOREIGN KEY (numConcours) REFERENCES CONCOURS(numConcours)
);

/* Creation table PARTICIPE_COMPETITEUR */
Create table PARTICIPE_COMPETITEUR
(
  numCompetiteur Integer,
  numConcours Integer,
  FOREIGN KEY (numCompetiteur) REFERENCES COMPETITEUR(numCompetiteur),
  FOREIGN KEY (numConcours) REFERENCES CONCOURS(numConcours)
);

/* Creation table JURY */
Create table JURY
(
    numConcours Integer,
    numEvaluateur Integer,
    PRIMARY KEY (numConcours,numEvaluateur),
    FOREIGN KEY (numConcours) REFERENCES CONCOURS(numConcours),
    FOREIGN KEY (numEvaluateur) REFERENCES EVALUATEUR(numEvaluateur)
);

/* Creation table DESSIN */
Create table DESSIN
(
    numDessin Integer auto_increment,
    commentaire VARCHAR(200),
    classement Integer,
    dateRemise DATE,
    leDessin binary,
    numConcours Integer,
    numCompetiteur Integer,
    PRIMARY KEY (numDessin),
    FOREIGN KEY (numConcours) REFERENCES CONCOURS(numConcours),
    FOREIGN KEY (numCompetiteur) REFERENCES COMPETITEUR(numCompetiteur)
);

/* Creation table EVALUATION */
Create table EVALUATION
(
    numEvaluateur Integer,
    numDessin Integer,
    dateEvaluation DATE,
    note Integer,
    commentaire VARCHAR(200),
    PRIMARY KEY (numEvaluateur, numDessin, dateEvaluation),
    FOREIGN KEY (numDessin) REFERENCES DESSIN(numDessin),
    FOREIGN KEY (numEvaluateur) REFERENCES UTILISATEUR(numUtilisateur)
);