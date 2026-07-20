
CREATE TABLE configuration(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe VARCHAR(10) NOT NULL
);
CREATE TABLE type_operation(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nomType VARCHAR(50) NOT NULL
);
CREATE TABLE frais(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    montant_Min DECIMAL(10,2) NOT NULL,
    montant_Max DECIMAL(10,2) NOT NULL,
    valeur DECIMAL(10,2) NOT NULL
);
CREATE TABLE client(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero VARCHAR(20) NOT NULL,
    solde DECIMAL(10,2) NOT NULL
);
DROP TABLE IF EXISTS historique;
CREATE TABLE historique(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id INTEGER NOT NULL,
    type_operation_id INTEGER NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    date_operation DATETIME NOT NULL,
    destinataire VARCHAR(20),
    FOREIGN KEY (client_id) REFERENCES client(id),
    FOREIGN KEY (type_operation_id) REFERENCES type_operation(id)
);

INSERT INTO configuration (prefixe) VALUES ('022'),('030');
INSERT INTO type_operation (nomType) VALUES ('Transfert'),('Retrait'),('Depot');
INSERT INTO frais (montant_Min, montant_Max, valeur) VALUES (100, 1000, 50), (1001, 5000, 50), (5001, 10000, 100), (10001, 25000, 200), (25001, 50000, 400), (50001, 100000, 800), (100001, 250000, 1500), (250001, 500000, 1500), (500001, 1000000, 2500),(1000001, 2000000, 3000);