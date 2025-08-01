<?php
// ✅ Enregistre le menu principal
function chuck_energy_register_menus() {
    register_nav_menus(array(
        'main' => __('Menu principal', 'chuck-energy'),
    ));
}
add_action('after_setup_theme', 'chuck_energy_register_menus');




// ✅ Active le support des balises <title> dynamiques
function chuck_energy_theme_support() {
    add_theme_support('title-tag');
    add_theme_support('menus'); // Optionnel ici car déjà fait avec register_nav_menus
}
add_action('after_setup_theme', 'chuck_energy_theme_support');





// ✅ Enregistre les styles du thème et les dépendances
function chuck_energy_enqueue_styles() {
    wp_enqueue_style('chuck-style', get_stylesheet_uri());

    // Include Bootstrap
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), null, true);

    // Include Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'chuck_energy_enqueue_styles');



function create_reviews_post_type() {
    register_post_type('avis', array(
        'labels'      => array(
            'name'          => __('Avis Clients'),
            'singular_name' => __('Avis Client'),
            'menu_name'     => __('Avis Clients'),
            'add_new'       => __('Ajouter un Avis'),
            'add_new_item'  => __('Ajouter un nouvel Avis'),
            'edit_item'     => __('Modifier l\'Avis'),
            'new_item'      => __('Nouvel Avis'),
            'view_item'     => __('Voir l\'Avis'),
            'search_items'  => __('Rechercher un Avis'),
            'not_found'     => __('Aucun avis trouvé'),
            'not_found_in_trash' => __('Aucun avis trouvé dans la corbeille'),
            'all_items'     => __('Tous les Avis'),
        ),
        'public'      => true,
        'has_archive' => false,
        'supports'    => array('title', 'editor', 'thumbnail'),
        'menu_icon'   => 'dashicons-testimonial',
        'capability_type' => 'post',
        'show_in_menu' => true,
    ));
}
add_action('init', 'create_reviews_post_type');


function add_review_meta_box() {
    add_meta_box(
        'review_rating',
        'Note du client (1 à 5)',
        'review_rating_callback',
        'avis',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_review_meta_box');

function review_rating_callback($post) {
    $value = get_post_meta($post->ID, '_review_rating', true);
    echo '<label for="review_rating">Note :</label>';
    echo '<select name="review_rating" id="review_rating">';
    for ($i = 1; $i <= 5; $i++) {
        echo '<option value="' . $i . '" ' . selected($value, $i, false) . '>' . $i . ' étoiles</option>';
    }
    echo '</select>';
}

function save_review_rating($post_id) {
    if (isset($_POST['review_rating'])) {
        update_post_meta($post_id, '_review_rating', sanitize_text_field($_POST['review_rating']));
    }
}
add_action('save_post', 'save_review_rating');


function enqueue_leaflet() {
    wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', [], null);
    wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_leaflet');
