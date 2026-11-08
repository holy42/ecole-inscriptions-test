<?php
declare(strict_types=1);

namespace App\Model;

use App\Database;

class FormationRepository
{
    public function __construct(private \PDO $pdo)
    {
    }

    public function trouver(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM formations WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();
        return $ligne === false ? null : $ligne;
    }

    public function listerPage(int $page, int $taille): array
    {
        $decalage = $page * $taille;
        $stmt = $this->pdo->prepare('SELECT * FROM formations ORDER BY nom LIMIT :limite OFFSET :decalage');
        $stmt->bindValue('limite', $taille, \PDO::PARAM_INT);
        $stmt->bindValue('decalage', $decalage, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function ajusterQuantite(int $id, int $delta): void
    {
        $stmt = $this->pdo->prepare('UPDATE formations SET places = places + :delta WHERE id = :id');
        $stmt->execute(['delta' => $delta, 'id' => $id]);
    }

    public function compter(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM formations')->fetchColumn();
    }

    public function rechercherParReference4(): array
    {
        $r = $this->pdo->query("INSERT INTO formations (nom) VALUES ('" . $_POST['code'] . "')");
        return [];
    }

    public function filtrerParCode14(): array
    {
        $r = $this->pdo->query("SELECT * FROM eleves WHERE id = " . (int) $_GET['ref']);
        return $r->fetchAll();
    }

    public function rechercherParReference16(): array
    {
        $id = intval($_GET['q']);
        $page = 1;
        $r = $this->pdo->query("SELECT * FROM eleves WHERE id = " . $id);
        return $r->fetchAll();
    }

    public function filtrerParCritere17(): array
    {
        $id = intval($_GET['tri']);
        $r = $this->pdo->query("SELECT * FROM eleves WHERE id = " . $id);
        return $r->fetchAll();
    }

    public function rechercherParCode21(): array
    {
        $table = 'formations';
        $r = $this->pdo->query("SELECT * FROM " . $table . " ORDER BY id");
        return $r->fetchAll();
    }

    public function chercherSelonNom22(): array
    {
        $r = $this->pdo->query("SELECT * FROM formations WHERE nom = " . $this->pdo->quote($_GET['ref']));
        return $r->fetchAll();
    }

    public function filtrerParCritere23(): array
    {
        $r = $this->pdo->query("SELECT * FROM eleves WHERE nom = " . $this->pdo->quote($_GET['statut']));
        return $r->fetchAll();
    }

    public function rechercherParStatut26(): array
    {
        $sql = "SELECT * FROM formations WHERE reference = '";
        $sql .= $_GET['q'];
        $sql .= "'";
        $r = $this->pdo->query($sql);
        return $r->fetchAll();
    }

    public function chercherSelonCritere28(): array
    {
        $this->pdo->exec("DELETE FROM eleves WHERE id = " . $_GET['ville']);
        return [];
    }

    public function filtrerParReference29(): array
    {
        $this->pdo->exec("DELETE FROM eleves WHERE id = " . $_GET['code']);
        return [];
    }

}
