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
    numClub Integer NOT NULL auto_increment,
    NomClub Varchar (40) NOT NULL,
    adresse Varchar (40) NOT NULL,
    numTelephone CHAR(10),
    nombreAdherents Integer NOT NULL,
    ville Varchar (40) NOT NULL,
    departement Varchar (40) NOT NULL,
    region Varchar (40) NOT NULL,
    PRIMARY KEY (numClub)
);

/* Creation table UTILISATEUR */
Create Table UTILISATEUR
(    
    numUtilisateur Integer NOT NULL auto_increment,
    nom Varchar(40) NOT NULL,
    prenom Varchar(40) NOT NULL,
    age Varchar(3) NOT NULL,
    adresse Varchar(40),
    login Varchar(20) NOT NULL,
    motDePasse Varchar(40) NOT NULL,
    numClub Integer,
    PRIMARY KEY (numUtilisateur),
    FOREIGN KEY (numClub) REFERENCES CLUB(numClub)
);

/* Creation table PRESIDENT */
Create Table PRESIDENT
(
    prime Integer NOT NULL,
    numPresident Integer,
    PRIMARY KEY (numPresident),
    FOREIGN KEY (numPresident) REFERENCES UTILISATEUR(numUtilisateur)
);

/* Creation table EVALUATEUR */
Create Table EVALUATEUR
(
    specialite Varchar (40) NOT NULL,
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
    FOREIGN KEY (numDirecteur) REFERENCES UTILISATEUR(numUTILISATEUR)
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
   numConcours Integer NOT NULL auto_increment,
   theme VARCHAR(40) NOT NULL,
   descriptif TEXT NOT NULL,
   dateDebut DATE NOT NULL,
   dateFin DATE NOT NULL,
   etat VARCHAR(40) NOT NULL,
   numPresident Integer,
   PRIMARY KEY (numConcours),
   FOREIGN KEY (numPresident) REFERENCES PRESIDENT(numPresident)
);

Create table ParticipeClub
(
  numClub Integer,
  numConcours Integer,
  FOREIGN KEY (numClub) REFERENCES CLUB(numClub),
  FOREIGN KEY (numConcours) REFERENCES CONCOURS(numConcours)
);

Create table ParticipeCompetiteur
(
  numCompetiteur Integer,
  numConcours Integer,
  FOREIGN KEY (numCompetiteur) REFERENCES COMPETITEUR(numCompetiteur),
  FOREIGN KEY (numConcours) REFERENCES CONCOURS(numConcours)
);
