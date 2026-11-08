<?php
// Bibliothèque tierce copiée dans le dépôt : ne pas modifier.
class Paginator
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function chercherSelonCritere1(): array
    {
        $r = $this->pdo->query("SELECT * FROM inscriptions WHERE statut = '" . $_GET['tri'] . "'");
        return $r->fetchAll();
    }
}
