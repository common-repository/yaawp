<?php

if( ! class_exists( 'yaawp_install' ) ) {

    class yaawp_install extends yaawp {

        private $yaawp_cron_check = 3600;

        function __construct () {

            parent::__construct();

            $this->yaawp_install_int();

        }

        function yaawp_install_int() {

            $this->yaawp_db_version     = $this->plugin_get_version();
            $this->yaawp_nodes          = $this->yaawp_db->prefix.'yaawp_nodes';

        }

        function yaawp_rules () {

            $labels = array(
                'name' => __('Alle Produkte', $this->var_sTextdomain),
                'singular_name' => __('Produkte Vorschau', $this->var_sTextdomain),
                'add_new' => __('Erstellen', $this->var_sTextdomain),
                'add_new_item' => __('Produkt Neu', $this->var_sTextdomain),
                'edit' => __('Bearbeiten', $this->var_sTextdomain),
                'edit_item' => __('Produkt Bearbeiten', $this->var_sTextdomain),
                'view' => __('Ansehen', $this->var_sTextdomain),
                'view_item' => __('Produkt ansehen', $this->var_sTextdomain),
                'search_items' => __('Produkte durchsuchen', $this->var_sTextdomain),
                'not_found' => __('Keine Produkte gefunden.', $this->var_sTextdomain),
                'not_found_in_trash' => __('Keine Produkte im Papierkorb gefunden.', $this->var_sTextdomain),
                'menu_name' => __('YAAWP', $this->var_sTextdomain),
                'all_items' => __('Produkte', $this->var_sTextdomain)
            );

            register_post_type( 'shop',
              array(
                'labels' => $labels,
                'public' => true,
                'menu_position' => 100,
                'supports' => array( 'title', 'editor', 'custom-fields' ),
                'menu_icon' => plugins_url( 'assets/img/yaawp.png', __FILE__ ),
                'has_archive' => true,
                'rewrite' => array('slug' => 'shop', 'with_front' => false)
              )
            );

            $labels = array(
              'name'              => __( 'Kategorien', $this->var_sTextdomain),
              'singular_name'     => __( 'Kategorien', $this->var_sTextdomain),
              'search_items'      => __( 'Kategorien suchen', $this->var_sTextdomain),
              'all_items'         => __( 'Alle Kategorien', $this->var_sTextdomain),
              'parent_item'       => __( '&Uuml;bergeordnete Kategorie', $this->var_sTextdomain),
              'edit_item'         => __( 'Kategorie bearbeiten', $this->var_sTextdomain), 
              'add_new_item'      => __( 'Neue Kategorie erstellen', $this->var_sTextdomain)
            );

            register_taxonomy( 'shop_category', 'shop', array(
              'labels' => $labels,
                'hierarchical' => true,
                'rewrite' => array( 'hierarchical' => true )
            ));

            flush_rewrite_rules();
        }

        function install_db() {

            $yaawp_db_version  = get_option('yaawp_db_version');
            $yaawp_cron_check = get_option('yaawp_cron_check');

            if ( !$yaawp_db_version ) {
                add_option('yaawp_db_version', $this->yaawp_db_version);
            }

            if ( !$yaawp_cron_check ) {
                add_option('yaawp_cron_check', $this->yaawp_cron_check);
            }

            if( $yaawp_db_version != $this->yaawp_db_version ) {
                update_option('yaawp_db_version', $this->yaawp_db_version);
                $this->yaawp_db->query("DROP TABLE `$this->yaawp_nodes`");
            }

            $sql = "CREATE TABLE `$this->yaawp_nodes` (
            `SearchIndex` VARCHAR(50) NOT NULL,
            `NodeId` INT(10) NULL,
            `Language` VARCHAR(2) NOT NULL,
            `Name` VARCHAR(50) NOT NULL,
            INDEX `SearchIndex` (`SearchIndex`),
            INDEX `Name` (`Name`)
            )";

            if ( !$this->yaawp_db->query($sql) ) {
                throw new Exception(sprintf(__('Fehler: Datenbank konnte nicht erstellt werden.', $this->var_sTextdomain),$this->yaawp_nodes));
            }

            add_option("yaawp_db_version", $yaawp_db_version);

            $this->fill_db();
            $this->addOptions();
            $this->yaawp_rules();
        }

        function addOptions() {

            add_option( 'yaawp_secret_access_key', '', '', 'no' );
            add_option( 'yaawp_access_key_id', '', '', 'no' );
            add_option( 'yaawp_associate_id', '', '', 'no' );

        }

        function delOptions() {

            delete_option( 'yaawp_secret_access_key' );
            delete_option( 'yaawp_access_key_id' ); 
            delete_option( 'yaawp_associate_id' );
            delete_option( 'yaawp_cron_check' );
            delete_option( 'yaawp_db_version' );
            delete_option( 'yaawp_news' );
            
        }

        function fill_db() {

            $sql = "INSERT INTO `$this->yaawp_nodes` (`SearchIndex`, `NodeId`, `Language`, `name`) VALUES
            ('Apparel', '78689031', 'de', 'Kleider'),
            ('Automotive', '78191031', 'de', 'Auto'),
            ('Baby', '357577011', 'de', 'Baby'),
            ('Blended', null, 'de', 'Vermischt*'),
            ('Beauty', '64257031', 'de', 'Sch&ouml;nheit'),
            ('Books', '541686', 'de', 'B&uuml;cher'),
            ('Classical', '542676', 'de', 'Klassik'),
            ('DVD', '547664', 'de', 'DVD'),
            ('Electronics', '569604', 'de', 'Elektronik'),
            ('ForeignBooks', '54071011', 'de', 'ausl&auml;ndische B&uuml;cher'),
            ('Grocery', '340846031', 'de', 'Lebensmittel'),
            ('HealthPersonalCare', '64257031', 'de', 'Gesundheit'),
            ('HomeGarden', '10925241', 'de', 'Haus und Garten'),
            ('Jewelry', '327473011', 'de', 'Schmuck'),
            ('KindleStore', '530484031', 'de', 'Kindle Store'),
            ('Kitchen', '3169011', 'de', 'K&uuml;che'),
            ('Lighting', '213083031', 'de', 'Beleuchtung'),
            ('Magazines', '1161658', 'de', 'Zeitschriften'),
            ('Marketplace', null, 'de', 'Marketplace'),
            ('MP3Downloads', '77195031', 'de', 'MP3 Downloads'),
            ('Music', '542676', 'de', 'Musik'),
            ('MusicalInstruments', '340849031', 'de', 'Musikinstrumente'),
            ('MusicTracks', null, 'de', 'Musik Lieder'),
            ('OfficeProducts', '192416031', 'de', 'B&uuml;robedarf'),
            ('OutdoorLiving', '10925051', 'de', 'Outdoor'),
            ('Outlet', null, 'de', 'Outlet / Auslauf'),
            ('PCHardware', '569604', 'de', 'PC Hardware'),
            ('Photo', '569604', 'de', 'Foto'),
            ('Software', '542064', 'de', 'Software'),
            ('SoftwareVideoGames', '541708', 'de', 'Software Video-Spiele'),
            ('SportingGoods', '16435121', 'de', 'Sportartikel'),
            ('Tools', null, 'de', 'Werkzeuge'),
            ('Toys', '12950661', 'de', 'Spielzeug'),
            ('VHS', '547082', 'de', 'VHS'),
            ('Video', '547664', 'de', 'Video'),
            ('VideoGames', '541708', 'de', 'Video-Spiele'),
            ('Watches', '193708031', 'de', 'Uhren')";
            
            if ( !$this->yaawp_db->query($sql) ) {
                throw new Exception(sprintf(__('Fehler: Datens&auml;tze %s konnte nicht importiert werden.', $this->var_sTextdomain),$this->yaawp_nodes));
            }

        }

        function uninstall_db() {

            $sql = "DROP TABLE IF EXISTS `$this->yaawp_nodes`";

            if ( !$this->yaawp_db->query($sql) ) {
                throw new Exception(sprintf(__('Fehler: Datenbank %s konnte nicht gel&ouml;scht werden.', $this->var_sTextdomain),$this->yaawp_nodes));
            }
            
            $this->delOptions();
            $this->yaawp_rules();

        }
    }
}

?>