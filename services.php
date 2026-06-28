<?php

require_once "controller.php";

function calculerFrais(int $montant): int {
    if ($montant <= 10000) {
        return 200;
    } elseif ($montant <= 100000) {
        return 500;
    } else {
        $frais = (int) round($montant * 0.01);
        return min($frais, 5000);
    }
}

// Fonction Chercher Index
// Retourne l'index du wallet correspondant au téléphone, ou -1 si introuvable
function chercherIndex(array $wallets, int $telephone): int {
    foreach ($wallets as $index => $wallet) {
        if ((int) $wallet['telephone'] === $telephone) { 
            return $index;
        }
    }
    return -1;
}