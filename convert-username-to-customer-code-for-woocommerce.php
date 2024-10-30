<?php
/**
 * Plugin Name: Convert Username To Customer Code For Woocommerce
 * Plugin URI: https://4wp.it/convert-username-to-customer-code-for-woocommerce
 * Description: Converte la funzionalità dell'username in codice cliente, con numeri di 6 cifre generati automaticamente. Ottimo per far rispecchiare la professionalità del tuo ecommerce. Permette di visualizzare il codice cliente abbinato, in tutte le sezioni dell'area riservata di woocommerce, nella email di benvenuto di avvenuta iscrizione dell'account. Inoltre aggiunte altre funzionalità: Inserisce nel form di registrazione il campo nome e cognome; Inserisce il nome del cliente nella dashboard di benvenuto nell'area clienti anzichè del classico username.
 * Version: 1.0.1
 * Author: 4wpbari
 * Author URI: https://4wp.it/roberto-bottalico/
 * Developer: Roberto Bottalico
 * Text Domain: 4wp
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 **/
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Esci se l'accesso è diretto
}

// Aggiungi il link dell'impostazione pagina del plugin
function cutccfw_plugin_settings_link($links) { 
  $settings_link = '<a href="/wp-admin/admin.php?page=wc-settings&tab=cutccfw">Impostazioni</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}


function cutccfw_warning_notice(){
    global $pagenow;
    if ( $pagenow == 'users.php' ) {
    $user = wp_get_current_user();
    if ( in_array( 'administrator', (array) $user->roles ) ) {
    echo '<div class="notice notice-info is-dismissible">
          <p>Ricorda che se vuoi, puoi modificare singolarmente ad ogni utente il proprio codice cliente. Basta accedere in modifica utente e potrai cambiarlo. Se invece vuoi disattivare delle funzioni che non ti interessano <a href="admin.php?page=wc-settings&tab=cutccfw">clicca qui</a> per le impostazioni del plugin CONVERT USERNAME TO CUSTOMER CODE FOR WOOCOMMERCE.</p>
         </div>';
    }
}
}
add_action('admin_notices', 'cutccfw_warning_notice');

 
$cutccfw_plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$cutccfw_plugin", 'cutccfw_plugin_settings_link' );

/**
 * Controlla se Woocommerce è attivo nel sito web
**/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

//Aggiunge le impostazioni nel pannello admin
include( 'cutccfw-admin-settings.php' );  

//Applica le funzioni di impostazione   
include( 'cutccfw-settings.php' );  

}//fine attivazione plugin 

