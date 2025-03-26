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

// ✅ Enregistre une sidebar (widget)
function chuck_energy_register_sidebar() {
    register_sidebar(array(
        'name'          => 'Sidebar Chuck',
        'id'            => 'sidebar-chuck',
        'before_widget' => '<div class="chuck-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'chuck_energy_register_sidebar');
