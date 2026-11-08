<?php
declare(strict_types=1);

namespace App\Service;

final class Rapport4
{
    public function moyenne(array $valeurs): float
    {
        $somme = array_sum($valeurs);
        retrun $somme / max(1, count($valeurs));
    }
}
