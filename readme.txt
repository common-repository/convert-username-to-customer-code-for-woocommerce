=== Convert Username to Customer Code for Woocommerce ===
Contributors: 4wpbari
Donate Link: https://4wp.it
Tags: codice cliente, username code, customer code, woocommerce
Requires at least: 4.9
Tested up to: 5.6
Requires PHP: 5.2.4
Requires WooCommerce at least: 2.5.0
Tested WooCommerce up to: 4.9.1
Stable Tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Sfrutta la funzione username trasformandolo in codice cliente. Attribuisci professionalità al tuo woocommerce.

== Description ==

Convert Username to Customer Code for Woocommerce ti permette di convertire la funzione username in codice cliente. Il plugin ha la funzionalità di generare un codice di 6 cifre nel momento in cui un cliente si registra al tuo woocommerce.

= Che cosa permette di fare? =

Quando un cliente si registra al tuo woocommerce, in modo nativo è obbligato a scegliere un username ed inserire una email.

Con questo plugin, il campo username sparirà, ed il cliente dovrà solo inserire la sua email ed il nome e cognome.
Una volta registrato, il plugin genererà un codice di 6 cifre random, che verrà inserito automaticamente al posto dell'username.
Con questo codice, se vorrà potrà anche accedervi.
Quindi il plugin, oltre ad aver inserito i campi nome e cognome (che in modo nativo woocommerce non offre in fase di registrazione), 
automaticamente questi li attribuirà in fase di fatturazione in checkout (che in modo nativo woocommerce richiede di ricompilare).
Inoltre il plugin automaticamente va a sostituire nella dashboard del cliente anche il benvenuto con il suo proprio nome (che in modo nativo woocommerce gli abbina l'username), 
e sostituirà anche l'username nel nome del cliente quando andrà a fare recensioni sul prodotto.
Inoltre viene aggiunto anche il codice cliente in tutte le sezioni dell'area riservata del cliente.

Nel pannello di controllo di wordpress, il codice cliente viene aggiunto anche nel riepilogo degli ordini e in modifica ordine di woocommerce, ottimo per una tracciabilità.
Inoltre viene anche inserito nel nuovo pannello nativo di woocommerce nella sezione clienti, dove poter estrapolare in excel tutti gli ordini ricevuti.
Il plugin permette di disabilitare anche alcune funzioni che non potrebbero interessare allo sviluppatore (situato nella sezione Woocommerce/Impostazioni/Codice Cliente).

Sostanzialmente il plugin sfrutta la funzionalità dell'username, che in un ecommerce non servirebbe a nulla e ancor meglio, non darebbe un occhio di riguardo al cliente, sia in fase di registrazione, sia in fase di ordine, sia in fase di navigazione 
nella propria area riservata.

Note:

- Il plugin richiede Woocommerce.
- Assicurarsi che ci sia il flag (nella sezione WOOCOMMERCE/IMPOSTAZIONI/ACCOUNT-E-PRIVACY) su "La creazione di un account comporta automaticamente la generazione di un nome utente dell'account per il cliente, in base al suo cognome, nome o all'e-mail"
- SI CONSIGLIA VIVAMENTE DI AVVIARE IL PLUGIN SU UN ECOMMERCE APPENA ATTIVO IN QUANTO IL CODICE CLIENTE VIENE GENERATO SULLE NUOVE REGISTRAZIONI DEGLI UTENTI, E NON SU QUELLE REGISTRATE IN PRECEDENZA PRIMA DEL'INSTALLAZIONE DEL PLUGIN.
E' COMUNQUE POSSIBILE MODIFICARE IL CODICE CLIENTE SINGOLARMENTE NELLA PAGINA DI MODIFICA UTENTE.



== Installation ==

Puoi caricare il file zip da Plugin/Aggiungi Nuovo, dal pannello di amministrazione del tuo wordpress 
oppure
Estrai il file zip e rilascia il contenuto nella directory wp-content / plugins / della tua installazione di WordPress, quindi attiva la pagina Plugin da Plugins.

== Frequently Asked Questions ==

Nessuna

== Screenshots ==

1. Login e registrazione woocommerce con l'aggiunta dei campi nome e cognome
2. Compila in automatico il nome e cognome catturati dalla registrazione in fase di acquisto
3. Codice cliente nella dashboard di woocommerce, in tutte le sezioni
4. Codice cliente nel dettaglio singolo ordine
5. Colonna Codice Cliente in riepilogo ordini
6. Codice Cliente anche nella nuova sezione woocommerce
7. Possibiltà di modificare il codice cliente nella sezione Utenti
8. Pannello Impostazione Codice cliente in Woocommerce


== Changelog ==

= 1.0.1 =

 * Inserito campo disattivazione messaggio benvenuto in email
 * Inserite traduzioni mancanti nelle email

= 1.0 =

Versione iniziale


== Upgrade Notice ==

Nessuna
