<?php

/**
Plugin Name: Yet Another Amazon Wordpress Plugin Lite
Plugin URI: http://www.yaawp-plugin.com/
Description: Das WordPress-Plugin YAAWP (Yet Another Amazon Wordpress Plugin ) erm&ouml;glicht es, Produkte direkt mit der ASIN von Amazon auszulesen. Sie erhalten direkt eine Vorschau wie das Produkt in Ihrem Artikel aussieht, k&ouml;nnen w&auml;hlen ob eben dieser Artikel nur als Link, „Widget“ mit Vorschaubild oder mehr im Artikel erscheinen soll. Aber das ist nicht alles, YAAWP bietet eine direkte Importfunktion. Sie suchen einen Artikel, w&auml;hlen die passende Produktkategorie und suchen sich die passenden Produkte aus, fertig.
Version: 0.5
Author: Kai Lange
Author URI: http://www.pc-halle.de/
License: GPL2
**/

session_start();
ini_set('max_execution_time', 600);
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Berlin'); 

register_activation_hook( __FILE__, array( 'yaawp', 'activation' ) );
register_deactivation_hook( __FILE__, array( 'yaawp', 'deactivation' ) );
register_uninstall_hook( __FILE__, array( 'yaawp', 'uninstall' ) );

if( ! class_exists( 'yaawp' ) ) {
  
  class yaawp {

    var $pluginPath;
    var $pluginUrl;

    private $Placeholder = array(
        'ASIN',
        'SmallImageUrl',
        'SmallImageWidth',
        'SmallImageHeight',
        'MediumImageUrl',
        'MediumImageWidth',
        'MediumImageHeight',
        'LargeImageUrl',
        'LargeImageWidth',
        'LargeImageHeight',
        'ImageSets',
        'Label',
        'Manufacturer',
        'Publisher',
        'Studio',
        'Title',
        'AmazonUrl',
        'TotalOffers',
        'LowestOfferPrice',
        'LowestOfferCurrency',
        'LowestOfferFormattedPrice',
        'LowestNewPrice',
        'LowestNewOfferFormattedPrice',
        'LowestUsedPrice',
        'LowestUsedOfferFormattedPrice',
        'AmountSavedFormattedPrice',
        'AmazonPrice',
        'AmazonPriceFormatted',
        'ListPriceFormatted',
        'AmazonCurrency',
        'AmazonAvailability',
        'AmazonLogoSmallUrl',
        'AmazonLogoLargeUrl',
        'DetailPageURL',
        'Platform',
        'ISBN',
        'EAN',
        'NumberOfPages',
        'ReleaseDate',
        'Binding',
        'Author',
        'Creator',
        'Edition',
        'AverageRating',
        'TotalReviews',
        'RatingStars',
        'RatingStarsSrc',
        'Director',
        'Actors',
        'RunningTime',
        'Format',
        'CustomRating',
        'ProductDescription',
        'AmazonDescription',
        'Artist',
        'Comment',
        'PercentageSaved',
        'Prime',
        'PrimePic',
        'HasReviews',
        'CustomerReviewsIFrameURL',
        'Rating',
        'Permalink',
        'EditorialReview_1',
        'Tags',
        'Availability',
        'AvailabilityColor',
        'SalesRank'

    );

    private $var_sTextdomain;
    private $yaawp_db_version;
    private $table_name;

    protected $yaawp_db;

    function __construct () {

      $this->yaawp_int();

      $this->pluginPath = plugin_dir_path(__FILE__);
      $this->pluginUrl = plugin_dir_url(__FILE__);

      try {

        if (!file_exists($this->pluginPath.'classes/functions.php')) throw new Exception (__('Fehler: functions.php nicht vorhanden.', $this->var_sTextdomain));
        else include($this->pluginPath.'classes/functions.php');

        if (!file_exists($this->pluginPath.'classes/install.class.php')) throw new Exception (__('Fehler: install.class.php nicht vorhanden.', $this->var_sTextdomain));
        else include($this->pluginPath.'classes/install.class.php');

        if (!file_exists($this->pluginPath.'classes/amazon.class.php')) throw new Exception (__('Fehler: amazon.class.php nicht vorhanden.', $this->var_sTextdomain));
        else include($this->pluginPath.'classes/amazon.class.php');

      } catch (Exception $e) {
        echo $e->getMessage();
      }

      add_action( 'template_redirect', array( &$this, 'yaawp_template_redirect' ) );
      add_action( 'init', array( &$this, 'yaawp_user_int' ), 1 );
      add_action( 'wp_enqueue_scripts', array( &$this, 'yaawp_user_main' ) );

      if ( is_admin() ) {

        add_action( 'init', array(&$this, 'yaawp_admin_int'), 10 );

        add_action( 'edit_term', array(&$this, 'yaawp_save_taxonomy_image') );
        add_action( 'create_term', array(&$this, 'yaawp_save_taxonomy_image') );

        add_action( 'admin_enqueue_scripts', array( &$this, 'yaawp_admin_main' ) );
        add_action( 'admin_menu', array(&$this, 'yaawp_admin_menu') );

        add_action( 'wp_ajax_Backend', array( &$this, 'Backend' ) );

        if ( strpos( $_SERVER['SCRIPT_NAME'], 'edit-tags.php' ) > 0 ) {
          add_action( 'quick_edit_custom_box', array( &$this, 'yaawp_quick_edit_custom_box' ), 10, 3);
          add_filter( 'attribute_escape', array( &$this, 'yaawp_change_insert_button_text' ), 10, 2);
        }

      }

      add_shortcode( 'yaawp_asin', array(&$this, 'yaawp_asin_shortcode') );

    }

    function yaawp_int () {

      global $wpdb;

      $this->yaawp_db = $wpdb;

      $this->var_sTextdomain = 'yaawp';

      if(function_exists('load_plugin_textdomain')) {
        load_plugin_textdomain($this->var_sTextdomain, $this->pluginPath . 'languages');
      }

    }

    function yaawp_admin_menu () {

      add_submenu_page( 'edit.php?post_type=shop', __('Einstellungen', $this->var_sTextdomain), __('Einstellungen', $this->var_sTextdomain), 'manage_options', 'yaawp-einstellungen', array(&$this, 'yaawp_settings_page') );
      add_submenu_page( 'edit.php?post_type=shop', __('Import', $this->var_sTextdomain), __('Import', $this->var_sTextdomain), 'manage_options', 'yaawp-import', array(&$this, 'yaawp_import_page') );
    
    }

    function yaawp_user_main () { 

      wp_register_style( 'yaawp-css', $this->pluginUrl.'assets/css/style.css', array(),'0.50','all');
      wp_enqueue_style( 'yaawp-css' );

      wp_enqueue_script( 'yaawp-js', $this->pluginUrl.'assets/js/frontend.js', array( 'jquery' ),'0.50');
      wp_localize_script( 'yaawp-js', 'yaawp',
        array(
          'ajaxurl' => admin_url( 'admin-ajax.php' ),
          'nonce'   => wp_create_nonce( 'yaawp-nonce' )
        )
      );

    }

    function yaawp_admin_main () {

      wp_enqueue_style( 'yaawp-css', $this->pluginUrl.'assets/css/admin.css', array(),'0.50','all');
      wp_enqueue_script( 'yaawp-js', $this->pluginUrl.'assets/js/admin.js', array( 'jquery' ),'0.50');
      wp_localize_script( 'yaawp-js', 'yaawp',
        array(
          'ajaxurl'             => admin_url( 'admin-ajax.php' ),
          'nonce'               => wp_create_nonce( 'yaawp-nonce' ),
          'ajax'                => $this->pluginUrl,
          'no_item'             => __('Kein Artikel gefunden.', $this->var_sTextdomain),
          'your_choice'         => __('Bitte Auswahl treffen.', $this->var_sTextdomain),
          'site'                => __('Seite w&auml;hlen', $this->var_sTextdomain),
          'live_dropdown'       => __('Ausw&auml;hlen oder lassen und letzte Kategorie nutzen.', $this->var_sTextdomain),
          'live_dropdown_extra' => __('Ergebnisse:', $this->var_sTextdomain),
          'pluginUrl'           => $this->pluginUrl
        )
      );

    }

    function getTemplate( $template = false ) {

      $ordner = $this->pluginPath.'templates/frontend/product';
      $alledateien = scandir($ordner);
      $templates = '';

      foreach (new DirectoryIterator($this->pluginPath.'templates/frontend/product') as $fileInfo) {

        if($fileInfo->isDot()) continue;

        $value = ( $template && $template == $fileInfo->getFilename() ) ? ' selected' : '';
        $templates .= '<option value="'.$fileInfo->getFilename().'"'.$value.'>'.$fileInfo->getBasename('.php').'</option>';

      }

      return $templates;

    }

    function yaawp_add_texonomy_field () {

      echo '<div class="form-field">
        <label for="taxonomy_image">' . __('Bild', $this->var_sTextdomain) . '</label>
        <input type="text" name="taxonomy_image" id="taxonomy_image" value="" />
        <br/>
        <button class="upload_image_button button">' . __('Bild hinzuf&uuml;gen', $this->var_sTextdomain) . '</button>
      </div>';

    }

    function yaawp_edit_texonomy_field ($taxonomy) {

      if ( $this->yaawp_taxonomy_image_url( $taxonomy->term_id, TRUE ) == $this->pluginUrl.'assets/img/placeholder.png' )
        $image_text = '';
      else
        $image_text = $this->yaawp_taxonomy_image_url( $taxonomy->term_id, TRUE );
      echo '<tr class="form-field">
        <th scope="row" valign="top"><label for="taxonomy_image">' . __('Bild', $this->var_sTextdomain) . '</label></th>
        <td><img class="taxonomy-image" src="' . $this->yaawp_taxonomy_image_url( $taxonomy->term_id, TRUE ) . '"/><br/><input type="text" name="taxonomy_image" id="taxonomy_image" value="'.$image_text.'" /><br />
        <button class="upload_image_button button">' . __('Bild hinzuf&uuml;gen', $this->var_sTextdomain) . '</button>
        <button class="remove_image_button button">' . __('Bild entfernen', $this->var_sTextdomain) . '</button>
        </td>
      </tr>';

    }

    function yaawp_save_taxonomy_image ( $term_id ) {

      if( isset($_POST['taxonomy_image']) )
        update_option('yaawp_taxonomy_image'.$term_id, $_POST['taxonomy_image']);

    }

    function yaawp_taxonomy_image_url ( $term_id = NULL, $return_placeholder = FALSE ) {

      if (!$term_id) {
        if (is_category())
          $term_id = get_query_var('cat');
        elseif (is_tax()) {
          $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
          $term_id = $current_term->term_id;
        }
      }
      $taxonomy_image_url = get_option('yaawp_taxonomy_image'.$term_id);
      if ($return_placeholder)
        return ($taxonomy_image_url != "") ? $taxonomy_image_url : $this->pluginUrl . 'assets/img/placeholder.png';
      else
        return $taxonomy_image_url;

    }

    function yaawp_quick_edit_custom_box ( $column_name, $screen, $name ) {

      if ($column_name == 'thumb') 
        echo '<fieldset>
        <div class="thumb inline-edit-col">
          <label>
            <span class="title"><img src="" alt="' . __('Thumbnail', $this->var_sTextdomain) . '"/></span>
            <span class="input-text-wrap"><input type="text" name="taxonomy_image" value="" class="tax_list" /></span>
            <span class="input-text-wrap">
              <button class="upload_image_button button">' . __('Bild hinzuf&uuml;gen', $this->var_sTextdomain) . '</button>
              <button class="remove_image_button button">' . __('Bild entfernen', $this->var_sTextdomain) . '</button>
            </span>
          </label>
        </div>
      </fieldset>';

    }

    function yaawp_taxonomy_columns ( $columns ) {

      $yaawp_columns = array(
        'cb'    => $columns['cb'],
        'thumb' => __('Bild', $this->var_sTextdomain)
      );

      unset( $columns['cb'] );

      return array_merge( $yaawp_columns, $columns );

    }

    function yaawp_taxonomy_column ( $columns, $column, $id ) {

      if ( $column == 'thumb' )
        $columns = '<span><img src="' . $this->yaawp_taxonomy_image_url($id, TRUE) . '" alt="' . __('Thumbnail', $this->var_sTextdomain) . '" class="wp-post-image" /></span>';
      return $columns;

    }

    function yaawp_taxonomy_columns_shop ( $columns ) {

      $yaawp_columns = array(
        'cb'        => $columns['cb'],
        'thumb'     => __('Bild', $this->var_sTextdomain),
        'categorie' => __('Kategorie', $this->var_sTextdomain),
        'price'     => __('Preis', $this->var_sTextdomain)
      );

      return array_merge( $yaawp_columns, $columns );

    }

    function yaawp_taxonomy_column_shop ( $column, $post_id ) {

      if ( $column == 'thumb' ) {
        echo '<img src="'.get_post_meta($post_id, 'LargeImageUrl', true).'" />';
      }

      if ( $column == 'categorie') {

        $terms = get_the_terms( $post_id, 'shop_category' );
        $out = array();

        if ( is_array($terms) ) {

          foreach ($terms as $term) {
            $out[] = '<a href="' .get_term_link($term->slug, 'shop_category') .'">'.$term->name.'</a>';
          }

        } else {
          $out[] = '<a href="' .get_term_link($term->slug, 'shop_category') .'">'.$term->name.'</a>';
        }

        echo join( ', ', $out );
      }

      if ( $column == 'price') {
        $preis = (get_post_meta($post_id, 'LowestOfferFormattedPrice', true)) ? get_post_meta($post_id, 'LowestOfferFormattedPrice', true) : get_post_meta($post_id, 'LowestNewOfferFormattedPrice', true);
        echo $preis;
      }

      
    }

    function yaawp_change_insert_button_text($safe_text, $text) {
      return str_replace('Insert into Post', 'Use this image', $text);
    }

    function Backend () {

      if ( ! isset( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], 'yaawp-nonce' ) || ! is_admin() ) die ( __('Fehler: Nonce fehlt/falsch oder keine Rechte', $this->var_sTextdomain) );
      
      switch ($_POST['method']) {

        case 'UpdateCache':

          if ( $this->yaawp_cron(true) ) {

            $response = json_encode(array(
              'status' => 1,
              'msg' => __('Cache wurde gel&ouml;scht.', $this->var_sTextdomain)
            ));

          } else {

            $response = json_encode(array(
              'status' => 0,
              'msg' => __('Cache wurde nicht gel&ouml;scht.', $this->var_sTextdomain)
            ));

          }

        break;

        case 'UpdateCacheTime':

          if ( update_option('yaawp_cron_check', $_POST['cron_check']) ) {

            $response = json_encode(array(
              'status' => 1,
              'msg' => __('Cache Interval wurde aktualisiert.', $this->var_sTextdomain)
            ));

          } else {

            $response = json_encode(array(
              'status' => 0,
              'msg' => __('Cache Interval wurde nicht aktualisiert.', $this->var_sTextdomain)
            ));

          }

        break;

        case 'ReadItem':

          $ya = new yaawp_amazon ();

          $response = $ya->ItemLookup($_POST['ASIN'],'Large');

          $_item = $response->Items->Item;
          $this->_yaawp_build_placholder($_item);

          $response = json_encode($this->Placeholder);

        break;
        case 'ReadNodeId':

          $data = array();
          $ya = new yaawp_amazon ();
          $res = $ya->BrowseNodeLookup($_POST['NoteId']);

          if ( isset($res->BrowseNodes->BrowseNode->Children->BrowseNode) ) {

            foreach( $res->BrowseNodes->BrowseNode->Children->BrowseNode as $Note) {

              $Name = (string) $Note->Name;
              $ID = (int) $Note->BrowseNodeId;

              $response = $ya->ItemSearch($_POST['Suchwort'],$_POST['SearchIndex'],1,'Small',$ID);
              $TotalResults = (int) $response->Items->TotalResults; 

              array_push($data, array(
                'Name' => $Name,
                'ID' => $ID,
                'TotalResults' => $TotalResults
              ));
            }

            $response = json_encode(
              array(
                'NoteId' => $_POST['NoteId'],
                'DATA' => $data,
                'res' => $res,
                'error' => 0
              ) 
            );

          } else {

            $response = json_encode(
              array(
                'error' => 1
              ) 
            );

          }       

        break;
        case 'UpdateSettings':

          if ( update_option('yaawp_secret_access_key', $_POST['yaawp_secret_access_key']) ) {

            $status[] = true;
            $msg[] = __('Amazon Geheimer Zugriffsschl&uuml;ssel aktualisiert', $this->var_sTextdomain);

          }

          if ( update_option('yaawp_access_key_id', $_POST['yaawp_access_key_id']) ) {

            $status[] = true;
            $msg[] = __('Amazon Zugriffsschl&uuml;ssel-ID aktualisiert', $this->var_sTextdomain);

          }

          if ( update_option('yaawp_associate_id', $_POST['yaawp_associate_id']) ) {

            $status[] = true;
            $msg[] = __('Amazon Tracking ID aktualisiert', $this->var_sTextdomain);

          }
         
          if ( in_array(true, $status) ) {

            $response = json_encode(array(
              'status' => 1,
              'msg' => $msg
            ));

          } else {

            $response = json_encode(array(
              'status' => 0,
              'msg' => __('Es wurden keine Einstellungen aktualisiert.', $this->var_sTextdomain)
            ));

          }

        break;
        case 'ReadImportItems':

          $data = $this->yaawp_import(array(
            'suchwort' => $_POST['suchwort'],
            'kategorie'=>$_POST['kategorie'],
            'page'=>$_POST['page'],
            'noteid' => $_POST['NoteId'],
            'nodeidoption' => $_POST['nodeidoption']
          ));

          $response = json_encode($data);

        break;
        case 'ReadImportStatus':

          $data = array(
            'status' => isset($_SESSION['import']) ? $_SESSION['import'] : 0,
            'total' => isset($_SESSION['total']) ? $_SESSION['total'] : 0,
            'current' => round((($_SESSION['import']/$_SESSION['total'])*100))
          );

          $response = json_encode($data);

        break;
        case 'CreateImportItem':

          $data = $this->yaawp_import_data(array(
            'asin'=>$_POST['asin'],
            'post_category'=>$_POST['post_category']
          ));
          $response = json_encode($data);

        break;
        case 'CreateImportTerm':

          $insert = wp_insert_term(
            $_POST['name'],
            'shop_category',
            array(
              'description'=> $_POST['description'],
              'slug' => sanitize_title($_POST['slug']),
              'parent'=> ($_POST['parent']) ? $_POST['parent'] : ''
            )
          );

          $response = json_encode(array(
            'id' => $insert['term_id']
          ));

        break;

      }

      header( "Content-Type: application/json" );
      exit($response);

    }

    function yaawp_import_page () {

      $this->yaawp_cron();

      try {

        if (!file_exists($this->pluginPath.'templates/backend/import.php')) throw new Exception (__('Fehler: import.php nicht vorhanden.', $this->var_sTextdomain));
        else include($this->pluginPath.'templates/backend/import.php');

      } catch (Exception $e) {
        echo $e->getMessage();
      }

    }

    function yaawp_settings_page () {

      if ( isset($_GET['yaawp_news']) ) {
        add_option('yaawp_news', (int)$_GET['yaawp_news']);
      }

      $active_tab = isset($_GET[ 'tab' ]) ? $_GET[ 'tab' ] : 'settings';

      $tabs = array(
        'settings' => __('Einstellungen', $this->var_sTextdomain),
        'cache' => __('Cache', $this->var_sTextdomain),
        'sta' => __('Statistik', $this->var_sTextdomain),
        'ueber' => __('&Uuml;ber', $this->var_sTextdomain)
      );

      $links = array();
      foreach( $tabs as $tab => $name ) {
        if ( $tab == $active_tab ) {
          $links[] = "<a class='nav-tab nav-tab-active' href='edit.php?post_type=shop&page=yaawp-einstellungen&tab=$tab'>$name</a>";
        } else {
          $links[] = "<a class='nav-tab' href='edit.php?post_type=shop&page=yaawp-einstellungen&tab=$tab'>$name</a>";
        }
      }

      try {

        if (!file_exists($this->pluginPath.'templates/backend/template.php')) throw new Exception (__('Fehler: template.php nicht vorhanden.', $this->var_sTextdomain));
        else include($this->pluginPath.'templates/backend/template.php');

      } catch (Exception $e) {
        echo $e->getMessage();
      }

    }

    function yaawp_data () {
      return get_plugin_data( __FILE__ );
    }

    function plugin_get_version () {
      $plugin_data = get_plugin_data( __FILE__ );
      $plugin_version = $plugin_data['Version'];
      return $plugin_version;
    }

    function yaawp_user_int () { 

        add_thickbox();

        add_filter( 'template_include', array(&$this, 'yaawp_template_include' ), 10 );

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

    }

    function yaawp_admin_int () {

      add_filter('mce_external_plugins', array(&$this, 'yaawp_mce_external_plugins') );
      add_filter('mce_buttons', array(&$this, 'yaawp_mce_buttons') );

      $taxonomies = get_taxonomies ( array('name'=>'shop_category') );

      if (is_array($taxonomies)) {
        foreach ($taxonomies as $taxonomy ) {
          add_action("{$taxonomy}_add_form_fields", array(&$this, 'yaawp_add_texonomy_field') );
          add_action("{$taxonomy}_edit_form_fields", array(&$this, 'yaawp_edit_texonomy_field') );
          add_filter( "manage_edit-{$taxonomy}_columns", array(&$this, 'yaawp_taxonomy_columns') );
          add_filter( "manage_{$taxonomy}_custom_column", array(&$this, 'yaawp_taxonomy_column'), 10, 3 );
        }
      }

      add_filter( "manage_edit-shop_columns", array(&$this, 'yaawp_taxonomy_columns_shop') );
      add_filter( 'manage_shop_posts_custom_column', array(&$this, 'yaawp_taxonomy_column_shop'), 10, 2 );

      add_action( 'add_meta_boxes', array(&$this, 'template_box') );
      add_action( 'save_post', array(&$this, 'template_box_field'), 10, 2 );

    }
    
    function yaawp_template_redirect () {

      if ( $_SERVER['REQUEST_URI'] == '/shop/' || $_SERVER['REQUEST_URI'] == '/shop_category/' ) {
        include(plugin_dir_path( __FILE__ ) . '/templates/frontend/shop.php');
        exit;
      }

    }

    function yaawp_mce_buttons ($buttons) {
      array_push($buttons, '|', 'yaawp');
      return $buttons;
    }

    function yaawp_mce_external_plugins ($plugin_array) {
      $plugin_array['yaawp'] = $this->pluginUrl.'assets/js/editor_plugin.js';
      return $plugin_array;
    }  

    function yaawp_template_include( $template_path ) {

      if ( get_post_type() == 'shop' ) { 

        if ( is_single() ) {
          $template = get_post_meta( get_the_ID(), 'yaawp_template', true );
          if ( !$template ) $template = 'product.php';
          $template_path = plugin_dir_path( __FILE__ ) . '/templates/frontend/product/'.$template;
        }

        if ( is_archive() ) {
          $template_path = plugin_dir_path( __FILE__ ) . '/templates/frontend/archive.php';
        }

      }

      return $template_path;

    }

    function template_box () {

      add_meta_box( 'some_meta_box_name',__( 'YAAWP Template', $this->var_sTextdomain ),array( &$this, 'yaawp_template' ),'shop','side','default' );

    }

    function yaawp_template () {

      $template = get_post_meta( get_the_ID(), 'yaawp_template', true );
      echo '<select style="width: 100%" name="yaawp_template">'.$this->getTemplate($template).'</select>';

    }

    function template_box_field( $id, $product ) {

      if ( $product->post_type == 'shop' ) {

        if ( isset( $_POST['yaawp_template'] ) && $_POST['yaawp_template'] != '' ) {
            update_post_meta( $id, 'yaawp_template', $_POST['yaawp_template'] );
        }

      }

    }

    function yaawp_cron ( $force = FALSE) {
      
      $meta_table = $this->yaawp_db->prefix . 'postmeta';
      $post_table = $this->yaawp_db->prefix . 'posts';

      if ( $force ) {

        $sql = "SELECT ID, (SELECT meta_value FROM " . $meta_table . " WHERE post_id = " . $post_table . ".ID AND meta_key = 'ASIN') as ASIN
        FROM " . $post_table . " LEFT JOIN " . $meta_table . " 
        ON " . $meta_table . ".post_id = " . $post_table . ".ID   
        WHERE meta_key = 'LastCheck'";

      } else {

        $sql = "SELECT ID, (SELECT meta_value FROM " . $meta_table . " WHERE post_id = " . $post_table . ".ID AND meta_key = 'ASIN') as ASIN
        FROM " . $post_table . " LEFT JOIN " . $meta_table . " 
        ON " . $meta_table . ".post_id = " . $post_table . ".ID   
        WHERE meta_key = 'LastCheck' 
        AND TIME_TO_SEC(TIMEDIFF(NOW(), meta_value)) > " . get_option('yaawp_cron_check') . "";

      }
      
      $post_results = $this->yaawp_db->get_results ( $sql );

      foreach ($post_results as $value) {
        $this->_yaawp_renew_data( $value->ASIN, $value->ID );
      }

      return true;
      
    }

    private function _get_posts_by_meta ( $meta_key, $meta_value, $type = 'get_row' ) {
      
      $meta_table = $this->yaawp_db->prefix . "postmeta";
      $post_table = $this->yaawp_db->prefix . "posts";
      
      $sql = "SELECT * FROM " . $post_table . " LEFT JOIN " . $meta_table . " 
          ON " . $meta_table . ".post_id = " . $post_table . ".ID   
          WHERE meta_key = '" . $meta_key . "' 
          AND meta_value = '" . $meta_value . "'";
      
      $post_results = $this->yaawp_db->{$type} ( $sql );
      
      return $post_results;
      
    }

    private function _yaawp_build_placholder ( $_item ) {

      $this->Placeholder = array(
        'ASIN'                          => (string) $_item->ASIN,
        'SmallImageUrl'                 => ($_item->SmallImage->URL) ? (string)$_item->SmallImage->URL : $this->pluginUrl.'assets/img/kein_foto_small.png',
        'SmallImageWidth'               => (int) $_item->SmallImage->Width,
        'SmallImageHeight'              => (int) $_item->SmallImage->Height,
        'MediumImageUrl'                => ($_item->MediumImage->URL) ? (string)$_item->MediumImage->URL : $this->pluginUrl.'assets/img/kein_foto_medium.png',
        'MediumImageWidth'              => (int) $_item->MediumImage->Width,
        'MediumImageHeight'             => (int) $_item->MediumImage->Height,
        'LargeImageUrl'                 => ($_item->LargeImage->URL) ? (string)$_item->LargeImage->URL : $this->pluginUrl.'assets/img/kein_foto_large.png',
        'LargeImageWidth'               => (int) $_item->MediumImage->Width,
        'LargeImageHeight'              => (int) $_item->MediumImage->Height,
        'ImageSets'                     => (object) $_item->ImageSets,
        'Label'                         => (string) $_item->ItemAttributes->Label,
        'Manufacturer'                  => (string) $_item->ItemAttributes->Manufacturer,
        'Publisher'                     => (string) $_item->ItemAttributes->Publisher,
        'Studio'                        => (string) $_item->ItemAttributes->Studio,
        'Title'                         => (string) $_item->ItemAttributes->Title,
        'AmazonUrl',
        'TotalOffers'                   => (int) $_item->Offers->TotalOffers,
        'LowestOfferPrice'              => (int) $_item->Offers->Offer->OfferListing->Price->Amount,
        'LowestOfferCurrency'           => (string) $_item->Offers->Offer->OfferListing->Price->CurrencyCode,
        'LowestOfferFormattedPrice'     => (string) $_item->Offers->Offer->OfferListing->Price->FormattedPrice,
        'LowestNewPrice'                => (int) $_item->OfferSummary->LowestNewPrice->Amount,
        'LowestNewOfferFormattedPrice'  => (string) $_item->OfferSummary->LowestNewPrice->FormattedPrice,
        'LowestUsedPrice'               => (int) $_item->OfferSummary->LowestUsedPrice->Amount,
        'LowestUsedOfferFormattedPrice' => (string) $_item->OfferSummary->LowestUsedPrice->FormattedPrice,
        'AmountSavedFormattedPrice'     => (string) $_item->Offers->Offer->OfferListing->AmountSaved->FormattedPrice,
        'AmazonPrice',
        'AmazonPriceFormatted',
        'ListPriceFormatted'            => (string) $_item->ItemAttributes->ListPrice->FormattedPrice,
        'AmazonCurrency',
        'AmazonAvailability',
        'AmazonLogoSmallUrl',
        'AmazonLogoLargeUrl',
        'DetailPageURL'                 => (string) $_item->DetailPageURL,
        'Platform'                      => (string) $_item->ItemAttributes->Platform,
        'ISBN'                          => (int) $_item->ItemAttributes->Platform,
        'EAN'                           => (int) $_item->ItemAttributes->EAN,
        'NumberOfPages',
        'ReleaseDate'                   => (string) $_item->ItemAttributes->ReleaseDate,
        'Binding'                       => (string) $_item->ItemAttributes->Binding,
        'Author'                        => (string) $_item->ItemAttributes->Author,
        'Edition',
        'AverageRating',
        'TotalReviews',
        'RatingStars',
        'RatingStarsSrc',
        'Director'                      => (string) $_item->ItemAttributes->Director,
        'RunningTime'                   => (int) $_item->ItemAttributes->RunningTime,
        'Format',
        'CustomRating',
        'ProductDescription'            => (string) $_item->EditorialReviews->EditorialReview->Content,
        'AmazonDescription'             => ($_item->EditorialReviews->EditorialReview[1]->Source && $_item->EditorialReviews->EditorialReview[1]->Source == 'Amazon.de') ? (string) $_item->EditorialReviews->EditorialReview[1]->Content : '',
        'Artist',
        'Comment',
        'PercentageSaved',
        'Prime',
        'PrimePic',
        'HasReviews'                    => (bool) $_item->CustomerReviews->HasReviews,
        'CustomerReviewsIFrameURL'      => (string) $_item->CustomerReviews->IFrameURL,
        'Rating',
        'Tags',
        'Availability'                  => (string) ($_item->Offers->Offer->OfferListing->AvailabilityAttributes->AvailabilityType == 'now') ? 'verf&uuml;gbar' : 'nicht verf&uuml;gbar',
        'AvailabilityColor'             => (string) ($_item->Offers->Offer->OfferListing->AvailabilityAttributes->AvailabilityType == 'now') ? '468847' : 'b94a48',
        'SalesRank'                     => (int) $_item->SalesRank
      );

    }

    private function _yaawp_renew_data ( $asin, $post_id ) {

      $ya = new yaawp_amazon;
      $response = $ya->ItemLookup($asin);

      $_item = $response->Items->Item;
      $this->_yaawp_build_placholder($_item);

      update_post_meta($post_id, 'SmallImageUrl', $this->Placeholder['SmallImageUrl']);
      update_post_meta($post_id, 'Availability', $this->Placeholder['Availability']);
      update_post_meta($post_id, 'AmazonDescription', $this->Placeholder['AmazonDescription']);
      update_post_meta($post_id, 'LargeImageUrl', $this->Placeholder['LargeImageUrl']);
      update_post_meta($post_id, 'ASIN', $this->Placeholder['ASIN']);
      update_post_meta($post_id, 'ListPriceFormatted', $this->Placeholder['ListPriceFormatted']);
      update_post_meta($post_id, 'LowestOfferFormattedPrice', $this->Placeholder['LowestOfferFormattedPrice']);
      update_post_meta($post_id, 'LowestNewOfferFormattedPrice', $this->Placeholder['LowestNewOfferFormattedPrice']);
      update_post_meta($post_id, 'LowestUsedOfferFormattedPrice', $this->Placeholder['LowestUsedOfferFormattedPrice']);
      update_post_meta($post_id, 'AmountSavedFormattedPrice', $this->Placeholder['AmountSavedFormattedPrice']);
      update_post_meta($post_id, 'CustomerReviewsIFrameURL', $this->Placeholder['CustomerReviewsIFrameURL']);
      update_post_meta($post_id, 'DetailPageURL', $this->Placeholder['DetailPageURL']);
      update_post_meta($post_id, 'Binding', $this->Placeholder['Binding']);
      update_post_meta($post_id, 'LastCheck', date('Y-m-d H:i:s')); 

    }

    function yaawp_asin_shortcode ( $atts ) {

      extract( shortcode_atts( array(
        'asin'  => '',
        'template'  => ''
      ), $atts ) );

      $ya = new yaawp_amazon ();

      $response = $ya->ItemLookup($asin,'Large');

      $_item = $response->Items->Item;
      $this->_yaawp_build_placholder($_item);

      if ( strlen($this->Placeholder['Title']) > 30 ) $title = substr($this->Placeholder['Title'],0,30) . ' ...';

      $html = '';

      switch($template) {
        case 1:
          $html .= '<div class="asin" id="' . $this->Placeholder['ASIN'] . '" style="width: 320px;">';
          $html .= '<img width="32" style="float: left; padding-right: 5px; width: 35px; height: 43px" id="' . $this->Placeholder['ASIN'] . '" src="' . $this->Placeholder['SmallImageUrl'] . '">';
          $html .= '<a href="' . $this->Placeholder['DetailPageURL'] . '" title="' .  $this->Placeholder['Title'] . '" target="_blank">' .  $title . '</a><br />';
          $html .= $this->Placeholder['Director'] . ' (' . $this->Placeholder['Binding'] . ')';
          $html .= '</div>';
        break;
        case 2:
          $html .= '<div class="asin" id="' . $this->Placeholder['ASIN'] . '" style="width: 320px;">';
          $html .= '<a href="' . $this->Placeholder['DetailPageURL'] . '" title="' . $this->Placeholder['Title'] . '" target="_blank">' . $title . '</a><br />';
          $html .= $this->Placeholder['Director'] . ' (' .$this->Placeholder['Binding'] . ')';
          $html .= '</div>';
        break;
        case 3:
          $html .= $this->Placeholder['DetailPageURL'];
        break;
      }

      return $html;

    }

    function yaawp_import ( $atts ) {

      extract( shortcode_atts( array(
        'suchwort'          => '',
        'kategorie'         => 'Toys',
        'beschreibung'      => '',
        'noteid'            => '',
        'page'              => 1,
        'nodeidoption'      => ''
      ), $atts ) );

      $ya = new yaawp_amazon ();

      $i = 1;
      $response = $ya->ItemSearch($suchwort,$kategorie,$page,'Small',$noteid);
      $TotalResults = (int) $response->Items->TotalResults;
      $TotalPages = (int) $response->Items->TotalPages;

      $item = '';

      $response = $ya->ItemSearch($suchwort,$kategorie,$page,'Large',$noteid);

      foreach ($response->Items->Item as $mk => $_item) {

        $this->_yaawp_build_placholder($_item);

        $this->Placeholder['ProductDescription'] = wp_strip_all_tags($this->Placeholder['ProductDescription']);
        $this->Placeholder['Title'] = wp_strip_all_tags( replace_mutations( htmlspecialchars($this->Placeholder['Title']) ) );
        $this->Placeholder['Tags'] = density( $this->Placeholder['ProductDescription'] );

        $_EditorialReview_1 = substr($this->Placeholder['ProductDescription'], 0, 200).'...';
        if ( strlen($this->Placeholder['ProductDescription']) > 200 ) {
          $_EditorialReview_2 = substr($this->Placeholder['ProductDescription'], 200);
          $this->Placeholder['ProductDescription'] = $_EditorialReview_1;
        }

        $this->Placeholder['Permalink'] = (string) get_permalink( $postID );
        $this->Placeholder['EditorialReview_1'] = $_EditorialReview_1;

        $mpc = file_get_contents($this->pluginPath . 'templates/backend/import_table.php');
        $mpc = str_replace_assoc($this->Placeholder, $mpc);

        $item .= compress_html($mpc);

        $i++;

      }

      return array(
        'data' => $item,
        'TotalResults' => $TotalResults,
        'TotalPages' => $TotalPages,
        'ActivePage' => $page
      );      

    }

    function yaawp_import_data ( $atts ) {

      global $wpdb;

      extract( shortcode_atts( array(
        'asin'          => '',
        'post_category' => ''
      ), $atts ) );

      $ya = new yaawp_amazon;
      $response = $ya->ItemLookup($asin);

      $_item = $response->Items->Item;
      $this->_yaawp_build_placholder($_item);

      $this->Placeholder['ProductDescription'] = wp_strip_all_tags($this->Placeholder['ProductDescription']);
      $this->Placeholder['ProductDescriptionFull'] = $this->Placeholder['ProductDescription'];
      $this->Placeholder['Title'] = wp_strip_all_tags( replace_mutations( htmlspecialchars($this->Placeholder['Title']) ) );
      $this->Placeholder['Tags'] = density( $this->Placeholder['ProductDescription'] );

      if ( strlen($this->Placeholder['ProductDescription']) > 80 ) {
        $this->Placeholder['ProductDescription'] = substr($this->Placeholder['ProductDescription'], 80);
      }

      $postID = $wpdb->get_var( "SELECT post_id FROM {$wpdb->postmeta} where meta_key = 'ASIN' and meta_value = '{$this->Placeholder['ASIN']}'" );

      if ( !$postID ) {

        $my_post = array(
          'post_title'    => $this->Placeholder['Title'],
          'post_excerpt'  => $this->Placeholder['ProductDescription'],
          'post_content'  => $this->Placeholder['ProductDescriptionFull'],
          'post_status'   => 'publish',
          'post_author'   => 1,
          'comment_status' => $comment_status,
          'post_type'     => 'shop'
        );

        $postID = wp_insert_post( $my_post );
        wp_set_post_terms($postID,$post_category,'shop_category');

        $img = 0;
        foreach ($_item->ImageSets->ImageSet as $image) {
          add_post_meta($postID, 'ImageSetTiny'.$img, (string) $image->TinyImage->URL , true);
          add_post_meta($postID, 'ImageSetLarge'.$img, (string) $image->LargeImage->URL , true);
          $img++;
        }

        add_post_meta($postID, 'SmallImageUrl', $this->Placeholder['SmallImageUrl'] , true);
        add_post_meta($postID, 'Availability', $this->Placeholder['Availability'] , true);
        add_post_meta($postID, 'AmazonDescription', $this->Placeholder['AmazonDescription'] , true);
        add_post_meta($postID, 'LargeImageUrl', $this->Placeholder['LargeImageUrl'] , true);
        add_post_meta($postID, 'ASIN', $this->Placeholder['ASIN'] , true);
        add_post_meta($postID, 'ListPriceFormatted', $this->Placeholder['ListPriceFormatted'] , true);
        add_post_meta($postID, 'LowestOfferFormattedPrice', $this->Placeholder['LowestOfferFormattedPrice'] , true);
        add_post_meta($postID, 'LowestNewOfferFormattedPrice', $this->Placeholder['LowestNewOfferFormattedPrice'] , true);
        add_post_meta($postID, 'LowestUsedOfferFormattedPrice', $this->Placeholder['LowestUsedOfferFormattedPrice'] , true);
        add_post_meta($postID, 'AmountSavedFormattedPrice', $this->Placeholder['AmountSavedFormattedPrice'] , true);
        add_post_meta($postID, 'CustomerReviewsIFrameURL', $this->Placeholder['CustomerReviewsIFrameURL'] , true);
        add_post_meta($postID, 'DetailPageURL', $this->Placeholder['DetailPageURL'] , true);
        add_post_meta($postID, 'Binding', $this->Placeholder['Binding'] , true);
        add_post_meta($postID, 'Binding', $this->Placeholder['Binding'] , true);
        add_post_meta($postID, 'LastCheck', date('Y-m-d H:i:s') , true);

      }

      return array(
        'status' => 1,
        'asin' => $this->Placeholder['ASIN']
      );      

    }

    function activation () {

      $yi = new yaawp_install ();
      
      try {
        $yi->install_db();
      } catch (Exception $e) {
        exit($e->getMessage());
      }

    }

    function deactivation () {

      $yi = new yaawp_install ();

      try {
        $yi->uninstall_db();
      } catch (Exception $e) {
        exit($e->getMessage());
      }  

    }

    function uninstall () {

      $yi = new yaawp_install ();

      try {
        $yi->uninstall_db();
      } catch (Exception $e) {
        exit($e->getMessage());
      }  

    }

  }

}

if ( class_exists('yaawp') ) {
  $yaawp = new yaawp;
}

?>