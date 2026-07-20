## V1

### creation de database
(ok) login: (Noah)
(ok)    - page choix coté client/opérateur(Noah)
(ok)    - creation des roles(Noah)
(ok)    - autrhentification automatique pour client(Noah)

#### Coté opérateur

(ok) - Configuration des préfixes valable de l’opérateur:(Mitia)
(ok)     - CRUD préfixe(Mitia)
(ok) - Création de types d'opérations:(Mitia)
(ok)     - CRUD opération(Mitia)
(ok) - Situation gain via les différents frais (Noah)
(ok) - Situation des comptes clients (Mitia)
(ok)     - page historique des opérations(Mitia)


#### Coté client
(ok)  voir le solde : (Noah)
(ok)     - page pour voir solde actuel(Noah)
(ok) - opérations :(Noah)
(ok)     - page pour effectuer opérations: (depot retrait,transfert)(Noah)
(ok) - historique :(Noah)
(ok)     -page historique des opérations(Noah)


## V2

  ### Coté opérateur

(ok) Gestion des préfixes externes :
(ok)     Création d'une table dédiée (ex: autre_operateur) dans le fichier base.sql pour stocker les préfixes comme 032 (Mitia)
(ok)     CRUD pour permettre à l'administrateur d'ajouter des autres opérateurs (Mitia)
(ok)    Configuration des commissions :(Noah)
(ok)        Ajout d'un champ de configuration pour définir le pourcentage (%) de commission supplémentaire(Noah)
(ok)        Intégration de ce pourcentage dans le calcul des frais lors d'un transfert vers un numéro externe(Noah)
(ok)    Mise à jour de la page "Situation gain" pour ventiler les recettes : gains sur frais internes vs commissions sur transferts externes(Noah)
(ok)        Création d'un état récapitulatif calculant le cumul des montants envoyés vers chaque opérateur tiers pour la compensation(Noah)

### Coté client

(ok)   -Ajout d'une option "inclure frais de retrait" via une case à cocher sur le formulaire de transfert(Noah)
(ok)   -Calcul automatique : identifier les frais de retrait dans le barème v1 et les additionner au montant débité du compte de l'expéditeur(Noah)
(ok)   -Restriction : désactiver cette option pour les numéros externes (car aucun frais de retrait ne s'applique à l'extérieur)(Noah)
(ok)   Envois multiples :(Mitia)
(ok)   -Mise en place d'un champ de saisie acceptant plusieurs numéros simultanément(Mitia)
(ok)   -Logique de calcul : division du montant total saisi par le nombre de destinataires valides(Mitia)
(ok)   -Contrôle de validité : vérification que tous les numéros saisis appartiennent uniquement à l'opérateur local (l'envoi multiple externe est interdit)(Mitia)