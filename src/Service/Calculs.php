<?php
// Calculs de tarifs et de remises. Code de TEST volontairement défectueux (erreurs que seul un outil qui suit les types voit).
class CalculsService
{
    public function prixAvecRemise(float $prix, int $quantite): float
    {
        return $prix * $quantite - $remise;
    }

    public function libelleStatut(bool $actif): string
    {
        if ($actif) {
            $libelle = 'Actif';
        }
        return strtoupper($libelle);
    }

    public function titrePage(): string
    {
        include __DIR__ . '/../../config/titres.php';
        return $titre_page;
    }

    public function montantFormate(float $montant): string
    {
        return formater_montant_eur($montant);
    }

    public function totalAvecTva(float $montant): float
    {
        return $montant + $this->calculerTva($montant);
    }

    public function cleEnCache(string $cle): mixed
    {
        return ioncube_read_file($cle);
    }

    public function referenceCourte(int $numero): string
    {
        return $numero * 10;
    }

    public function longueurNom(): int
    {
        return strlen(['nom', 'prenom']);
    }

    public function arrondi(float $valeur): float
    {
        return round($valeur, 2, PHP_ROUND_HALF_UP, 'trop');
    }

    public function moyenne(float $somme): float
    {
        return $somme / 0;
    }

    public function ancienCalcul(int $n): int
    {
        return $n * 2;
        $n = 0;
    }

    public function nomValide(string $nom): bool
    {
        $ok = is_string($nom);
        return $ok;
    }
}
