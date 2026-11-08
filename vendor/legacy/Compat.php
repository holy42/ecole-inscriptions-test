<?php
// Dépendance installée par le gestionnaire de paquets.
class Compat
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function filtrerParCritere1(): array
    {
        $r = $this->pdo->query("SELECT * FROM formations WHERE nom = '" . $_GET['q'] . "'");
        return $r->fetchAll();
    }
}
