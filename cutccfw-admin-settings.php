<?php
class WC_cutccfw {
    /**
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public static function cutccfw_init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::cutccfw_add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_cutccfw', __CLASS__ . '::cutccfw_settings_tab' );
        add_action( 'woocommerce_update_options_cutccfw', __CLASS__ . '::cutccfw_update_settings' );
    }
    
    /**
     * Aggiunge una nuova scheda delle impostazioni nelle schede native delle impostazioni di WooCommerce.
     *
     * @param array $settings_tabs Serie delle impostazioni tab di WooCommerce e relative etichette, esclusa la scheda abbonamento.
     * @return array $settings_tabs Serie delle impostazioni tab di WooCommerce e relative etichette, inclusa la scheda abbonamento.
     */
    public static function cutccfw_add_settings_tab( $settings_tabs ) {
        $settings_tabs['cutccfw'] = __( 'Codice Cliente', 'woocommerce-settings-tab-cutccfw' );
        return $settings_tabs;
    }
    /**
     * Utilizza l'API dei campi di amministrazione di WooCommerce per le impostazioni di output tramite la funzione @see woocommerce_admin_fields ().
     *
     * @uses woocommerce_admin_fields()
     * @uses self::cutccfw_get_settings()
     */
    public static function cutccfw_settings_tab() {
        woocommerce_admin_fields( self::cutccfw_get_settings() );
    }
    /**
     * Utilizza l'API delle opzioni WooCommerce per salvare le impostazioni tramite la funzione @see woocommerce_update_options ().
     *
     * @uses woocommerce_update_options()
     * @uses self::cutccfw_get_settings()
     */
    public static function cutccfw_update_settings() {
        woocommerce_update_options( self::cutccfw_get_settings() );
    }
    /**
     * Ottieni tutte le impostazioni per questo plugin per la funzione @see woocommerce_admin_fields ().
     *
     * @return array Serie di impostazioni per la funzione @see woocommerce_admin_fields ().
     */
    public static function cutccfw_get_settings() {
        $settings = array(

            'section_title' => array(
                'name'     => __( 'Impostazioni generali', 'woocommerce-settings-tab-cutccfw' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'WC_cutccfw_section_title'
            ),
            'codice_areaclienti' => array(
                'name'     => __( 'Area clienti', 'text-domain' ),
                'desc_tip' => __( 'Nascondi il codice cliente "nell\'area clienti".', 'text-domain' ),
                'id'       => 'wccutccfw_nascondi_codiceareaclienti',
                'type'     => 'checkbox',
                'css'      => 'min-width:300px;',
                'desc'     => __( 'Inserendo il flag nascondi il codice cliente in tutte le sezioni dell\' area riservata del cliente', 'text-domain' ),
            ),
			'codice_riepilogoordini' => array(
                'name'     => __( 'Colonna in riepilogo ordini', 'text-domain' ),
                'desc_tip' => __( 'Nascondi il codice cliente dalla colonna del "riepilogo ordini".', 'text-domain' ),
                'id'       => 'wccutccfw_nascondi_colonna_wooadmin',
                'type'     => 'checkbox',
                'css'      => 'min-width:300px;',
                'desc'     => __( 'Inserendo il flag nascondi il codice cliente dalla colonna situata in Woocommerce/Ordini', 'text-domain' ),
            ),
			'codice_modificaordine' => array(
                'name'     => __( 'Colonna in modifica ordine', 'text-domain' ),
                'desc_tip' => __( 'Nascondi il codice cliente in "modifica ordine".', 'text-domain' ),
                'id'       => 'wccutccfw_nascondi_colonna_wooorder',
                'type'     => 'checkbox',
                'css'      => 'min-width:300px;',
                'desc'     => __( 'Inserendo il flag nascondi il codice cliente dalla colonna situata in Woocommerce/Ordini/Modifica Ordine', 'text-domain' ),
            ),
			'codice_emailbenvenuto' => array(
                'name'     => __( 'Email di benvenuto', 'text-domain' ),
                'desc_tip' => __( 'Nascondi il messaggio nella email di benvenuto.', 'text-domain' ),
                'id'       => 'wccutccfw_nascondi_emailbenvenuto',
                'type'     => 'checkbox',
                'css'      => 'min-width:300px;',
                'desc'     => __( 'Inserendo il flag nascondi il messaggio "Ricordati di conservare con cura il tuo codice cliente, Grazie!" nella email di benvenuto', 'text-domain' ),
            ),
		//	'codice_modificacliente' => array(
        //       'name'     => __( 'Modifica del codice cliente', 'text-domain' ),
         //       'desc_tip' => __( 'Disattiva la funzione di modifica codice cliente in "Utenti/Tutti gli utenti".', 'text-domain' ),
         //       'id'       => 'wccutccfw_nascondi_modifica_codicecliente',
          //      'type'     => 'checkbox',
          //      'css'      => 'min-width:300px;',
           //     'desc'     => __( 'Inserendo il flag disattivi la possibilità di modificare il codice cliente situata nella sezione Utenti/Tutti gli utenti nel singolo utente', 'text-domain' ),
         //   ),
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'WC_cutccfw_section_end'
            )
        );
        return apply_filters( 'WC_cutccfw_settings', $settings );
    }
}
WC_cutccfw::cutccfw_init();
?>