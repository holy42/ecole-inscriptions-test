<?php
declare(strict_types=1);

namespace App\Controller;

use App\Database;
use App\Model\FormationRepository;
use App\Service\FormationService;

final class FormationController
{
    private \PDO $pdo;
    private FormationRepository $formations;

    public function __construct()
    {
        $this->pdo = Database::connexion();
        $this->formations = new FormationRepository($this->pdo);
    }

    public function liste(): void
    {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $formations = $this->formations->listerPage($page, 10);
        $service = new FormationService();
        foreach ($formations as &$formation) {
            $formation['etat'] = $service->libelleStatut((int) $formation['places']);
        }
        unset($formation);
        require __DIR__ . '/../../templates/formation_liste.php';
    }

    public function afficher(): void
    {
        $formation = $this->formations->trouver((int) ($_GET['id'] ?? 0));
        $titre = strtoupper($formation['nom']);
        require __DIR__ . '/../../templates/formation_fiche.php';
    }

    public function rechercherParCritere1(): array
    {
        $r = $this->pdo->query("SELECT * FROM inscriptions WHERE statut = '" . $_GET['code'] . "'");
        return $r->fetchAll();
    }

    public function filtrerParNom5(): array
    {
        $r = $this->pdo->query("INSERT INTO formations (nom) VALUES ('" . $_POST['page'] . "')");
        return [];
    }

    public function chercherSelonNom6(): array
    {
        $r = $this->pdo->query("SELECT * FROM eleves WHERE nom = '" . $_COOKIE['code'] . "'");
        return $r->fetchAll();
    }

    public function filtrerParReference9(): array
    {
        $v = trim($_POST['ville']);
        $page = 1;
        $r = $this->pdo->query("SELECT * FROM formations WHERE reference LIKE '%" . $v . "%'");
        return $r->fetchAll();
    }

    public function filtrerParReference13(): array
    {
        $r = $this->pdo->query("SELECT * FROM eleves WHERE id = " . (int) $_GET['page']);
        return $r->fetchAll();
    }

    public function rechercherParStatut18(): array
    {
        $colonnes = ['nom', 'date', 'statut'];
        $tri = in_array($_GET['q'], $colonnes, true) ? $_GET['q'] : 'nom';
        $r = $this->pdo->query("SELECT * FROM formations ORDER BY " . $tri);
        return $r->fetchAll();
    }

    public function rechercherParStatut24(): array
    {
        $v = $_GET['cat'];
        $r = $this->pdo->query("SELECT * FROM eleves WHERE email = '$v'");
        return $r->fetchAll();
    }

    public function rechercherParReference27(): array
    {
        $sql = "SELECT * FROM inscriptions WHERE statut = '";
        $sql .= $_GET['nom'];
        $sql .= "'";
        $r = $this->pdo->query($sql);
        return $r->fetchAll();
    }

}
