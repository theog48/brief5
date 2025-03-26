<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body <?php body_class(); ?>>


    <!-- caroussel -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="5" aria-label="Slide 6"></button>
        </div>
        <div class="carousel-inner ">
            <!-- Première slide -->
            <div class="carousel-item active">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chuck.png" class="d-block w-100" alt="Chuck Norris tenant une bouteille">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Chuck Norris - La Légende</h5>
                    <p>Découvrez la puissance de Chuck Energy, la boisson des champions !</p>
                </div>
            </div>
            <!-- Deuxième slide -->
            <div class="carousel-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chuckblackwhite.png" class="d-block w-100" alt="Chuck Norris tenant une bouteille">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Boostez votre énergie</h5>
                    <p>Chuck Energy, pour vous donner des ailes toute la journée !</p>
                </div>
            </div>
            <!-- Troisième slide -->
            <div class="carousel-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chuckbouteil.png" class="d-block w-100" alt="Chuck Norris tenant une bouteille">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Chuck Norris - La Légende</h5>
                    <p>Découvrez la puissance de Chuck Energy, la boisson des champions !</p>
                </div>
            </div>
            <!-- Quatrième slide -->
            <div class="carousel-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chuckcannette.png" class="d-block w-100" alt="Chuck Norris tenant une canette Chuck Energy">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Le Kick de l'énergie</h5>
                    <p>Boire Chuck Energy, c'est affronter la journée comme un roundhouse kick.</p>
                </div>
            </div>
            <!-- 5 slide -->
            <div class="carousel-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chuckblackwhite.png" class="d-block w-100" alt="Bouteille Chuck Norris">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Chuck Norris - La Légende</h5>
                    <p>Découvrez la puissance de Chuck Energy, la boisson des champions !</p>
                </div>
            </div>
            <!-- 6 slide -->
            <div class="carousel-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chuckgun.png" class="d-block w-100" alt="Chuck Norris tenant une bouteille">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Boostez votre énergie</h5>
                    <p>Chuck Energy, pour vous donner des ailes toute la journée !</p>
                </div>
            </div>
        </div>
        <!-- Contrôles du carrousel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>