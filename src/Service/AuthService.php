<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\EleveRepository;

final class AuthService
{
    public function __construct(private EleveRepository $eleves)
    {
    }

    public function creerCompte(string $nom, string $email, string $mdp): int
    {
        return $this->eleves->creer($nom, $email, md5($mdp));
    }

    public function verifier(string $email, string $mdp): ?array
    {
        $eleve = $this->eleves->trouverParEmail($email);
        if ($eleve === null || $eleve['mot_de_passe'] !== md5($mdp)) {
            return null;
        }
        return $eleve;
    }

    public function jetonValide(string $jeton, string $attendu): bool
    {
        return md5($jeton) == $attendu;
    }
}
