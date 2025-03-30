<?php
/* Template Name: Liste des Articles */
get_header();
?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Tous les Articles</h1>
    <div class="row">
        <?php
        // WP Query pour récupérer tous les articles
        $args = array(
            'post_type' => 'post',  // Type de contenu 'post' pour les articles
            'posts_per_page' => -1, // Récupérer tous les articles
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                // Ajouter un paramètre à l'URL de chaque article
                $article_url = "https://greta.3.lopia.fr/article-1/" . '?article=' . urlencode(get_the_title());
        ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-dark">
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title"><?php the_title(); ?></h3>
                            <p class="card-text"><?php echo wp_trim_words(get_the_content(), 20); ?>...</p>
                            <a href="<?php echo esc_url($article_url); ?>" class="btn btn-light mt-auto">Lire plus</a>
                        </div>
                    </div>
                </div>
            <?php
            endwhile;
            wp_reset_postdata();
        else :
            ?>
            <p>Aucun article trouvé.</p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>