# Fonctionnalités à ajouter : Inscriptions aux formations d'une école

Chaque fonctionnalité relève de la catégorie « nouvelle fonctionnalité ». Difficulté : S (petite), M (moyenne), L (grande).

## F01 : Export CSV des inscriptions (S)

Permettre à un élève d'exporter la liste de ses inscriptions au format CSV depuis la page de liste.

Critères d'acceptation :
- Le bouton Exporter télécharge un fichier .csv encodé en UTF-8
- Seuls les enregistrements de l'utilisateur connecté sont exportés
- Les cellules commençant par =, +, - ou @ sont neutralisées (injection de formules)

Fichiers concernés : src/Controller/InscriptionController.php, src/Util/Csv.php, templates/inscription_liste.php

## F02 : Recherche multicritère des formations (M)

Ajouter à la liste une recherche par nom, référence et disponibilité, en conservant la pagination.

Critères d'acceptation :
- Requêtes préparées exclusivement
- Les critères se combinent (ET)
- La pagination conserve les filtres

Fichiers concernés : src/Model/FormationRepository.php, src/Controller/FormationController.php, templates/formation_liste.php

## F03 : Notification par e-mail à la création (M)

Envoyer un e-mail de confirmation à l'utilisateur lorsqu'un enregistrement est créé.

Critères d'acceptation :
- Un e-mail n'est envoyé qu'après une création réussie
- Un échec d'envoi n'annule pas la création mais est journalisé
- Le contenu ne contient aucune donnée sensible

Fichiers concernés : src/Service/InscriptionService.php, src/Util/Courrier.php (nouveau)

## F04 : Journal d'audit (L)

Enregistrer qui a créé, modifié ou supprimé quoi et quand, et le consulter (administrateur).

Critères d'acceptation :
- Table journal_audit créée par migration
- Chaque écriture ajoute une ligne (utilisateur, action, élément, date)
- Page de consultation réservée à l'administrateur

Fichiers concernés : database/schema.sql, src/Service/*.php, src/Controller/AdminController.php

## F05 : API JSON en lecture seule pour les formations (S)

Exposer une action renvoyant la liste paginée en JSON.

Critères d'acceptation :
- Réponse JSON valide avec Content-Type application/json
- Pagination via page et taille (taille maximale 50)
- Aucun champ sensible dans la réponse

Fichiers concernés : src/Controller/FormationController.php, public/index.php

## F06 : Rôles et permissions (L)

Distinguer lecteur, gestionnaire et administrateur, avec vérification côté serveur.

Critères d'acceptation :
- Le rôle est contrôlé à chaque action sensible
- Un lecteur ne peut ni créer ni supprimer
- Les accès refusés renvoient 403 et sont journalisés

Fichiers concernés : src/Service/AuthService.php, src/Controller/*.php

## F07 : Bulletin de notes par élève (M)

Générer un bulletin récapitulant les notes et la moyenne de chaque élève.

Critères d'acceptation :
- La moyenne est pondérée par les coefficients
- Un élève sans note affiche « non évalué »
- Export imprimable

Fichiers concernés : src/Service, templates

## F08 : Liste d'attente quand une formation est complète (L)

Mettre en file d'attente les élèves quand il n'y a plus de place.

Critères d'acceptation :
- Inscription automatique à la libération d'une place
- Ordre d'arrivée respecté
- Notification à l'élève

Fichiers concernés : src/Service, src/Model

## F09 : Pondération des notes (M)

Ajouter un coefficient à chaque formation pour calculer la moyenne générale.

Critères d'acceptation :
- Coefficient entier de 1 à 10
- La moyenne générale est recalculée à chaque modification
- Valeur invalide refusée

Fichiers concernés : src/Model, src/Service, database/schema.sql
