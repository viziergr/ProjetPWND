CREATE TABLE `AnneeScolaire`(
    idAnneeScolaire INT PRIMARY KEY,
    nom VARCHAR(30)
);

CREATE TABLE `Etudiant`(
    id INT PRIMARY KEY,
    nom VARCHAR(30),
    prenom VARCHAR(30),
    photo VARCHAR(255),
    anneeScolaire INT,
    date_Inscription DATE,
    date_Modif DATE,
    descriptionEtudiant TEXT,
    FOREIGN KEY (anneeScolaire) REFERENCES AnneeScolaire(idAnneeScolaire)
);

CREATE TABLE `Amis`(
    etudiant1_id INT,
    etudiant2_id INT,
    statut ENUM('en attente','valide','refuse'),
    dateAjout DATE,
    PRIMARY KEY (etudiant1_id, etudiant2_id),
    FOREIGN KEY (etudiant1_id) REFERENCES Etudiant(id),
    FOREIGN KEY (etudiant2_id) REFERENCES Etudiant(id)
);

CREATE TABLE `Article`(
    idArticle INT PRIMARY KEY,
    contenu TEXT,
    dateCreation DATE,
    visibilite ENUM('public','ami'),
    media VARCHAR(255),
    auteur INT,
    FOREIGN KEY (auteur) REFERENCES Etudiant(id)
);

CREATE TABLE `Notification`(
    idNotif INT PRIMARY KEY,
    typeNotif ENUM('nouveau message','demande ajout','nouveau groupe','nouvel utilisateur'),
    statutLecture ENUM('oui','non'),
    statutSuppr ENUM('oui','non'),
    dateAjout DATE,
    emetteur INT,
    FOREIGN KEY (emetteur) REFERENCES Etudiant(id),
    receveur INT,
    FOREIGN KEY (receveur) REFERENCES Etudiant(id)
);

CREATE TABLE `Conversation`(
    idConversation INT PRIMARY KEY,
    nom VARCHAR(30),
    dateCreation VARCHAR(30),
    imageConversation VARCHAR(255)
);

CREATE TABLE `Etudiant_Conversation`(
    etudiant_id INT,
    conversation_id INT,
    PRIMARY KEY (etudiant_id, conversation_id),
    FOREIGN KEY (etudiant_id) REFERENCES Etudiant(id),
    FOREIGN KEY (conversation_id) REFERENCES Conversation(idConversation)
);

CREATE TABLE `Message`(
    idMessage INT PRIMARY KEY,
    contenu text,
    dateEnvoi DATE,
    emetteur INT,
    FOREIGN KEY (emetteur) REFERENCES Etudiant(id),
    conversation_id INT,
    FOREIGN KEY (conversation_id) REFERENCES Conversation(idConversation)
);

INSERT INTO `AnneeScolaire`(idAnneeScolaire,nom)
VALUE
	(1,'E1'),
    (2,'E2'),
    (3,'E3e'),
    (4,'E3a'),
    (5,'E4e'),
    (6,'E4a'),
    (7,'E5e'),
    (8,'E5a');

INSERT INTO `Etudiant`(id,nom,prenom,photo,anneeScolaire,date_Inscription,date_Modif,descriptionEtudiant)
VALUE
    (1,'WAKIM','Pierre',NULL,2,'2023-12-05','2023-12-05','Etudiant en E2'),
    (2,'VINCENT','Arthur',NULL,3,'2023-12-05','2023-12-05','Etudiant en E3e'),
    (3,'PICARD','Florian',NULL,3,'2023-12-05','2023-12-05','Etudiant en E3e'),
    (4,'POTTIER','Kévin',NULL,3,'2023-12-05','2023-12-05','Etudiant en E3e'),
    (5,'RIAUX','Eliott',NULL,3,'2023-12-05','2023-12-05','Etudiant en E3e'),
    (6,'RACKI','Julien',NULL,3,'2023-12-05','2023-12-05','Etudiant en E3e'),
    (7,'VIZIER','Grégoire',NULL,3,'2023-12-05','2023-12-05','Etudiant en E3e');

INSERT INTO `Article`(idArticle,contenu,dateCreation,visibilite,media,auteur)
VALUE
    (1,"Ceci est un article public","2023-12-05","public",NULL,1),
    (2,"Ceci est un article privé","2023-12-05","ami",NULL,1),
    (3,"Ceci est un article public","2023-12-05","public",NULL,2),
    (4,"Ceci est un article public","2023-12-05","public",NULL,3);

INSERT INTO `Amis`(etudiant1_id,etudiant2_id,statut,dateAjout)
VALUE
    (5,1,"refuse",'2023-12-05'),
    (2,1,"en attente",'2023-12-05'),
    (4,2,"en attente",'2023-12-05'),
    (5,3,"en attente",'2023-12-05'),
    (1,4,"en attente",'2023-12-05'),
    (4,1,"valide","2023-13-05");
UPDATE `Amis` SET statut = "valide" WHERE etudiant1_id = 1 AND etudiant2_id = 4;
INSERT INTO `Amis`(etudiant1_id,etudiant2_id,statut,dateAjout)
VALUE
    (4,5,"en attente",'2023-12-05'),
    (5,4,"valide","2023-13-05");
UPDATE `Amis` SET statut = "valide" WHERE etudiant1_id = 4 AND etudiant2_id = 5;
INSERT INTO `Notification`(idNotif,typeNotif,statutLecture,statutSuppr,dateAjout,emetteur,receveur)
VALUE
    (1,"demande ajout","oui","oui","2023-12-05",5,1),
    (2,"demande ajout","non","non","2023-12-05",2,1),
    (3,"demande ajout","non","non","2023-12-05",4,2),
    (4,"demande ajout","non","non","2023-12-05",5,3),
    (5,"demande ajout","oui","oui","2023-12-05",1,4),
    (6,"nouvel utilisateur","non","non","2023-12-05",4,5),
    (7,"demande ajout","oui","oui","2023-12-05",4,5),
    (8,"nouvel utilisateur","non","non","2023-12-05",5,4);

INSERT INTO `Conversation`(idConversation,nom,dateCreation,imageConversation)
VALUE
    (1,"le gros, la taupe et la calvasse","2023-12-05",NULL);

INSERT INTO `Etudiant_Conversation`(etudiant_id,conversation_id)
VALUE
    (1,1),
    (2,1),
    (7,1);

INSERT INTO `Notification`(idNotif,typeNotif,statutLecture,statutSuppr,dateAjout,emetteur,receveur)
VALUE
    (9,"nouveau groupe","non","non","2023-12-05",1,1),
    (10,"nouveau groupe","non","non","2023-12-05",2,1),
    (11,"nouveau groupe","non","non","2023-12-05",7,1);

INSERT INTO `Message` VALUE (1,"Demain macdo pour le double Big Mac ?","2023-12-05",1,1);

INSERT INTO `Notification` VALUE 
    (12,"nouveau message","non","non","2023-12-05",1,2),
    (13,"nouveau message","non","non","2023-12-05",1,7);
INSERT INTO `Message` VALUE (2,"Oh que oui","2023-12-05",2,1),

INSERT INTO `Notification` VALUE 
    (14,"nouveau message","non","non","2023-12-05",2,1),
    (15,"nouveau message","non","non","2023-12-05",2,7);
INSERT INTO `Message` VALUE (3,"Greg t'es chaud ?","2023-12-05",1,1),

INSERT INTO `Notification` VALUE 
    (16,"nouveau message","non","non","2023-12-05",1,2),
    (17,"nouveau message","non","non","2023-12-05",1,7);

INSERT INTO `Message` VALUE (4,"Allez","2023-12-05",7,1);

INSERT INTO `Notification` VALUE 
    (18,"nouveau message","non","non","2023-12-05",7,1),
    (19,"nouveau message","non","non","2023-12-05",7,2);

-- Afficher la liste des étudiants qui appartiennent à l'année E3e
SELECT * FROM Etudiant WHERE anneeScolaire = 3;

-- Afficher la liste des articles le prenom, le nom et l'annee scolaire de l'auteur ainsi que la date de création et la visibilité de l'article
SELECT prenom,nom,anneeScolaire,contenu,dateCreation,visibilite FROM Etudiant,Article WHERE visibilite = "public" AND WHERE Etudiant.id = Article.auteur ORDER BY nom ASC, prenom ASC;

-- Afficher la liste des articles avec le prénom, le nom et l’année scolaire de l’auteur, ainsi que la date de création et la visibilité. Les résultats sont triés par nom d’auteur croissant et date de création décroissante.
SELECT prenom,nom,anneeScolaire,contenu,dateCreation,visibilite FROM Etudiant,Article WHERE Etudiant.id = Article.auteur ORDER BY nom ASC, dateCreation DESC;

-- Afficher le nombre d'étudiants enregistrés
SELECT COUNT(*) FROM Etudiant;

SELECT nom,prenom,dateAjout FROM Etudiant,Amis WHERE Etudiant.id = Amis.etudiant1_id AND Amis.etudiant2_id = 4 AND Amis.statut = "valide" SORT BY dateAjout ASC;


SELECT * FROM Notification WHERE receveur = 1 ORDER BY typeNotif ASC, dateAjout ASC

SELECT dateAjout,contenu,prenom FROM Conversation WHERE idConversation = 1; 

SELECT Message.dateEnvoi,contenu,Etudiant.prenom FROM Conversation,Message,Etudiant WHERE idConversation = 1 AND Message.conversation_id = 1 AND Etudiant.id = emetteur;

