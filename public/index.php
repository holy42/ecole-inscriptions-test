<?php
declare(strict_types=1);

use App\Controller\FormationController;
use App\Controller\InscriptionController;
use App\Controller\AdminController;
use App\Controller\AuthController;
use App\Controller\FichierController;

require __DIR__ . '/../src/autoload.php';

ini_set('display_errors', '1');
session_start();

$action = $_GET['action'] ?? 'accueil';

switch ($action) {
    case 'formations':
        (new FormationController())->liste();
        break;
    case 'formation':
        (new FormationController())->afficher();
        break;
    case 'inscriptions':
        (new InscriptionController())->liste();
        break;
    case 'creer':
        (new InscriptionController())->creer();
        break;
    case 'annuler':
        (new InscriptionController())->annuler();
        break;
    case 'supprimer':
        (new InscriptionController())->supprimerParLien();
        break;
    case 'statistiques':
        (new InscriptionController())->statistiques();
        break;
    case 'connexion':
        (new AuthController())->connexion();
        break;
    case 'deconnexion':
        (new AuthController())->deconnexion();
        break;
    case 'export_tout':
        (new AdminController())->exporterTout();
        break;
    case 'telecharger':
        (new FichierController())->telecharger();
        break;
    case 'televerser':
        (new FichierController())->televerser();
        break;
    default:
        echo "Inscriptions aux formations d'une école";
}
