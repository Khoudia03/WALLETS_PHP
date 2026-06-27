<?php

require_once "controller.php";

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
            break;
        
        case 2:
            break;

        case 3:
            break;

        case 4:
            break;

        case 0:
            affichage("Au Revoir !!!");
            break;

        default:
            affichage("Choix invalide !!!");

        
    }

}while($choix != 0);






?>