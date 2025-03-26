<?php

/**
 * Template Name: Custom Page Template
 * Description: Un modèle personnalisé pour WordPress
 */
get_header(); ?>

<main>
    <div class="container py-5">
        <div class="row">
            <?php
            $args = array(
                'post_type' => 'drinks',
                'posts_per_page' => -1
            );
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) {
                while ($the_query->have_posts()) {
                    $the_query->the_post(); ?>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            <?php if (has_post_thumbnail()) : ?>
                                <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php the_title(); ?></h5>
                                <p><strong><?php the_excerpt(); ?></strong></p>
                                <p><strong>Prix:</strong> <?php echo esc_html(get_field('prix')); ?> €</p>
                                <p><strong>Ingrédients:</strong> <?php echo esc_html(get_field('ingredients')); ?></p>
                                <p><strong>Stock disponible: </strong> <?php echo esc_html(get_field('quantite_en_stock')); ?></p>
                            </div>
                        </div>
                    </div>
            <?php }
                wp_reset_postdata();
            } else {
                echo '<p class="text-center">Aucune boisson trouvée.</p>';
            }
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>