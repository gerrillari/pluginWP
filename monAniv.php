<?php
// Code de configuration minimum, à mettre dans monPlugin.php, pour la prise en compte du plugin par WordPress (ci-dessous) 
/**
 * @package monAniv
 * @version 1
 */
/*
Plugin Name: monAniv
Plugin URI: http://wordpress.org/plugins/monAniv/
Description: Ce plugin sert à décorer notre site de façon statique lorsque c'est l'anniversaire du restaurant (exemple : motifs d'anniversaire)
Author: BWB
Version: 1
Author URI: https://trello.com/pluginmonanivbwb
Text Domain : monaniv
*/

/**ALERTE MESSAGE ANNIVERSAIRE */
function alerte(){
    $dateDuJour = date('d-m');
    $date_anniv = date("28-07");
    $nom = "MyRestauant";
    $diff= date("Y")-"2000";
    if ($date_anniv == $dateDuJour){
        echo '<script type="text/javascript">window.alert("'."Wahouuuu! ".$nom." fete ses ".$diff." ans aujourd'hui!!! un livre d'or est à votre disposition pour ce jour unique. Régalez-vous ^.^ ".'");</script>';
    }else{
        echo " ";
    }
}

add_action('wp_head','alerte');


/**TIMER ANNIVERSAIRE */
function register_style() {
    wp_register_style( 'style', plugins_url('/css/style.css', __FILE__), false, '1.0.0', 'all' );
    wp_enqueue_style( 'style' );
}
add_action( 'wp_head', 'register_style' );

// Fonction simple qui affiche une balise H1 dans le header 
function setTimer() {
    $annee = date('Y');
    $anniv = mktime(0, 0, 0, 8, 15, $annee);
            
    if ($anniv < time())
    $anniv = mktime(0, 0, 0, 8, 15, ++$annee);

    $tps_restant = $anniv - time(); // $anniv sera toujours plus grand que le timestamp actuel, vu que c'est dans le futur. ;)

    //============ CONVERSIONS

    $i_restantes = $tps_restant / 60;
    $H_restantes = $i_restantes / 60;
    $d_restants = $H_restantes / 24;


    $s_restantes = floor($tps_restant % 60); // Secondes restantes
    $i_restantes = floor($i_restantes % 60); // Minutes restantes
    $H_restantes = floor($H_restantes % 24); // Heures restantes
    $d_restants = floor($d_restants); // Jours restants
    //==================

    setlocale(LC_ALL, 'fr_FR');

    echo"<div class='timer'>";
    echo '<div> Nous sommes le '. strftime('<strong>%d %B %Y</strong>') .'.</div><br />';
    echo '<div> 🎉 L\'anniversaire du restaurant est le 15 août prochain !! 🎉' . '</div><br />';
    echo '<div> Il reste exactement <strong>'. $d_restants .' jours</strong>, <strong>'. $H_restantes .' heures</strong>, '
         . '<strong>'. $i_restantes .' minutes</strong> et <strong>'. $s_restantes . ' secondes' .'</div>';
    echo" </div> ";
}
// Ajout de l'action setTimer() sur 'wp_head, avec en paramètre de type "string", le nom du Hook et le nom de la fonction de rappel.
add_action('wp_head', 'setTimer');


/**MENU ET SOUS-MENU*/
//fonction qui affiche l'onglet menu de notre plugin dans le backoffice
function add_new_menu(){

    //fonction intégrée de WP pour donner un nom, titre et les options de notre menu
    add_menu_page(
        'Mon Anniversaire',//titre de ma page
        'monAniv',//texte à montrer dans le tag menu du plugin
        'manage_options',//autoriser à accéder au menu du plugin que à celleux qui ont la fonctionnalité 'manage_options'
        'includes/page_monAniv.php',//le slug, url à saisir, ce qu'il faut afficher lorsqu'on clique sur notre menu plugin
        'page_menu_callback',//fonction à être appellé pour afficher le contenu de cette page, par défaut ''
        'dashicons-buddicons-community',//icone de notre menu plugin
        6 //position dans la barre menu dans le backoffice
        
    );
    add_submenu_page(
        'includes/page_monAniv.php',//slug du parent
        'Auteur.e.s',//nom page
        'Auteur.e.s',//nom menu
        'manage_options',//autorisation
        'page_monAniv',//slug 
        'page_sousmenu_callback',//fonction
        null//position
    );
}
//Fonction qui affiche le contenu de la page menu
function page_menu_callback(){
      echo '<div class="wrap">';
        echo '<h1 style="color:red">Wiki du plugin monAniv</h1>';
            echo "<h3>Ce plugin permets à votre site WordPress d'annoncer l'anniversaire de votre entreprise à vos client.e.s au travers de plusieurs fontionnalités, comme par exemple :</h3>";
                echo "<ul>
                        <li><h4>- Ajouter un compte à rebours quelques jours avant l'anniversaire</h4></li>
                        <li><h4>- Modifier votre site le jour de l'anniversaire avec des motifs d'anniversaire</h4></li>
                        <li><h4>- Ajouter une alerte le jour de l'anniversaire pour que les client.e.s soient informées</h4></li>
                        <li><h4>- Ajouter un formulaire pour que les client.e.s puissent souhaiter un bon anniversaire à votre entreprise</h4></li>
                        <li><h4>- Afficher ces derniers messages pour que ça soit visible à tout le monde</h4></li>
                    </ul>";
            echo "<h3>Voici un exemple de votre site si vous utilisez ce plugin :</h3>";
                echo "<h4>- Compte à rebours :</h4>";
                echo '<img src="http://wordpress.bwb/wp-content/uploads/2021/07/maq1.png" >';
                echo "<h4>- Message d'anniversaire dans le site :</h4>";
                echo '<img src="http://wordpress.bwb/wp-content/uploads/2021/07/maq2.png" >';
                echo "<h4>- Formulaire et messages laissés par les client.e.s :</h4>";
                echo '<img src="http://wordpress.bwb/wp-content/uploads/2021/07/maq3.png" >';
        echo '</div>';
}
//Fonction qui affiche le contenu de la page sous-menu
function page_sousmenu_callback(){
    echo '<div class="wrap">';
      echo '<h1>Voici les personnes qui ont participé à ce plugin avec beaucoup de sang et larmes :</h1>';
      echo "<ul>
                <li><h3>- Marylise Orsat </h3><h4><i>'Finalement c'est pas des vacances wordpress'</i></h4></li>
                <li><h3>- Lucas Steichen</h3><h4><i>'Ca ne marche pas...'</i></h4></li>
                <li><h3>- Laurène Georges</h3><h4><i>'Maxime, arrête de faire ta princesse'</i></h4></li>
                <li><h3>- Noureddine Benomar</h3><h4><i>'Je fais mumuse avec tout'</i></h4></li>
                <li><h3>- Maxime Guichon</h3><h4><i>'Le vaccin m'a tué, à demain!'</i></h4></li>
                <li><h3>- Tamara Alcala</h3><h4><i>'@#$$@#!!'</i></h4></li>
            </ul>";
    echo '</div>';
    
}


//Ajout du nouvel onglet du plugin avec son icône dans le menu admin WP
add_action('admin_menu','add_new_menu');


