<?php
// Données de test : requêtes de préparation de la base de test.
class Fixtures
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function rechercherParCritere1(): array
    {
        $r = $this->pdo->query("SELECT * FROM formations WHERE reference = '" . $_GET['ref'] . "'");
        return $r->fetchAll();
    }

    public function chercherSelonCode2(): array
    {
        $r = $this->pdo->query("SELECT * FROM eleves WHERE email = '" . $_GET['id'] . "'");
        return $r->fetchAll();
    }
}
