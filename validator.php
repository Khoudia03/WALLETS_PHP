<?php

require_once "controller.php";

// Validation Téléphone
function validerTelephone(): int {
    do {
        $telephone = saisie("Veuillez saisir votre numéro : ");
        $prefix    = preFixe($telephone);

        if (taille($telephone) != 9) {
            affichage("Le numéro doit contenir 9 chiffres");
        } elseif (
            $prefix != "70" &&
            $prefix != "75" &&
            $prefix != "76" &&
            $prefix != "77" &&
            $prefix != "78"
        ) {
            affichage("Préfixe invalide");
        } else {
            return (int) $telephone;
        }
    } while (true);
}

// Fonction Validation Solde
function validerSolde(): int {
    do {
        $solde = (int) saisie("Veuillez saisir votre solde de compte : ");
        if ($solde < 0) {
            affichage("Le solde ne peut pas être négatif");
        } else {
            return $solde;
        }
    } while (true);
}

// Fonction Validation Code
function validerCode(): int {
    do {
        $code = saisie("Veuillez saisir votre code secret : ");
        if (taille($code) != 4) {
            affichage("Le code doit contenir exactement 4 chiffres");
        } else {
            return (int) $code;
        }
    } while (true);
}

// Fonction Unicité Téléphone
function telephoneExiste(array $wallets, int $telephone): bool {
    foreach ($wallets as $wallet) {
        if ((int) $wallet['telephone'] === $telephone) {
            return true;
        }
    }
    return false;
}

// Fonction Unicité Code
function codeExiste(array $wallets, int $code): bool {
    foreach ($wallets as $wallet) {
        if ((int) $wallet['code'] === $code) {
            return true;
        }
    }
    return false;
}