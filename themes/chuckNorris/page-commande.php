<?php
/* Template Name: Formulaire de commande Chuck */
get_header();
?>
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
        $message = isset($_POST["message"]) ? sanitize_textarea_field($_POST["message"]) : '';
        $promo_code = isset($_POST["promo_code"]) ? sanitize_text_field($_POST["promo_code"]) : "";

        // Define valid promo codes
        $valid_promo_codes = ["CHUCK10" => 10, "FREETRY" => 5];
        $discount = $valid_promo_codes[$promo_code] ?? 0;

        // Server-side calculation of total price
        $order_details = "";
        $total_price = 0;
        if (is_array($boissons)) {
            foreach ($boissons as $boisson_slug => $quantite) {
                $quantite = intval($quantite);
                // Code de calcul ici


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
        }

        // Apply discount
        $discount_amount = ($discount < 100) ? ($total_price * $discount / 100) : min($discount, $total_price);
        $total_price -= $discount_amount;

        // Email to Admin
        $to = get_option('admin_email');
        $subject = "Nouvelle commande Chuck Energy";
        $body = "Nouvelle commande :\n\n"
            . "Nom : $prenom $nom\n"
            . "Email : $email\n"
            . "Téléphone : $telephone\n"
            . "Boissons :\n$order_details\n"
            . "Code Promo : " . ($promo_code ? "$promo_code (-$discount_amount €)" : "Aucun") . "\n"
            . "Total : $total_price €\n"
            . "Message : $message";

        $headers = [
            "From: " . get_option('blogname') . " <" . get_option('admin_email') . ">",
            "Reply-To: $prenom $nom <$email>",
            "Content-Type: text/plain; charset=UTF-8"
        ];


        if (wp_mail($to, $subject, $body, $headers)) {
            echo '<div class="alert alert-success">💪 Votre commande a été envoyée ! </div>';
        } else {
            echo '<div class="alert alert-danger">😞 Une erreur est survenue lors de l\'envoi de la commande.</div>';
        }
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
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="telephone">Téléphone</label>
                <input type="tel" id="telephone" name="telephone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Sélectionnez vos boissons :</label>
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
                                <input type="number" name="boisson[<?= esc_attr($post->post_name) ?>]" class="form-control drink-quantity" data-price="<?= esc_attr($drink_price) ?>" min="0" value="0">
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

            <div class="col-md-6 mb-3">
                <label for="promo_code">Code Promo</label>
                <input type="text" id="promo_code" name="promo_code" class="form-control">
            </div>

            <div class="col-12 mb-3">
                <p><strong>Total HT:</strong> <span id="total-price">0.00</span> €</p>
                <p><strong>TVA (20%):</strong> <span id="tva-amount">0.00</span> €</p>
                <p><strong>Total TTC:</strong> <span id="total-ttc">0.00</span> €</p>
            </div>
        </div>
        <button type="submit" class="btn btn-danger mb-3">⚡ Commander</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function calculateTotal() {
                let totalHT = 0;
                document.querySelectorAll('.drink-quantity').forEach(input => {
                    let price = parseFloat(input.getAttribute('data-price')) || 0;
                    let quantity = parseInt(input.value) || 0;
                    totalHT += price * quantity;
                });

                let promoCode = document.getElementById("promo_code").value.trim();
                let validPromoCodes = {
                    "CHUCK10": 0.1,
                    "FREETRY": 5
                };
                let discount = validPromoCodes[promoCode] ? (validPromoCodes[promoCode] <= 1 ? totalHT * validPromoCodes[promoCode] : totalHT * validPromoCodes[promoCode] / 100) : 0;

                totalHT = Math.max(totalHT - discount, 0);

                let tva = totalHT * 0.20;
                let totalTTC = totalHT + tva;

                document.getElementById('total-price').innerText = totalHT.toFixed(2) + " € HT";
                document.getElementById('tva-amount').innerText = tva.toFixed(2) + " € TVA";
                document.getElementById('total-ttc').innerText = totalTTC.toFixed(2) + " € TTC";
            }

            document.querySelectorAll('.drink-quantity').forEach(input => input.addEventListener('input', calculateTotal));
            document.getElementById("promo_code").addEventListener("input", calculateTotal);
        });
    </script>
</div>

<?php get_footer(); ?>