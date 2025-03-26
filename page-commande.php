<?php
/* Template Name: Formulaire de commande Chuck */
get_header();
?>

<!-- Add Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

<div class="container mt-5 mb-5">
    <h1>Commander une Chuck Energy 💥</h1>
    <h5><?php the_content(); ?></h5>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["chuck_order"])) {
        // Sanitize user inputs
        $prenom = sanitize_text_field($_POST["prenom"]);
        $nom = sanitize_text_field($_POST["nom"]);
        $email = sanitize_email($_POST["email"]);
        $telephone = sanitize_text_field($_POST["telephone"]);
        $boissons = $_POST["boisson"];
        $message = sanitize_textarea_field($_POST["message"]);

        // Prepare the order details
        $order_details = "";
        $total_price = 0;

        foreach ($boissons as $boisson_slug => $quantite) {
            $quantite = intval($quantite);
            // Retrieve the custom field 'prix' for the drink post by slug
            $drink_post = get_page_by_path($boisson_slug, OBJECT, 'drinks'); // 'drinks' is the post type
            $price = $drink_post ? get_field('prix', $drink_post->ID) : 0;

            if ($quantite > 0 && $price) {
                $order_details .= ucfirst($boisson_slug) . ": $quantite x $price € = " . ($quantite * $price) . " €\n";
                $total_price += $quantite * $price;
            }
        }

        // Email to Admin
        $to = get_option('admin_email'); // Get admin email from WordPress settings
        $subject = "Nouvelle commande Chuck Energy";
        $body = "Nouvelle commande :\n\n"
              . "Nom : $prenom $nom\n"
              . "Email : $email\n"
              . "Téléphone : $telephone\n"
              . "Boissons :\n$order_details\n"
              . "Total : $total_price €\n"
              . "Message : $message";
        $headers = ["From: $prenom $nom <$email>"];
        wp_mail($to, $subject, $body, $headers);

        // Email to Client
        $client_subject = "Récapitulatif de votre commande chez Chuck Energy";
        $client_body = "
        <html>
        <body style=\"font-family: Arial, sans-serif; line-height: 1.5;\">
            <h2>Merci pour votre commande, $prenom !</h2>
            <p>Voici un récapitulatif de votre commande :</p>
            <ul>
                <li><strong>Nom :</strong> $prenom $nom</li>
                <li><strong>Email :</strong> $email</li>
                <li><strong>Téléphone :</strong> $telephone</li>
                <li><strong>Boissons :</strong><br>" . nl2br($order_details) . "</li>
                <li><strong>Total :</strong> $total_price €</li>
                <li><strong>Message :</strong> " . nl2br($message) . "</li>
            </ul>
            <p>Nous traiterons votre commande dès que possible et vous tiendrons informé de l’expédition.</p>
            <p>Pour toute question, veuillez nous contacter à <a href=\"mailto:support@chuckenergy.com\">support@chuckenergy.com</a>.</p>
            <p style=\"font-size: 12px; color: gray;\">Vos données personnelles sont sécurisées conformément à notre politique de confidentialité.</p>
        </body>
        </html>";
        $client_headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Chuck Energy <no-reply@chuckenergy.com>'
        );
        wp_mail($email, $client_subject, $client_body, $client_headers);

        // Display success message
        echo '<div class="alert alert-success">💪 Votre commande a été envoyée ! </div>';
    }
    ?>

    <!-- Add Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js" defer></script>

<div class="container mt-5 mb-5">
    <h1>Commander une Chuck Energy 💥</h1>
    <h5><?php the_content(); ?></h5>

    <!-- Your existing order form remains unchanged -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["chuck_order"])) {
        // Your existing PHP processing logic here...
    }
    ?>

    <form method="post" class="mt-4">
        <input type="hidden" name="chuck_order" value="1">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="telephone">Téléphone</label>
                <input type="tel" id="telephone" name="telephone" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Sélectionnez vos boissons et quantités :</label>
                <div class="row">
                <?php
                $query = new WP_Query(['post_type' => 'drinks', 'posts_per_page' => -1]);
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $drink_name = get_the_title();
                        $drink_price = get_field('prix');
                        ?>
                        <div class="col-md-6 mb-2">
                            <label><?= esc_html($drink_name) ?> - <?= esc_html($drink_price) ?> €</label>
                            <input type="number" name="boisson[<?= esc_attr($drink_name) ?>]" 
                                   class="form-control drink-quantity" 
                                   data-price="<?= esc_attr($drink_price) ?>" 
                                   min="0" value="0">
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                } else {
                    echo '<p>Aucune boisson disponible.</p>';
                }
                ?>
                </div>
            </div>

            <div class="col-12 mb-3">
                <label for="message">Message (optionnel)</label>
                <textarea id="message" name="message" class="form-control" rows="4"></textarea>
            </div>

            <div class="col-12 mb-3">
                <p><strong>Total:</strong> <span id="total-price">0</span> €</p>
            </div>
        </div>
        <button type="submit" class="btn btn-danger mb-3">⚡ Commander</button>
    </form>

    <!-- 🗺️ Leaflet Map -->
    <div id="map" style="height: 300px; width: 100%; margin-top: 30px;"></div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // 🗺️ Initialize Leaflet Map
        var map = L.map('map').setView([51.505, -0.09], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        L.marker([51.5, -0.09]).addTo(map)
            .bindPopup('Notre emplacement Chuck Energy')
            .openPopup();

        // ✅ Fix Total Calculation
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.drink-quantity').forEach(input => {
                let price = parseFloat(input.getAttribute('data-price')) || 0;
                let quantity = parseInt(input.value) || 0;
                total += price * quantity;
            });
            document.getElementById('total-price').innerText = total.toFixed(2) + " €";
        }

        document.querySelectorAll('.drink-quantity').forEach(input => {
            input.addEventListener('input', calculateTotal);
        });
    });
    </script>

</div>
<?php get_footer(); ?>
