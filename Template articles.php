<?php
/* Template Name: Lire un article */
get_header();
?>

<!-- Ajout de Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

<div class="container mt-5">
    <?php
    // Récupérer le nom de l'article à partir du paramètre URL 'article'
    $article_slug = isset($_GET['article']) ? sanitize_text_field($_GET['article']) : '';

    // Si un nom d'article est fourni, rechercher cet article
    if ($article_slug) {
        $args = array(
            'name'        => $article_slug, // Slug de l'article
            'post_type'   => 'post', // Type de contenu : article
            'post_status' => 'publish', // Seulement les articles publiés
            'numberposts' => 1, // Limiter à un seul article
        );

        $post = get_posts($args);

        if ($post) :
            // Commencer à afficher l'article
            $post = $post[0];
            setup_postdata($post);
    ?>
            <div class="article-container p-4 border rounded shadow-sm">
                <h1 class="article-title text-center mb-4"><?php the_title(); ?></h1>
                <p class="text-muted text-center"><?php the_date(); ?> par <?php the_author(); ?></p>
                <div class="article-content mt-4">
                    <?php the_content(); ?>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="<?php echo home_url('/'); ?>" class="btn btn-secondary">Retour à l'accueil</a>
            </div>
        <?php
        else :
            echo '<p>Article non trouvé.</p>';
        endif;
    } else {
        echo '<p>Veuillez spécifier un article.</p>';
    }
    ?>
</div>

<?php get_footer(); ?>
