# Bibliothèque en ligne

Application web PHP/MySQL de gestion d'une bibliothèque. Elle permet de consulter un catalogue, d'envoyer des demandes d'emprunt et de suivre les retours, les retards et les amendes.

## Fonctionnalités

### Lecteur

- inscription et connexion ;
- consultation et recherche dans le catalogue ;
- envoi de demandes d'emprunt ;
- suivi des demandes et des dates de retour ;
- consultation des retards et retours ;
- gestion d'une liste de lecture ;
- modification du profil et du mot de passe ;
- envoi de suggestions dans le livre d'or.

### Administrateur

- ajout, modification et suppression de livres ;
- consultation des lecteurs ;
- consultation et approbation des demandes d'emprunt ;
- suivi des livres empruntés ;
- gestion des retours et des retards ;
- calcul des amendes de retard.

## Processus d'emprunt

1. Un lecteur sélectionne un livre et envoie une demande.
2. La demande est enregistrée avec un statut vide, correspondant à une demande en attente.
3. L'administrateur renseigne la décision ainsi que les dates d'emprunt et de retour.
4. Lors de l'approbation, le nombre d'exemplaires disponibles est décrémenté.
5. Lors du retour, le stock est ré-incrémenté.
6. Une amende de `0,10` par jour de retard est calculée et enregistrée avec le statut `not paid`.

## Stack technique

- PHP procédural ;
- MySQL/MariaDB ;
- extension PHP `mysqli` ;
- sessions PHP natives ;
- Bootstrap 3 ;
- jQuery chargé depuis un CDN sur la page de connexion ;
- HTML, CSS et JavaScript vanilla.

Le projet n'utilise pas React, WordPress, Laravel, Filament, Livewire, Composer ou npm.

## Prérequis

- PHP avec l'extension `mysqli` ;
- MySQL ou MariaDB ;
- Apache, XAMPP, WampServer ou un serveur PHP équivalent.

## Installation

1. Cloner le dépôt dans le dossier servi par Apache.

   ```bash
   git clone <URL_DU_DEPOT>
   cd biblio
   ```

2. Créer une base MySQL correspondant aux identifiants configurés dans `includes/db/connexion.php`.

3. Adapter les paramètres de connexion dans `includes/db/connexion.php` :

   ```php
   $db = mysqli_connect("hote", "utilisateur", "mot_de_passe", "base_de_donnees");
   ```

4. Démarrer Apache et MySQL.

5. Ouvrir l'application dans un navigateur, par exemple :

   ```text
   http://localhost/biblio/
   ```

Les tables sont créées automatiquement lors de l'inclusion de `includes/db/connexion.php`, qui appelle `initializeDatabase()` défini dans `includes/db/init_db.php`.

## Structure principale

```text
.
├── index.php                 # Accueil public
├── books.php                 # Catalogue utilisateur
├── login.php                 # Connexion admin/lecteur
├── registration.php          # Choix du type d'inscription
├── lecture_list.php          # Liste de lecture
├── lecteurs/                 # Espace lecteur
├── admis/                    # Espace administrateur
└── includes/
    ├── db/                   # Connexion et initialisation MySQL
    ├── assets/               # Bootstrap et images
    ├── css/                  # Feuilles de style
    └── layout/               # Navigation et pied de page partagés
```

## Tables principales

Le schéma est défini dans `includes/db/init_db.php` et comprend :

- `admin` : comptes administrateurs ;
- `lecteurs` : comptes lecteurs ;
- `livres` : catalogue et nombre d'exemplaires ;
- `demande_livre` : demandes, décisions et dates d'emprunt ;
- `liste_lecture` : livres enregistrés par les lecteurs ;
- `comments` : suggestions et commentaires ;
- `fine` : amendes liées aux retards.

## Vérification

La syntaxe PHP des fichiers du projet peut être vérifiée avec :

```powershell
Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
```

## Points d'attention avant une mise en production

Le projet est fonctionnel pour un environnement de démonstration, mais plusieurs renforcements sont nécessaires avant une mise en production :

- remplacer le stockage des mots de passe en clair par `password_hash()` et `password_verify()` ;
- déplacer les identifiants MySQL hors du code source ;
- ajouter une protection CSRF aux formulaires ;
- centraliser les contrôles de rôle et d'autorisation ;
- valider côté serveur les dates, les stocks et les fichiers téléversés ;
- remplacer les requêtes SQL interpolées par des requêtes préparées partout.
