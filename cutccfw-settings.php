<?php
/**
 */

// Funzione generale del generatore di codice cliente a 6 cifre

function cutccfw_random_code( $prefix = '' ){
    $user_exists = 1;
    do {
       $rnd_str = sprintf("%06d", mt_rand(1, 999999));
       $user_exists = username_exists( $prefix . $rnd_str );
   } while( $user_exists > 0 );
   return $prefix . $rnd_str;
}



// Funzione nascondi campo in registrazione classica wordpress
function cutccfw_registration_fields() {
    ?>
    <style>
    #registerform > p:first-child{
        display:none;
    }
    </style>
    <?php
}
add_action( 'register_form', 'cutccfw_registration_fields' );

// 1. aggiungi i campi nome e cognome nel form classico registrazione wordpress

add_action( 'register_form', 'cutccfw_register_form' );
function cutccfw_register_form() {

    $first_name = ( ! empty( $_POST['first_name'] ) ) ? sanitize_text_field( $_POST['first_name'] ) : '';
    $last_name = ( ! empty( $_POST['last_name'] ) ) ? sanitize_text_field( $_POST['last_name'] ) : '';

        ?>
        <p>
            <label for="first_name"><?php _e( 'Nome', 'mydomain' ) ?><br />
                <input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr( wp_unslash( $first_name ) ); ?>" size="25" /></label>
        </p>

        <p>
            <label for="last_name"><?php _e( 'Cognome', 'mydomain' ) ?><br />
                <input type="text" name="last_name" id="last_name" class="input" value="<?php echo esc_attr( wp_unslash( $last_name ) ); ?>" size="25" /></label>
        </p>

        <?php
    }

    //2. Aggiungi la convalida che i campi nome e cognome vengano compilati
    add_filter( 'registration_errors', 'cutccfw_registration_errors', 10, 3 );
    function cutccfw_registration_errors( $errors, $sanitized_user_login, $user_email ) {

        if ( empty( $_POST['first_name'] ) || ! empty( $_POST['first_name'] ) && trim( $_POST['first_name'] ) == '' ) {
            $errors->add( 'first_name_error', __( '<strong>ERRORE</strong>: Devi inserire il tuo nome.', 'mydomain' ) );
        }
        if ( empty( $_POST['last_name'] ) || ! empty( $_POST['last_name'] ) && trim( $_POST['first_name'] ) == '' ) {
            $errors->add( 'last_name_error', __( '<strong>ERRORE</strong>: Devi inserire il tuo cognome.', 'mydomain' ) );
        }
        return $errors;
    }

    //3. Infine salva i campi compilati in user meta.
    add_action( 'user_register', 'cutccfw_user_register' );
    function cutccfw_user_register( $user_id ) {
        if ( ! empty( $_POST['first_name'] ) ) {
            update_user_meta( $user_id, 'first_name', sanitize_text_field( $_POST['first_name'] ) );
            update_user_meta( $user_id, 'last_name', sanitize_text_field( $_POST['last_name'] ) );
        }
    }
//4. mi assicuro che il codice random venga inserito
function cutccfw_register_username() {
    if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
         return;
    }
    $_POST['user_login'] = cutccfw_random_code('');
}
add_action( "login_form_register", 'cutccfw_register_username' );



// Aggiungi traduzione in user-edit.php e in frontend nel form login a livello generale
 
add_filter( 'gettext', 'cutccfw_gettext', 10, 2 );
function cutccfw_gettext( $translation, $original )
{
    
	if ( 'Username' == $original ) {
        return 'Codice Cliente';
    }
	if ( 'Username: %s' == $original ) {
        return 'Codice Cliente: %s';
    }
	if ( 'Username or email address' == $original ) {
        return 'Codice Cliente o Indirizzo Email';
    }
 
    if ( 'Usernames cannot be changed.' == $original ) {
        return 'Il Codice Cliente non può essere modificato';
    }
    if ( 'Password changed for user: %s' == $original ) {
        return 'Password cambiata per il codice cliente: %s';
    }
	if ( 'Hi ###USERNAME###,

This notice confirms that your password was changed on ###SITENAME###.

If you did not change your password, please contact the Site Administrator at
###ADMIN_EMAIL###

This email has been sent to ###EMAIL###

Regards,
All at ###SITENAME###
###SITEURL###' == $original ) {
        return '

Questo messaggio è la conferma che la tua password è stata modificata su ###SITENAME###.

Se non hai modificato la tua password, contatta l\'amministratore del sito all\'email
###ADMIN_EMAIL###

Questa email è stata inviata a ###EMAIL###

Saluti,
il team di ###SITENAME###
###SITEURL###';
    }
	if ( 'Hi ###USERNAME###,

This notice confirms that your email address on ###SITENAME### was changed to ###NEW_EMAIL###.

If you did not change your email, please contact the Site Administrator at
###ADMIN_EMAIL###

This email has been sent to ###EMAIL###

Regards,
All at ###SITENAME###
###SITEURL###' == $original ) {
        return '

Questa notifica ti avvisa che la tua email su ###SITENAME### è stata cambiata in ###NEW_EMAIL###.

Se non hai cambiato tu la tua email, ti preghiamo di contattare l\'amministratore del sito all\'indirizzo
###ADMIN_EMAIL###

Questa email è stata inviata a ###EMAIL###

Saluti,
Il team di ###SITENAME###
###SITEURL###';
    }
	if ( 'Username or email' == $original ) {
        return 'Codice Cliente o Email';
    }
	
    if ( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.' == $original ) {
        return 'Hai perso la password? Per favore inserisci il tuo codice cliente o l\'indirizzo email. Riceverai un collegamento per creare una nuova password via e-mail.';
    }
	
    return $translation;
}



// Aggiungi traduzione in woocommerce, nelle email e nell'area clienti

add_filter( 'gettext', 'cutccfw_translate_woocommerce_strings', 999, 3 );
  
function cutccfw_translate_woocommerce_strings( $translated, $untranslated, $domain ) {
 
   if ( ! is_admin() && 'woocommerce' === $domain ) {
 
      switch ( $untranslated ) {
 
         case 'Thanks for creating an account on %1$s. Your username is %2$s. You can access your account area to view orders, change your password, and more at: %3$s' :
 
            $translated = 'Grazie per aver creato l\'account su %1$s. il tuo codice cliente generato e\' %2$s. Potrai accedere al tuo account anche con la tua email e visionare nell\' area clienti i tuoi ordini, cambiare la tua password e tanto altro su : %3$s';
            break;
 
         case 'Hi %s,' :
 
            $translated = ' ';
			  
		 case 'Username: %s' :
 
            $translated = ' ';			  

			  
			  
            break;
 
         // ETC
       
      }
 
   }   
  
   return $translated;
 
}



// copia la traduzione di woocommerce sezione clienti ,in italiano, nella cartella languages/plugins dal plugin solo quando si attiva il plugin in generale

function cutccfw_copy_lang_dir()
{
    $plugin_dir = plugin_dir_path(__FILE__) . 'export/woocommerce-it_IT-wc-admin-app.json';

    $lang_dir  = WP_LANG_DIR  . '/plugins/woocommerce-it_IT-wc-admin-app.json';
  

    if (!copy($plugin_dir, $lang_dir)) {
        echo "Impossibile copiare il file tradotto da $plugin_dir in $lang_dir...\n";
    }
}
add_action('activate_plugin', 'cutccfw_copy_lang_dir');



// messaggio nel footer della email di woocommerce al nuovo utente appena registrato

function cutccfw_text_to_email( $email ) {
	
	if( get_option( 'wccutccfw_nascondi_emailbenvenuto' ) == "no") {
    if( 'customer_new_account' == $email->id ) {
        echo "Ricordati di conservare con cura il tuo codice cliente, Grazie!";
    }
  }
}
add_action( 'woocommerce_email_footer', 'cutccfw_text_to_email', 5 );



// In woocommerce, aggiungi una colonna personalizzata nella tabella di lista in admin

add_filter( 'manage_edit-shop_order_columns', 'cutccfw_custom_column', 20 );
function cutccfw_custom_column($columns)
{
	
    $reordered_columns = array();

    // Inserisci la colonna nella specifica sezione
    foreach( $columns as $key => $column){
        $reordered_columns[$key] = $column;
        if( $key ==  'order_status' ){
			if( get_option( 'wccutccfw_nascondi_colonna_wooadmin' ) == "no") {
            // Inserisci dopo la colonna "Stato 
            $reordered_columns['codice-cliente'] = __( 'Codice Cliente','theme_domain');
        }}
    }
    return $reordered_columns;


}

// Aggiungi campo personalizzato meta data per la colonna
add_action( 'manage_shop_order_posts_custom_column' , 'cutccfw_custom_column_orders_list', 20, 2 );
function cutccfw_custom_column_orders_list( $column, $post_id )
{
	if( get_option( 'wccutccfw_nascondi_colonna_wooadmin' ) == "no") {
    if ( 'codice-cliente' != $column ) return;

    global $the_order;

    // Richiama il customer id
    $user_id = $the_order->get_customer_id();

    if( ! empty($user_id) && $user_id != 0) {
        $user_data = get_userdata( $user_id );
        echo $user_data->user_login; // username wordpress
    }
    // In caso non è un utente registrato a fare l'ordine
    else
        echo '<small>(<em>Ospite</em>)</small>';
}}
// Aggiungi username cliente woocommerce nella pagina admin in modifica ordine
add_action( 'woocommerce_admin_order_data_after_billing_address', 'cutccfw_display_order_username', 10, 1 );

function cutccfw_display_order_username( $order ){
	
	if( get_option( 'wccutccfw_nascondi_colonna_wooorder' ) == "no") {

    global $post;
    
	$customer_user = get_post_meta( $post->ID, '_customer_user', true );
    echo '<p><strong style="display: block;">'.__('Codice Cliente').':</strong> <a href="user-edit.php?user_id=' . $customer_user . '">' . get_user_meta( $customer_user, 'nickname', true ) . '</a></p>';
}
	}



/**
 * cambia in default il display name in nome e cognome quando si registrano
 */

function cutccfw_changedisplay_name( $user_id ) {
 $info = get_userdata( $user_id );
 $args = array(
 'ID' => $user_id,
 'display_name' => $info->first_name . ' ' . $info->last_name
 );
 wp_update_user( $args );
}
add_action('user_register','cutccfw_changedisplay_name');



// cambia in default il display name in nome quando si registrano dal form di woocommerce

add_filter( 'pre_user_display_name' , 'cutccfw_set_display_woocommerce' );

function cutccfw_set_display_woocommerce( $display_name ) {

    if( isset( $_POST['billing_first_name'] ) ) {
        $display_name = sanitize_text_field( $_POST['billing_first_name']) ;
    }
    if( isset( $_POST['first_name'] ) ) {
        $display_name = sanitize_text_field( $_POST['first_name']);
    }
    return $display_name;
}


///////////////////////////////
// 1. AGGIUNGI CAMPI
  
add_action( 'woocommerce_register_form_start', 'cutccfw_addname_wooaccount_registration' );
  
function cutccfw_addname_wooaccount_registration() {
    ?>
  
    <p class="form-row form-row-first">
    <label for="reg_billing_first_name"><?php _e( 'Nome', 'woocommerce' ); ?> <span class="required">*</span></label>
    <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
    </p>
  
    <p class="form-row form-row-last">
    <label for="reg_billing_last_name"><?php _e( 'Cognome', 'woocommerce' ); ?> <span class="required">*</span></label>
    <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
    </p>
  
    <div class="clear"></div>
  
    <?php
}
  
///////////////////////////////
// 2. VALIDAZIONE CAMPI
  
add_filter( 'woocommerce_registration_errors', 'cutccfw_validate_namefields', 10, 3 );
  
function cutccfw_validate_namefields( $errors, $username, $email ) {
    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
        $errors->add( 'billing_first_name_error', __( '<strong>Errore</strong>: Inserire il tuo nome!', 'woocommerce' ) );
    }
    if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
        $errors->add( 'billing_last_name_error', __( '<strong>Errore</strong>: Inserire il tuo cognome!.', 'woocommerce' ) );
    }
    return $errors;
}
  
///////////////////////////////
// 3. SALVA CAMPI
  
add_action( 'woocommerce_created_customer', 'cutccfw_save_name_fields' );
  
function cutccfw_save_name_fields( $customer_id ) {
    if ( isset( $_POST['billing_first_name'] ) ) {
        update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
        update_user_meta( $customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']) );
    }
    if ( isset( $_POST['billing_last_name'] ) ) {
        update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
        update_user_meta( $customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']) );
    }
  
}



// Inserisci username in alto nella area clienti
function cutccfw_woocommerce_account_dashboard( ) { 
	if( get_option( 'wccutccfw_nascondi_codiceareaclienti' ) == "no") {
   
$current_user = wp_get_current_user();
    echo 'Codice cliente: ' . $current_user->user_login . '<br />'; }}    

add_action( 'woocommerce_account_content', 'cutccfw_woocommerce_account_dashboard', 10, 0 );



//
add_filter( 'woocommerce_new_customer_data', 'cutccfw_custom_newcustomer_data', 10, 1 );
function cutccfw_custom_newcustomer_data( $new_customer_data ){

    // Invia il nome e cognome del cliente
    if(isset($_POST['billing_first_name'])) $first_name = sanitize_text_field($_POST['billing_first_name']);
    if(isset($_POST['billing_last_name'])) $last_name = sanitize_text_field($_POST['billing_last_name']);

    // Nome e Cognome completo del cliente
    if( ! empty($first_name) || ! empty($last_name) )
        $complete_name = $first_name . ' ' . $last_name;

    // Rimpiazza 'user_login' prima che venga inserito, con il codice random
    if( ! empty($complete_name) )
        $new_customer_data['user_login'] = cutccfw_random_code('');

    return $new_customer_data;
}



// Opzione in caso si vuol cambiare il codice cliente/username

define( 'CUTCCFWCHANGE_USERNAME_VERSION', '1.0' );
define( 'CUTCCFWCHANGE_USERNAME_FILE', __FILE__ );


function cutccfwchange_username_bootstrap() {
	
	
    if( ! is_admin() ) {
        return;
    }

    // richiedi minimo PHP versione 5.3
    if( version_compare( PHP_VERSION, '5.3', '<' ) ) {
        return;
    }

    require_once __DIR__ . '/src/cutccfw-change-username.php';
    add_action( 'admin_enqueue_scripts', 'change_username\\enqueue_assets');
    add_action( 'wp_ajax_change_username', 'change_username\\ajax_handler');
}
	

add_action( 'plugins_loaded', 'cutccfwchange_username_bootstrap' );
