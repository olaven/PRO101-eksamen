# Eksamen - PRO101

EKsamensprosjektet skal startes på i løpet av mai.

## Om wordpress-installasjon

    * Forhåpentligvis er det bare å launche os-x-manager
    * wp-config.php må legges til i wordpress-4.9.4-1/apps/wordpress/htdocs manuelt

        1.  Ta utgangspunkt i denne malen: https://github.com/WordPress/WordPress/blob/master/wp-config-sample.php
       2. **linje 23**: `define('DB_NAME', 'bitnami_wordpress');`
       3. **linje 26**: `define('DB_USER', 'bn_wordpress');`
       4. **linje 29**: `define('DB_PASSWORD', 'PASSORD');` (tror man kan finne på, hvis ikke, hør med @olaven, som har original)
       5. **linje 32**: `define('DB_HOST', 'localhost:3306');`
       6.**linje 49-56**: _Authentication Unique Keys and Salts_ hentes herfra https://api.wordpress.org/secret-key/1.1/salt/  
       8.**linje 90-end**:
            ``` PHP

            if ( defined( 'WP_CLI' ) ) {
                $_SERVER['HTTP_HOST'] = 'localhost';
            }

            define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/wordpress');
            define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] . '/wordpress');


            /** Absolute path to the WordPress directory. */
            if ( !defined('ABSPATH') )
                define('ABSPATH', dirname(__FILE__) . '/');

            /** Sets up WordPress vars and included files. */
            require_once(ABSPATH . 'wp-settings.php');

            define('WP_TEMP_DIR', '/Applications/wordpress-4.9.4-1/apps/wordpress/tmp');


            define('FS_METHOD', 'direct');


            //  Disable pingback.ping xmlrpc method to prevent Wordpress from participating in DDoS attacks
            //  More info at: https://docs.bitnami.com/?page=apps&name=wordpress&section=how-to-re-enable-the-xml-rpc-pingback-feature

            if ( !defined( 'WP_CLI' ) ) {
                // remove x-pingback HTTP header
                add_filter('wp_headers', function($headers) {
                    unset($headers['X-Pingback']);
                    return $headers;
                });
                // disable pingbacks
                add_filter( 'xmlrpc_methods', function( $methods ) {
                        unset( $methods['pingback.ping'] );
                        return $methods;
                });
                add_filter( 'auto_update_translation', '__return_false' );
            }
        ```

## Nødvendige linker

* [Wordpress-themes Getting Started](https://developer.wordpress.org/themes/getting-started/who-should-read-this-handbook/)
*

### Møter og agendaer

* [Møtedokumentasjon](https://docs.google.com/document/d/1FUXLOJg794F6NIIu2mLVjFSWY7_rolldiPLHSG068us/edit)

### Undersøkelser

* [Spørreundersøkelsen 1](https://docs.google.com/forms/d/15b7D72Gg4rgdub0f1uqU4CA9Ao_-V0SKcULedAaiVB8/edit)
* [Spørreundersøkelse 1 (med endring)](https://docs.google.com/forms/d/1UR7eo3kX0v_yvSnWNsZMbWUsGRVToseopP5vBos-1L8/edit)

### Kommunikasjon

* Github Issues
* [Discord](https://discord.gg/FgPVHz)
* Facebook chat

### Annet nyttig

* [Markdown Cheat Sheet](https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet#links)
* [Grafisk profil Høyskolen Kristiania](http://designmanual.kristiania.no/)
