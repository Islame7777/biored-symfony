<?php
// src/Enum/CategoryStatusEnum.php

namespace App\Enum;

enum CategoryStatusEnum: string
{
    case Actif = 'Actif';
    case Inactif = 'Inactif';

    // Cette méthode retourne les valeurs de l'énumération pour le formulaire
    public static function getValues(): array
    {
        return [
            self::Actif->value => 'Actif',
            self::Inactif->value => 'Inactif',
        ];
    }
}
