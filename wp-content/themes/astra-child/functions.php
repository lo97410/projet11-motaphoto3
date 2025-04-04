<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
        
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_separate', trailingslashit( get_stylesheet_directory_uri() ) . 'ctc-style.css', array( 'astra-theme-css' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION


/*------------------------------------------ Inclusion google font --------------------------------------*/
function astra_child_enqueue_google_fonts() {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', false);
}
add_action('wp_enqueue_scripts', 'astra_child_enqueue_google_fonts');

function astra_child_preload_google_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    echo '<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">';
}
add_action('wp_head', 'astra_child_preload_google_fonts');


/*----------------------------------------- Hook filter upload SVG ----------------------------------------*/
function allow_svg_uploads($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');


/*-------------------------------------- Inclusions des css et js --------------------------------------*/
function child_theme_enqueue_css_js() {
    wp_enqueue_style(
        'child-theme-style',
        get_stylesheet_directory_uri() . '/styles/child-style.css',
        array(), // Dependencies (none in this case)
        '1.0.0', // Version
        'all' // Media type
    );

    // Enqueue JavaScript file
    wp_enqueue_script(
        'js-theme-script', // Handle
        get_stylesheet_directory_uri() . '/js/child-js.js', // Path to JS file
        array('jquery'), // Dependencies (e.g., jQuery)
        '1.0.0', // Version
        true // Load in footer
    );

    // Enqueue AJAX js file
    wp_enqueue_script(
        'ajax-theme-script', // Handle
        get_stylesheet_directory_uri() . '/js/ajax-child.js', // Path to JS file
        array('jquery'), // Dependencies (e.g., jQuery)
        '1.0.0', // Version
        true // Load in footer
    );
}
add_action('wp_enqueue_scripts', 'child_theme_enqueue_css_js' );

// Icones Font awesome
/*function add_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
}
add_action('wp_enqueue_scripts', 'add_font_awesome');*/


/*-------------------------------- Inclusion template part dans single.php -----------------------------*/
function astra_child_single_template_part() {
    if (is_single()) {
        get_template_part('template-parts/single_photo');
    }
}
add_action('astra_entry_after', 'astra_child_single_template_part');

/*----------------------------------------- Contact et nav --------------------------------------------*/
/*function custom_post_navigation() {
    //-------------------------- Section photos liées x2 ---------------------------------//
    //get_template_part('template-parts/photo_block');
    get_template_part('template-parts/bloc_2photos_dans_single');
}
add_action('astra_content_after', 'custom_post_navigation');*/


/*----------------------------------- Shortcode template part pour integration Elementor -----------------------------------------------------*/
/*----------------------- Forcer l'execution des shortcodes dans Elementor gratuit ----------------------------------*/
add_filter('widget_text', 'do_shortcode');
add_filter('widget_text_content', 'do_shortcode'); // Pour Gutenberg et Elementor

/*------------------ Shortcode 8 photos page d'accueil ------------------*/
function shortCode_block_8_photos_filtrables() {
ob_start();
    get_template_part('template-parts/block_8_photos_filtrables');
    return ob_get_clean();
}
add_shortcode('block_8_photos_filtrables', 'shortCode_block_8_photos_filtrables');


/*----------------------------------------------------------------- AJAX page d'accueil ------------------------------------------------*/

/* ------------------------------------- Fonction pour afficher selon les filtres --------------------------------*/
function get_photos_ajax() {
    error_log(print_r($_POST, true));////// Erreur enregistrée dans le log

    if (!isset($_POST['categorie']) || !isset($_POST['format']) || !isset($_POST['type']) || !isset($_POST['annee'])) {
        wp_send_json_error("Données manquantes");
        wp_die();
    }

    $categorie = sanitize_text_field($_POST['categorie']);
    $format = sanitize_text_field($_POST['format']);
    $type = sanitize_text_field($_POST['type']);
    $annee = sanitize_text_field($_POST['annee']);

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => -1,
        'tax_query'      => array( // Filtre les termes de taxonomy
            'relation' => 'AND',
        ),
        'meta_query'     => array( // Filtre les termes de champs personnalisés
            'relation' => 'AND',
        ),
    );

    if (!empty($categorie)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => $categorie,
        );
    }

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    if (!empty($type)) {
        $args['meta_query'][] = array(
            'key'     => 'type',
            'value'   => $type,
            'compare' => '=',
        );
    }

    if (!empty($annee)) {
        $args['meta_query'][] = array(
            'key'     => 'annee',
            'value'   => $annee,
            'compare' => '=',
        );
    }

    error_log("Arguments WP_Query : " . print_r($args, true));////// Vérifications dans les logs

    $query = new WP_Query($args);
    
    error_log("Nombre de posts trouvés : " . $query->found_posts);////// Nb de posts trouvés
    error_log("Arguments AJAX : " . print_r($args, true));////// Vérifications dans les logs

    $photos = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $id = get_the_ID();
            $image_url = get_the_post_thumbnail_url($id, 'large');
            if ($image_url) {
                $photos[] = array(
                    'id'    => get_the_ID(),
                    'titre' => get_the_title(),
                    'url'   => get_permalink($id),
                    'image' => $image_url,
                );
            }
        }
        wp_reset_postdata();
    }

    wp_send_json($photos);
    wp_die();

    error_log("Réponse AJAX : " . print_r($photos, true));////// Vérifications dans les logs
}// Fin de function get_photos_ajax()

add_action('wp_ajax_get_photos', 'get_photos_ajax');
add_action('wp_ajax_nopriv_get_photos', 'get_photos_ajax');

/*------------------------------------------------ FIN DE  Fonction pour afficher selon les filtres --------------------------------------------------------*/

/* ------------------------------------------------ Fonction pour tout afficher avec pagination -------------------------------------------------------------*/
function voir_plus_photos_ajax() {
    error_log(print_r($_POST, true));////// Erreur enregistrée dans le log

    // Gestion de la pagination
    /*$curent_page = get_query_var('paged');
    error_log(print_r($curent_page, true));////// Erreur enregistrée dans le log

    if (!$curent_page || $curent_page < 1) {
        $next_page = 1; // Si la variable 'paged' est vide ou inférieure à 1, on force la valeur à 1
    }
    else {
        $next_page = $curent_page + 1;
    }
    error_log('Page suivante dans function.php : ' . $next_page);//////

    //echo "*** paged aftre check : ".$curent_page." *** ";////// BUG JSON !!!*/

    if(isset($_POST['paged'])) {
        $next_page = $_POST['paged'];
    }
    else {
        $next_page = 1;
    }

    // Arguments de la requête WP_Query pour obtenir les 8 posts suivants
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $next_page,
        'post_status'    => 'publish',
    );
    //var_dump($args);////// BUG JSON !!!

    error_log("Arguments WP_Query : " . print_r($args, true));////// Vérifications dans les logs

    $query = new WP_Query($args);
    
    error_log("Nombre de posts trouvés : " . $query->found_posts);////// Nb de posts trouvés
    error_log("Arguments AJAX : " . print_r($args, true));////// Vérifications dans les logs

    $photos = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $id = get_the_ID();
            $image_url = get_the_post_thumbnail_url($id, 'large');
            if ($image_url) {
                $photos[] = array(
                    'id'    => get_the_ID(),
                    'titre' => get_the_title(),
                    'url'   => get_permalink($id),
                    'image' => $image_url,
                );
            }
        }
        wp_reset_postdata();
    }

    wp_send_json($photos);
    wp_die();

    error_log("Réponse AJAX : " . print_r($photos, true));////// Vérifications dans les logs
}
add_action('wp_ajax_voir_plus_photos', 'voir_plus_photos_ajax');
add_action('wp_ajax_nopriv_voir_plus_photos', 'voir_plus_photos_ajax');

// Vérifier le chargement de JQuery
function charger_jquery_personnalise() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'charger_jquery_personnalise');
