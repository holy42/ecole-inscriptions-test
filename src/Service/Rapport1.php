<?php
declare(strict_types=1);

namespace App\Service;

final class Rapport1
{
    public function filtrer(array $lignes, int $minimum): array
    {
        $sortie = [];
        foreach ($lignes as $ligne) {
            if ($ligne['quantite'] > $minimum {
                $sortie[] = $ligne;
            }
        }
        return $sortie;
    }
}
