<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?php wp_title('|', true, 'right');
            bloginfo('name'); ?></title>

</head>

<body class="d-flex flex-column min-vh-100">

    <?php get_header(); ?>

    <main class="flex-grow-1">
        <div class="cta-section text-center py-5">
            <h1>Chuck Energy - La Boisson des Légendes</h1>
            <div class="fact-card mx-auto p-4 my-4 shadow-sm rounded">
                <p class="fs-3 fw-semibold text-dark"><?php echo do_shortcode('[chuck_norris_fact]'); ?></p>
            </div>
        </div>


        <div class="hero">
            <section class="cta-section mt-4">
                <div class="container d-flex flex-column justify-content-center align-items-center text-center" style="min-height: 150px;">
                    <h3 class="mb-3">Prêt à commander ?</h3>
                    <p class="mb-4">Cliquez ci-dessous pour passer votre commande dès maintenant !</p>
                    <a href="<?php echo get_permalink(106); ?>" class="btn btn-light btn-lg cta-button">Commander Maintenant</a>
                </div>
            </section>
        </div>

        <!-- Inclusion des cartes -->
        <section>
            <?php get_template_part('cards'); ?>
        </section>

        <div class="hero">
            <section class="cta-section mt-4">
                <div class="container d-flex flex-column justify-content-center align-items-center text-center" style="min-height: 150px;">
                    <h3 class="mb-3">Nos articles</h3>
                    <p class="mb-4">Nous postons souvent des articles pour vous aider à mieux comprendre notre boisson révolutionnaire.</p>
                    <a href="<?php echo get_permalink(240); ?>" class="btn btn-light btn-lg cta-button">Nos articles</a>
                </div>
            </section>
        </div>

    </main>
    <footer>
        <?php get_footer(); ?>
    </footer>
</body>
</html>