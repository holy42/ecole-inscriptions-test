<?php
// Contrôles divers (affichage, configuration, exports, envois de fichiers). Code de TEST volontairement défectueux.
class ControlesSecurite
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // ---------- affichage
    public function afficherRecherche(): void
    {
        echo $_GET['q'];
        echo htmlspecialchars($_GET['q'], ENT_QUOTES);
    }

    public function afficherBienvenue(): void
    {
        echo "<p>Bonjour " . $_POST['nom'] . "</p>";
        echo "<p>" . htmlspecialchars($_POST['nom']) . "</p>";
    }

    public function afficherCommentaire(): void
    {
        $commentaire = $_POST['commentaire'] ?? '';
        echo $commentaire;
    }

    public function afficherEntete(): void
    {
        $titre = 'Liste des formations';
        echo "<h1>$titre</h1>";
    }

    public function afficherTotal(): void
    {
        $liste = [1, 2, 3];
        $nombre = count($liste);
        echo $nombre;
    }

    // ---------- configuration
    public function configurationCourrier(): array
    {
        $mot_de_passe_smtp = 'Smtp#2024-fictif';
        $hote = 'smtp.example.invalid';
        return [
            'hote' => $hote,
            'cle_api' => 'ak_live_fictif_93812',
            'nom' => 'service',
        ];
    }

    public function constantes(): void
    {
        define('JETON_SERVICE', 'jt_fictif_77231');
        $mot_de_passe_aide = 'Au moins 8 caractères avec un chiffre';
        $entete = [
            'token_type' => 'Bearer',
            'accept' => 'json',
        ];
        unset($mot_de_passe_aide, $entete);
    }

    // ---------- fonctions sensibles
    public function lirePanier(): mixed
    {
        $donnees = $_COOKIE['panier'] ?? '';
        $objet = unserialize($donnees);
        return $objet;
    }

    public function convertir(): string
    {
        $commande = 'convert ' . ($_GET['fichier'] ?? '') . ' sortie.png';
        exec($commande);
        return $commande;
    }

    public function dateServeur(): string
    {
        $sortie = shell_exec('date +%Y');
        return (string) $sortie;
    }

    public function copierConfiguration(array $config): array
    {
        $copie = unserialize(serialize($config));
        return $copie;
    }

    // ---------- inclusions
    public function chargerModule(): void
    {
        include 'modules/' . $_GET['page'] . '.php';
    }

    public function chargerConfiguration(): void
    {
        $racine = __DIR__ . '/../..';
        require_once $racine . '/config/config.php';
    }

    public function chargerGabarit(): void
    {
        $gabarit = __DIR__ . '/../../templates/' . 'liste.php';
        include $gabarit;
    }

    // ---------- empreintes
    public function empreinteMotDePasse(string $motDePasse): string
    {
        $hash = md5($motDePasse);
        return $hash;
    }

    public function empreinteAncienne(string $mdp): string
    {
        return sha1($mdp);
    }

    public function etagPage(string $passage, string $date): string
    {
        $etag = md5($passage . $date);
        return $etag;
    }

    public function cleCache(int $id): string
    {
        $cle = md5('pass_' . $id);
        return $cle;
    }

    // ---------- envois de fichiers
    public function enregistrerPhoto(): string
    {
        $dest = __DIR__ . '/../../storage/' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], $dest);
        return $dest;
    }

    public function enregistrerPiece(): string
    {
        $nom = basename($_FILES['piece']['name']);
        if (!$this->nomAutorise($nom)) {
            return '';
        }
        $dest = __DIR__ . '/../../storage/' . $nom;
        move_uploaded_file($_FILES['piece']['tmp_name'], $dest);
        return $dest;
    }

    private function nomAutorise(string $nom): bool
    {
        return (bool) preg_match('/\.(pdf|png)$/', $nom);
    }
}
