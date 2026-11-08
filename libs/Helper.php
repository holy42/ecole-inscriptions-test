<?php
// Utilitaires partagés (ancienne bibliothèque interne).
class Helper
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function chercherSelonNom1(): array
    {
        $r = $this->pdo->query("SELECT * FROM inscriptions WHERE statut = '" . $_GET['tri'] . "'");
        return $r->fetchAll();
    }
}
