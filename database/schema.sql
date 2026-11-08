-- Schéma de la base (MySQL) de l'application Inscriptions aux formations d'une école.
CREATE TABLE formations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(120) NOT NULL,
    reference VARCHAR(40) NOT NULL UNIQUE,
    places INT NOT NULL DEFAULT 0,
    actif TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE eleves (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    role VARCHAR(20) NOT NULL DEFAULT 'lecteur',
    mot_de_passe VARCHAR(255) NOT NULL
);

CREATE TABLE inscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    formation_id INT NOT NULL,
    eleve_id INT NOT NULL,
    debut DATE NOT NULL,
    fin DATE NOT NULL,
    retour_le DATE NULL,
    quantite INT NOT NULL DEFAULT 1,
    statut VARCHAR(20) NOT NULL DEFAULT 'actif',
    FOREIGN KEY (formation_id) REFERENCES formations(id),
    FOREIGN KEY (eleve_id) REFERENCES eleves(id)
);
