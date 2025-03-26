<script src="https://unpkg.com/leaflet/dist/leaflet.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('map').setView([48.8566, 2.3522], 12);
            L.tileLayer('https://{s}.tile.openstreetmap.org/%7Bz%7D/%7Bx%7D/%7By%7D.png', {
                attribution: '© OpenStreetMap contributors',
            }).addTo(map);
            L.marker([48.8566, 2.3522]).addTo(map)
                .bindPopup('Votre point Click & Collect')
                .openPopup();
        });