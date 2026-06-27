<?php

function menu() {
    Afficher( "\n ==========Menu Principal==========\n");
    Afficher( "1. Créer Wallet \n");
    Afficher( "2. Faire un Dépôt \n");
    Afficher( "3. Faire un Retrait \n");
    Afficher( "4. Lire les Transactions \n");
    Afficher( "0. Quitter  \n");
}

do{
    menu();
    $choix = readline("Entrez votre choix : \n");

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
            echo "Au Revoir !!! \n";
            break;

        default:
            echo "Choix invalide !!! \n";

        
    }

}while($choix != 0);






?>