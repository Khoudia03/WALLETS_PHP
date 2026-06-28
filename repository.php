<?php

require_once "controller.php";
require_once "services.php";

// Fonction Créer Wallet
function creerWallet(array $newWallet): void {
    global $wallets;
    $wallets[] = $newWallet;
}

function enregistrerDepot(array &$transactions, array &$wallets, int $indexClient, int $montant): void {
    $wallets[$indexClient]['solde'] += $montant;

    $transactions[] = [
        'type'        => 'depot',
        'montant'     => $montant,
        'frais'       => 0,
        'indexClient' => $indexClient
    ];

    affichage("Dépôt de {$montant} FCFA enregistré pour {$wallets[$indexClient]['client']}");
    affichage("Nouveau solde : " . $wallets[$indexClient]['solde'] . " FCFA");
}

function enregistrerRetrait(array &$transactions, array &$wallets, int $indexClient, int $montant): void {
    $frais = calculerFrais($montant);
    $total = $montant + $frais;

    if ($wallets[$indexClient]['solde'] < $total) {
        affichage("Solde insuffisant");
        affichage("Montant demandé : {$montant} FCFA");
        affichage("Frais : {$frais} FCFA");
        affichage("Total nécessaire : {$total} FCFA");
        affichage("Solde actuel : " . $wallets[$indexClient]['solde'] . " FCFA");
        return;
    }

    $wallets[$indexClient]['solde'] -= $total;

    $transactions[] = [
        'type'        => 'retrait',
        'montant'     => -$montant,
        'frais'       => $frais,
        'indexClient' => $indexClient
    ];

    affichage("Retrait de {$montant} FCFA effectué pour {$wallets[$indexClient]['client']}");
    affichage("Frais appliqués : {$frais} FCFA");
    affichage("Total débité : {$total} FCFA");
    affichage("Nouveau solde : " . $wallets[$indexClient]['solde'] . " FCFA");
}

// Fonction Lire Transactions
function lireTransaction(array $transactions, array $wallets): void {
    if (empty($transactions)) {
        affichage("Aucune transaction enregistrée");
        return;
    }

    affichage("\n");
    foreach ($transactions as $index => $transaction) {
        $client = $wallets[$transaction['indexClient']]['client'];
        $montant = $transaction['montant'];
        $frais   = $transaction['frais'] ?? 0;
        // CORRIGÉ : utilise le champ 'type' au lieu du signe du montant
        $type = ($transaction['type'] === 'depot') ? "Dépôt" : "Retrait";
        affichage("Transaction {$index} - {$type} de " . abs($montant) . " FCFA pour {$client} (Frais : {$frais} FCFA)");
    }
}