<?php

require_once "controller.php";
require_once "services.php";
require_once "repository.php";

function menu() {
    affichage( "\n ==========Menu Principal==========");
    affichage( "1. Créer Wallet");
    affichage( "2. Faire un Dépôt");
    affichage( "3. Faire un Retrait");
    affichage( "4. Lire les Transactions");
    affichage( "0. Quitter");
}

do{
    menu();
    $choix = saisie("Entrez votre choix :");

        switch ($choix) {
        case 1:
            $newWallet = saisirWallet();
            creerWallet($newWallet);
            afficherWallet($wallets);
            break;
        
        case 2:
            $saisie = saisieDepot();
            $indexClient = chercherIndex($wallets, $saisie['telephone']);

            if ($indexClient === -1) {
                affichage("Numéro de téléphone introuvable");
            } else {
                enregistrerDepot($transactions, $wallets, $indexClient, $saisie['montant']);
            }
            break;

        case 3:
            $saisie = saisieRetrait();
            $indexClient = chercherIndex($wallets, $saisie['telephone']);

            if ($indexClient === -1) {
                affichage("Numéro de téléphone introuvable");
            } else {
                enregistrerRetrait($transactions, $wallets, $indexClient, $saisie['montant']);
            }
            break;

        case 4:
            lireTransactions($transactions, $wallets);
            break;

        case 0:
            affichage("Au Revoir !!!");
            break;

        default:
            affichage("Choix invalide !!!");

        
    }

}while($choix != 0);






?>