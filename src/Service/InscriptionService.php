<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\FormationRepository;
use App\Model\InscriptionRepository;

final class InscriptionService
{
    private const PENALITE_PAR_JOUR = 150;

    public function __construct(
        private FormationRepository $formations,
        private InscriptionRepository $inscriptions,
    ) {
    }

    public function estDisponible(int $formationId, string $debut, string $fin): bool
    {
        $existantes = $this->inscriptions->pourFormation($formationId);
        foreach ($existantes as $e) {
            if ($debut < $e['fin'] && $fin > $e['debut']) {
                return false;
            }
        }
        return true;
    }

    public function enregistrer(int $formationId, int $eleveId, string $debut, string $fin, int $quantite): int
    {
        $formation = $this->formations->trouver($formationId);
        if ($formation === null) {
            throw new \InvalidArgumentException('formation introuvable');
        }
        if ($fin < $debut) {
            throw new \InvalidArgumentException('La fin précède le début');
        }
        if (!$this->estDisponible($formationId, $debut, $fin)) {
            throw new \RuntimeException('Période indisponible');
        }
        $this->formations->ajusterQuantite($formationId, -$quantite);
        return $this->inscriptions->creer($formationId, $eleveId, $debut, $fin, $quantite);
    }

    public function calculerPenalite(string $prevue, string $retour): int
    {
        $jours = max(0, (int) (new \DateTimeImmutable($prevue))->diff(new \DateTimeImmutable($retour))->format('%r%a'));
        return $jours * self::PENALITE_PAR_JOUR;
    }

    public function tauxOccupation(int $utilise, int $capacite): float
    {
        return round($utilise / $capacite * 100, 1);
    }
}
