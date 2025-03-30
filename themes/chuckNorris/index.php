<?php get_header(); ?>
<main>
    <div class="text-center p-4">
        <h1>Chuck Energy - La Boisson des Légendes</h1>
        <div class="fact-card mx-auto p-4 my-4 shadow-sm rounded" style="max-width: 600px;">
            <p class="fs-4 fw-semibold text-dark"><?php echo do_shortcode('[chuck_norris_fact]'); ?></p>
        </div>
    </div>

    <div class="container">
        <div class="row g-3">
            <div class="col-md-6">
                <section class="cta-section p-3 text-center shadow-sm rounded" style="min-height: 120px;">
                    <h4 class="mb-2">Prêt à commander ?</h4>
                    <p class="mb-3">Cliquez ci-dessous pour passer votre commande dès maintenant !</p>
                    <a href="<?php echo get_permalink(106); ?>" class="btn btn-danger btn-sm">Commander Maintenant</a>
                </section>
            </div>
            <div class="col-md-6">
                <section class="cta-section p-3 text-center shadow-sm rounded" style="min-height: 120px;">
                    <h4 class="mb-2">Nos articles</h4>
                    <p class="mb-3">Découvrez nos articles pour tout savoir sur notre boisson révolutionnaire.</p>
                    <a href="<?php echo get_permalink(240); ?>" class="btn btn-primary btn-sm">Nos articles</a>
                </section>
            </div>
        </div>
    </div>

    <!-- Inclusion des cartes -->
    <section>
        <?php get_template_part('cards'); ?>
    </section>

    <div class="container my-5">
        <h2 class="text-center my-4">Ce que disent nos clients</h2>
        <div class="row">
            <?php
            $query = new WP_Query(array(
                'post_type'      => 'avis',
                'posts_per_page' => 3,
                'orderby'        => 'date',
                'order'          => 'DESC'
            ));

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    $rating = get_post_meta(get_the_ID(), '_review_rating', true);
            ?>
                    <div class="col-md-4">
                        <div class="toast align-items-center show mb-3" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <strong class="me-auto"><?php the_title(); ?></strong>
                                <small><?php echo get_the_date('H:i'); ?></small>
                            </div>
                            <div class="toast-body">
                                <div class="mb-2 text-warning">
                                    <?php for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $rating ? '⭐' : '☆';
                                    } ?>
                                </div>
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="text-center">Aucun avis client pour le moment.</p>';
            endif;
            ?>
        </div>
    </div>


</main>

<?php get_footer(); ?>