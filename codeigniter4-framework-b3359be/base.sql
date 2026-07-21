drop table if exists configuration;
CREATE TABLE configuration(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe VARCHAR(10) NOT NULL
);
drop table if exists type_operation;
CREATE TABLE type_operation(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nomType VARCHAR(50) NOT NULL
);

drop table if exists frais;
CREATE TABLE frais(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_type_operation INTEGER NOT NULL,
    montant_Min DECIMAL(10,2) NOT NULL,
    montant_Max DECIMAL(10,2) NOT NULL,
    valeur DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_type_operation) REFERENCES type_operation(id) ON DELETE CASCADE
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
    frais DECIMAL(10,2),
    commission DECIMAL(10,2),
    FOREIGN KEY (client_id) REFERENCES client(id) ON DELETE CASCADE,
    FOREIGN KEY (type_operation_id) REFERENCES type_operation(id) ON DELETE CASCADE
);

CREATE TABLE commission(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    taux DECIMAL(10,2) NOT NULL
);

create table promotion(
     id INTEGER PRIMARY KEY AUTOINCREMENT,
    promotion DECIMAL(10,2) NOT NULL
);

INSERT INTO commission (taux) VALUES (0.05);
INSERT INTO configuration (prefixe) VALUES ('022'),('030');
INSERT INTO type_operation (nomType) VALUES ('Transfert'),('Retrait'),('Depot');
INSERT INTO frais (montant_Min, montant_Max, valeur, id_type_operation) VALUES (100, 1000, 50, 1), (1001, 5000, 50, 1), (5001, 10000, 100, 1), (10001, 25000, 200, 1), (25001, 50000, 400, 1), (50001, 100000, 800, 1), (100001, 250000, 1500, 1), (250001, 500000, 1500, 1), (500001, 1000000, 2500, 1),(1000001, 2000000, 3000, 1),
(100, 1000, 50, 2), (1001, 5000, 50, 2), (5001, 10000, 100, 2), (10001, 25000, 200, 2), (25001, 50000, 400, 2), (50001, 100000, 700, 2), (100001, 250000, 1100, 2), (250001, 500000, 1100, 2), (500001, 1000000, 2200, 2),(1000001, 2000000, 3000, 2),
(100, 1000, 50, 3), (1001, 5000, 50, 3), (5001, 10000, 100, 3), (10001, 25000, 300, 3), (25001, 50000, 500, 3), (50001, 100000, 800, 3), (100001, 250000, 1200, 3), (250001, 500000, 1200, 3), (500001, 1000000, 2300, 3),(1000001, 2000000, 3500, 3);

DROP TABLE IF EXISTS autres_operateurs;
CREATE TABLE autres_operateurs(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe VARCHAR(10) NOT NULL,
    nomOperateur VARCHAR(50) NOT NULL
);
INSERT INTO autres_operateurs (prefixe, nomOperateur) VALUES ('038', 'Telma'), ('034', 'Telma');
INSERT INTO autres_operateurs (prefixe, nomOperateur) VALUES ('033', 'Orange'), ('032', 'Orange');