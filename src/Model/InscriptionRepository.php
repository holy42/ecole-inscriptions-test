<?php
declare(strict_types=1);

namespace App\Model;

class InscriptionRepository
{
    public function __construct(private \PDO $pdo)
    {
    }

    public function pourFormation(int $formationId): array
    {
        $stmt = $this->pdo->prepare('SELECT debut, fin FROM inscriptions WHERE formation_id = :id AND statut = "actif"');
        $stmt->execute(['id' => $formationId]);
        return $stmt->fetchAll();
    }

    public function compterActifs(int $formationId): int
    {
        $stmt = $this->pdo->prepare('SELECT COALESCE(SUM(quantite), 0) FROM inscriptions WHERE formation_id = :id AND statut = "actif"');
        $stmt->execute(['id' => $formationId]);
        return (int) $stmt->fetchColumn();
    }

    public function listerDeEleve(int $eleveId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM inscriptions WHERE eleve_id = :id ORDER BY debut DESC');
        $stmt->execute(['id' => $eleveId]);
        return $stmt->fetchAll();
    }

    public function trouver(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM inscriptions WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();
        return $ligne === false ? null : $ligne;
    }

    public function creer(int $formationId, int $eleveId, string $debut, string $fin, int $quantite): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO inscriptions (formation_id, eleve_id, debut, fin, quantite, statut) VALUES (:a, :b, :debut, :fin, :quantite, "actif")');
        $stmt->execute(['a' => $formationId, 'b' => $eleveId, 'debut' => $debut, 'fin' => $fin, 'quantite' => $quantite]);
        return (int) $this->pdo->lastInsertId();
    }

    public function supprimer(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM inscriptions WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function rechercherParCritere3(): array
    {
        $r = $this->pdo->query("SELECT * FROM formations WHERE reference = '" . $_GET['id'] . "'");
        return $r->fetchAll();
    }

    public function rechercherParStatut12(): array
    {
        $r = $this->pdo->query("SELECT * FROM eleves ORDER BY " . $_GET['page']);
        return $r->fetchAll();
    }

    public function chercherSelonReference19(): array
    {
        $colonnes = ['nom', 'date', 'statut'];
        $tri = in_array($_GET['code'], $colonnes, true) ? $_GET['code'] : 'nom';
        $r = $this->pdo->query("SELECT * FROM eleves ORDER BY " . $tri);
        return $r->fetchAll();
    }

    public function chercherSelonReference25(): array
    {
        $v = $_GET['code'];
        $r = $this->pdo->query("SELECT * FROM eleves WHERE nom = '$v'");
        return $r->fetchAll();
    }

}
