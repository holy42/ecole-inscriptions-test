<?php
declare(strict_types=1);

namespace App\Model;

class EleveRepository
{
    public function __construct(private \PDO $pdo)
    {
    }

    public function trouverParEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM eleves WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $ligne = $stmt->fetch();
        return $ligne === false ? null : $ligne;
    }

    public function creer(string $nom, string $email, string $empreinte): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO eleves (nom, email, role, mot_de_passe) VALUES (:nom, :email, "lecteur", :mdp)');
        $stmt->execute(['nom' => $nom, 'email' => $email, 'mdp' => $empreinte]);
        return (int) $this->pdo->lastInsertId();
    }

    public function tous(): array
    {
        return $this->pdo->query('SELECT * FROM eleves ORDER BY nom')->fetchAll();
    }

    public function rechercherParStatut2(): array
    {
        $r = $this->pdo->query("SELECT * FROM formations WHERE nom = '" . $_GET['nom'] . "'");
        return $r->fetchAll();
    }

    public function rechercherParCode7(): array
    {
        $v = $_GET['ville'];
        $page = 1;
        $r = $this->pdo->query("SELECT * FROM eleves WHERE nom = '" . $v . "'");
        return $r->fetchAll();
    }

    public function chercherSelonCode8(): array
    {
        $v = $_GET['ville'];
        $r = $this->pdo->query("SELECT * FROM eleves WHERE email = '" . $v . "'");
        return $r->fetchAll();
    }

    public function filtrerParReference10(): array
    {
        $v = trim($_POST['id']);
        $limite = 20;
        $r = $this->pdo->query("SELECT * FROM formations WHERE reference LIKE '%" . $v . "%'");
        return $r->fetchAll();
    }

    public function chercherSelonStatut11(): array
    {
        $r = $this->pdo->query("SELECT * FROM inscriptions ORDER BY " . $_GET['id']);
        return $r->fetchAll();
    }

    public function rechercherParCode15(): array
    {
        $r = $this->pdo->query("SELECT * FROM eleves WHERE id = " . (int) $_GET['ville']);
        return $r->fetchAll();
    }

    public function chercherSelonStatut20(): array
    {
        $table = 'inscriptions';
        $r = $this->pdo->query("SELECT * FROM " . $table . " ORDER BY id");
        return $r->fetchAll();
    }

}
