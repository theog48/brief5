<?php
/*
Plugin Name: Chuck Norris Facts
Description: Affiche des faits amusants sur Chuck Norris.
Version: 1.0
Author: Walker’s Elixir
*/

// Fonction pour récupérer un fait aléatoire sur Chuck Norris
function get_chuck_norris_fact() {
    $response = wp_remote_get('https://api.chucknorris.io/jokes/random');
    
    if (is_wp_error($response)) {
        return 'Impossible de récupérer un fait Chuck Norris.';
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    return $data['value'];
}

// Shortcode pour afficher le fait
function chuck_norris_fact_shortcode() {
    $fact = get_chuck_norris_fact();
    return '<div class="chuck-norris-fact"><p>' . esc_html($fact) . '</p></div>';
}
add_shortcode('chuck_norris_fact', 'chuck_norris_fact_shortcode');

// Widget pour afficher le fait
class Chuck_Norris_Fact_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'chuck_norris_fact_widget',
            'Chuck Norris Fact', // Titre sans traduction
            array('description' => 'Affiche un fait aléatoire sur Chuck Norris.') // Description sans traduction
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        echo $args['before_title'] . 'Chuck Norris Fact' . $args['after_title']; // Titre sans traduction
        echo '<p>' . esc_html(get_chuck_norris_fact()) . '</p>';
        echo $args['after_widget'];
    }
}

// Enregistrer le widget
function register_chuck_norris_fact_widget() {
    register_widget('Chuck_Norris_Fact_Widget');
}
add_action('widgets_init', 'register_chuck_norris_fact_widget');
