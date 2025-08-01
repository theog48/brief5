<?php
/* Template Name: Formulaire de commande Chuck */
get_header();
?>

<div class="container mt-5 mb-5">
    <h1 class="mb-4">Commander une Chuck Energy 💥</h1>
    <h5><?php the_content(); ?></h5>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["chuck_order"])) {

        $boissons = $_POST["boisson"];
        $errors = []; // Tableau pour stocker les erreurs de stock insuffisant

        foreach ($boissons as $boisson_slug => $quantite) {
            $quantite = intval($quantite);
            $args = [
                'post_type' => 'drinks',
                'name'      => sanitize_title($boisson_slug),
                'numberposts' => 1
            ];
            $drink_posts = get_posts($args);
            $drink_post = !empty($drink_posts) ? $drink_posts[0] : null;

            if ($drink_post) {
                $stock = get_field('quantite_en_stock', $drink_post->ID); // Récupère le stock depuis ACF
                if ($quantite > $stock) {
                    $errors[] = "⚠️ La boisson '$boisson_slug' n'est pas disponible en quantité suffisante. Stock actuel : $stock.";
                }
            }
        }

        // Si des erreurs sont présentes, 
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<div class="alert alert-danger">' . esc_html($error) . '</div>';
            }
            return; // Arrête le script si des erreurs existent
        }

        // Sanitize user inputs
        $prenom = sanitize_text_field($_POST["prenom"]);
        $nom = sanitize_text_field($_POST["nom"]);
        $email = sanitize_email($_POST["email"]);
        $telephone = sanitize_text_field($_POST["telephone"]);
        $adresse = sanitize_text_field($_POST["adresse"]);
        $boissons = $_POST["boisson"];
        $message = isset($_POST["message"]) ? sanitize_textarea_field($_POST["message"]) : '';
        $promo_code = isset($_POST["promo_code"]) ? sanitize_text_field($_POST["promo_code"]) : "";

        // Define valid promo codes
        $valid_promo_codes = ["CHUCK10" => 10, "FREETRY" => 5];
        $discount = $valid_promo_codes[$promo_code] ?? 0;

        // Server-side calculation of total price
        $order_details = "";
        $total_price = 0;

        foreach ($boissons as $boisson_slug => $quantite) {
            $quantite = intval($quantite);
            $args = [
                'post_type' => 'drinks',
                'name'      => sanitize_title($boisson_slug),
                'numberposts' => 1
            ];
            $drink_posts = get_posts($args);
            $drink_post = !empty($drink_posts) ? $drink_posts[0] : null;
            $price = $drink_post ? get_field('prix', $drink_post->ID) : 0;

            if ($quantite > 0 && $price) {
                $order_details .= ucfirst($boisson_slug) . ": $quantite x $price € = " . ($quantite * $price) . " €\n";
                $total_price += $quantite * $price;
            }
        }

        // Apply discount
        $discount_amount = ($discount < 100) ? ($total_price * $discount / 100) : min($discount, $total_price);
        $total_price -= $discount_amount;

        // Email to Admin
        $to = get_option('admin_email');
        $subject = "Commande Chuck Elixir de $prenom $nom";
        $body = "Merci beaucoup pour votre commande chez Chuck Energy ! 💥 Nous avons bien reçu votre demande et préparons votre commande avec soin.\n\n"
            . "Voici les détails de votre commande :\n\n"
            . "Nom : $prenom $nom\n"
            . "Email : $email\n"
            . "Téléphone : $telephone\n"
            . "Adresse de Livraison : $adresse\n"
            . "Boissons :\n$order_details\n"
            . "Code Promo : " . ($promo_code ? "$promo_code (-$discount_amount €)" : "Aucun") . "\n"
            . "Total : $total_price €\n"
            . "Message : $message"
            . "\n\n"
            . "N'oubliez pas de partager votre expérience avec nous sur nos réseaux sociaux en utilisant #ChuckElixir 💥"
            . "Nous vous remercions de choisir Chuck Elixir pour vous énergiser. 💪"
            . "\n\n"
            . "À bientôt et prenez soin de vous !"
            . "\n\n"
            . "PS : Utilisez le code promo CHUCK10 lors de votre prochaine commande pour une réduction de 10% !";

        $headers = ["From: $prenom $nom <$email>", "Content-Type: text/plain; charset=UTF-8"];

        if (wp_mail($to, $subject, $body, $headers)) {
            echo '<div class="alert alert-success">💪 Votre commande a été envoyée ! Un mail récapitulatif vient de vous être envoyé.</div>';
        } else {
            echo '<div class="alert alert-danger">😞 Une erreur est survenue lors de l\'envoi de la commande.</div>';
        }
    }
    ?>

    <form method="post" class="mt-4">
        <input type="hidden" name="chuck_order" value="1">

        <!-- Personal Information Section -->
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" id="prenom" name="prenom" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" id="nom" name="nom" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-9 mb-3">
                <label for="adresse" class="form-label">Adresse de livraison</label>
                <input type="adresse" id="adresse" name="adresse" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="tel" id="telephone" name="telephone" class="form-control" required>
            </div>
        </div>

        <!-- Drinks Section -->
        <div class="row">
            <?php
            $query = new WP_Query(['post_type' => 'drinks', 'posts_per_page' => -1]);
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $drink_name = get_the_title();
                    $drink_price = get_field('prix');
                    $drink_image = get_field('image'); // This is now a string (URL)
                    $stock = get_field('quantite_en_stock');
            ?>
                    <div class="col-6 col-md-4 col-lg-3 mb-4"> <!-- Responsive grid -->
                        <div class="card h-100 text-center border border-danger shadow-sm"> <!-- Bootstrap border-danger for red border -->
                            <?php if ($drink_image) : ?>
                                <img src="<?= esc_url($drink_image); ?>" alt="<?= esc_attr($drink_name); ?>" class="card-img-top img-fluid rounded-top" style="max-height: 120px; object-fit: cover;" /> <!-- Rounded top and adjusted height -->
                            <?php endif; ?>
                            <div class="card-body p-3"> <!-- Reduced padding -->
                                <h6 class="card-title text-truncate fw-bold"><?= esc_html($drink_name); ?></h6> <!-- Bold title -->
                                <p class="card-text text-muted mb-2">
                                    Prix: <strong><?= esc_html($drink_price); ?> €</strong><br>
                                    <?php if ($stock > 0) : ?>
                                        Stock: <strong><?= esc_html($stock); ?> unités</strong>
                                    <?php endif; ?>
                                </p>
                                <?php if ($stock > 0) : ?>
                                    <input type="number" name="boisson[<?= esc_attr($post->post_name); ?>]" class="form-control form-control-sm drink-quantity"
                                        data-price="<?= esc_attr($drink_price); ?>"
                                        data-stock="<?= esc_attr($stock); ?>"
                                        min="0" max="<?= esc_attr($stock); ?>"
                                        value="0" placeholder="Quantité">
                                <?php else : ?>
                                    <p class="text-danger fw-bold">Plus de stock</p>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
            <?php
                }
                wp_reset_postdata();
            } else {
                echo '<p class="text-center">Aucune boisson disponible.</p>';
            }
            ?>
        </div>

        <!-- Message and Promo Code Section -->
        <div class="row">
            <div class="col-12 mb-3"> <!-- Full-width message field -->
                <label for="message" class="form-label">Message (optionnel)</label>
                <textarea id="message" name="message" class="form-control" rows="4"></textarea>
            </div>
            <div class="col-md-6 mb-3"> <!-- Promo code field -->
                <label for="promo_code" class="form-label">Code Promo</label>
                <input type="text" id="promo_code" name="promo_code" class="form-control">
            </div>
        </div>

        <!-- Total Section -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <p><strong>Total HT:</strong> <span id="total-ht">0.00</span> €</p>
                <p><strong>TVA (20%):</strong> <span id="tva-amount">0.00</span> €</p>
                <p><strong>Total TTC:</strong> <span id="total-ttc">0.00</span> €</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-warning btn-md">Commander <i class="fas fa-shopping-cart ms-2"></i></button>
            </div>
        </div>
    </form>
</div>

<div class="container" style="max-width: 80%; padding: 20px;">
    <div id="map" style="height: 300px; width: 100%;"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function calculateTotal() {
            let totalTTC = 0; // Total TTC
            let totalHT = 0; // Total HT pour calcul TVA
            let tvaAmount = 0; // Total TVA pour affichage

            document.querySelectorAll('.drink-quantity').forEach(input => {
                let priceTTC = parseFloat(input.getAttribute('data-price')) || 0; // Prix TTC
                let quantity = parseInt(input.value) || 0;
                let stock = parseInt(input.getAttribute('data-stock')) || 0;

                // Empêche d'entrer une quantité supérieure au stock
                if (quantity > stock) {
                    input.value = stock; // Ajuste la quantité
                    quantity = stock;
                    console.log(`Boisson: ${input.name}, Quantité entrée: ${quantity}, Stock dispo: ${stock}`);
                }

                totalTTC += priceTTC * quantity; // Calcul du total TTC

                let priceHT = priceTTC / 1.20; // Récupérer le prix HT en retirant la TVA de 20%
                totalHT += priceHT * quantity; // Total HT
                tvaAmount += (priceTTC - priceHT) * quantity; // Calcul de la TVA pour affichage
            });

            let promoCode = document.getElementById("promo_code").value.trim();
            let validPromoCodes = {
                "CHUCK10": 0.1,
                "FREETRY": 5
            };
            let discount = validPromoCodes[promoCode] ? (validPromoCodes[promoCode] < 1 ? totalTTC * validPromoCodes[promoCode] : validPromoCodes[promoCode]) : 0;
            totalTTC = Math.max(totalTTC - discount, 0);

            // Affichage des résultats
            document.getElementById('total-ht').innerText = totalHT.toFixed(2) + " € HT"; // Affichage du total HT
            document.getElementById('tva-amount').innerText = tvaAmount.toFixed(2) + " € TVA"; // Affichage de la TVA pour information
            document.getElementById('total-ttc').innerText = totalTTC.toFixed(2) + " € TTC"; // Affichage total TTC 
        }

        // Ajouter des écouteurs d'événements
        document.querySelectorAll('.drink-quantity').forEach(input => input.addEventListener('input', calculateTotal));
        document.getElementById("promo_code").addEventListener("input", calculateTotal);

        // Initialisation de la carte Leaflet
        var map = L.map('map').setView([48.8566, 2.3522], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([48.8566, 2.3522]).addTo(map)
            .bindPopup('Chuck Energy Headquarters')
            .openPopup();
    });
</script>
<?php get_footer(); ?>