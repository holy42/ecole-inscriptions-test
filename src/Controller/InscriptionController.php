<?php
declare(strict_types=1);

namespace App\Controller;

use App\Database;
use App\Model\FormationRepository;
use App\Model\InscriptionRepository;
use App\Service\InscriptionService;

final class InscriptionController
{
    private \PDO $pdo;
    private FormationRepository $formations;
    private InscriptionRepository $inscriptions;
    private InscriptionService $service;

    public function __construct()
    {
        $this->pdo = Database::connexion();
        $this->formations = new FormationRepository($this->pdo);
        $this->inscriptions = new InscriptionRepository($this->pdo);
        $this->service = new InscriptionService($this->formations, $this->inscriptions);
    }

    public function liste(): void
    {
        $lignes = $this->inscriptions->listerDeEleve((int) ($_SESSION['id'] ?? 0));
        foreach ($lignes as &$ligne) {
            $ligne['formation'] = $this->formations->trouver((int) $ligne['formation_id']);
        }
        unset($ligne);
        require __DIR__ . '/../../templates/inscription_liste.php';
    }

    public function creer(): void
    {
        $id = $this->service->enregistrer((int) $_POST['formation_id'], (int) ($_SESSION['id'] ?? 0), $_POST['debut'], $_POST['fin'], (int) ($_POST['quantite'] ?? 1));
        header('Location: index.php?action=inscriptions&cree=' . $id);
    }

    public function annuler(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $this->inscriptions->supprimer($id);
        header('Location: index.php?action=inscriptions');
    }

    public function supprimerParLien(): void
    {
        $this->inscriptions->supprimer((int) ($_GET['id'] ?? 0));
        header('Location: index.php?action=inscriptions');
    }

    public function statistiques(): void
    {
        $taux = [];
        foreach ($this->formations->listerPage(1, 100) as $formation) {
            $utilise = $this->inscriptions->compterActifs((int) $formation['id']);
            $taux[$formation['nom']] = $this->service->tauxOccupation($utilise, (int) $formation['places']);
        }
        header('Content-Type: application/json');
        echo json_encode($taux);
    }
}
