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
                    <div class="card h-100" data-bs-toggle="modal" data-bs-target="#drinkModal-<?php the_ID(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php the_title(); ?></h5>
                            <p><?php the_excerpt(); ?></p>
                            <p><strong>Prix:</strong> <?php echo esc_html(get_field('prix')); ?> €</p>
                            <!-- Ajout du bouton "Plus de détails" -->
                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#drinkModal-<?php the_ID(); ?>">
                                Plus de Détails
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="drinkModal-<?php the_ID(); ?>" tabindex="-1" aria-labelledby="drinkModalLabel-<?php the_ID(); ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="drinkModalLabel-<?php the_ID(); ?>"><?php the_title(); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><?php the_excerpt(); ?></p>
                                <div class="mb-3">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img src="<?php the_post_thumbnail_url('medium'); ?>" class="img-fluid" alt="<?php the_title(); ?>">
                                    <?php endif; ?>
                                </div>

                                <p><strong>Description:</strong><?php echo esc_html(get_field('description')); ?></p>
                                <p><strong>Prix:</strong> <?php echo esc_html(get_field('prix')); ?> €</p>
                                <p><strong>Ingrédients:</strong> <?php echo esc_html(get_field('ingredients')); ?></p>
                                <p><strong>Stock disponible:</strong> <?php echo esc_html(get_field('quantite_en_stock')); ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            </div>
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