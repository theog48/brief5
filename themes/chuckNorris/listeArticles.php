<?php
/* Template Name: Liste des Articles */
get_header();
?>

<!-- Ajout de Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

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
                $article_url = "https: //greta.3.lopia.fr/article-1/" . '?article=' . urlencode(get_the_title());
        ?>
            <div class="col-md-4 mb-4">
                <div class="article-container p-3 border rounded shadow-sm">
                    <h3 class="article-title"><?php the_title(); ?></h3>
                    <p class="article-excerpt"><?php echo wp_trim_words(get_the_content(), 20); ?>...</p>
                    <!-- Ajouter un paramètre dans l'URL pour l'article -->
                    <a href="<?php echo esc_url($article_url); ?>" class="btn btn-primary">Lire plus</a>
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
