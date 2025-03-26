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


    <main>
        <div class="text-center p-4">
            <h1>Chuck Energy - La Boisson des Légendes</h1>
            <div class="fact-card mx-auto p-4 my-4 shadow-sm rounded" style="max-width: 600px;">
                <p class="fs-4 fw-semibold text-dark"><?php echo do_shortcode('[chuck_norris_fact]'); ?></p>
            </div>
        </div>

        <div class="container  mt-4 px-3">
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

    </main>
    <footer>
        <?php get_footer(); ?>
    </footer>
</body>

</html>