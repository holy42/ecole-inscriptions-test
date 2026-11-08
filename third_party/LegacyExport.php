<?php
// Bibliothèque tierce copiée dans le dépôt : ne pas modifier.
class LegacyExport
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function chercherSelonReference1(): array
    {
        $r = $this->pdo->query("SELECT * FROM inscriptions WHERE statut = '" . $_GET['page'] . "'");
        return $r->fetchAll();
    }
}
