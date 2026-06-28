<?php

require_once "validator.php";

$wallets = [
    0 => [
        'client'    => 'Mami Cisse',
        'telephone' => 777059828,
        'solde'     => 1000,
        'code'      => 1234
    ],
    1 => [
        'client'    => 'Nafy Sarr',
        'telephone' => 777247388,
        'solde'     => 2000,
        'code'      => 9876
    ]
];

$transactions = [
    0 => [
        'type'        => 'depot',
        'montant'     => 500,
        'frais'       => 0,
        'indexClient' => 0
    ],
    1 => [
        'type'        => 'retrait',
        'montant'     => -800,
        'frais'       => 200,
        'indexClient' => 1
    ]
];

// Fonction pour les saisies
function saisie(string $message): string {
    return readline($message);
}

// Fonction pour les affichages
function affichage(string $message): void {
    echo "$message \n";
}

// Fonction pour récupérer les deux premiers caractères du numéro de téléphone
function preFixe(string $telephone): string {
    return substr($telephone, 0, 2);
}

// Fonction pour la taille d'une chaîne de caractères
function taille(string $chaine): int {
    $i = 0;
    while (isset($chaine[$i])) {
        $i++;
    }
    return $i;
}

// Fonction Saisie Wallet
function saisieWallet(): array {
    global $wallets;
    $wallet = ['client' => "", 'telephone' => 0, 'solde' => 0, 'code' => 0];
    $wallet['client'] = saisie("Veuillez saisir un client : ");

    do {
        $telephone = validerTelephone();
        if (telephoneExiste($wallets, $telephone)) {
            affichage("Ce numéro de téléphone est déjà utilisé");
        } else {
            $wallet['telephone'] = $telephone;
            break;
        }
    } while (true);

    $wallet['solde'] = validerSolde();

    do {
        $code = validerCode();
        if (codeExiste($wallets, $code)) {
            affichage("Ce code existe déjà pour un client");
        } else {
            $wallet['code'] = $code;
            break;
        }
    } while (true);

    return $wallet;
}

// Fonction Saisie Dépôt
function saisieDepot(): array {
    $telephone = saisie("Entre votre numéro de téléphone : ");
    $montant   = saisie("Entre le montant à déposer : ");
    return [
        'telephone' => (int) $telephone,
        'montant'   => (int) $montant
    ];
}

// Fonction Saisie Retrait
function saisieRetrait(): array {
    $telephone = saisie("Entre votre numéro de téléphone : ");
    $montant   = saisie("Entre le montant à retirer : ");
    return [
        'telephone' => (int) $telephone,
        'montant'   => (int) $montant
    ];
}

// Fonction pour afficher les wallets
function afficherWallets(array $wallets): void {
    affichage("\n");
    for ($index = 0; $index < count($wallets); $index++) {
        affichage("Titulaire : " . $wallets[$index]['client']);
        affichage("Téléphone : " . $wallets[$index]['telephone']);
        affichage("Solde : "     . $wallets[$index]['solde']);
        affichage("Code : "      . $wallets[$index]['code']);
        affichage("-------------------------------------");
    }
}