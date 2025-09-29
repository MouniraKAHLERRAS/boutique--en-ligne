<?php
// boutique_accueil.php
// Page d'accueil d'une boutique en ligne simple (PHP + HTML + CSS + JS)
// Fichier unique autonome pour démonstration. Placez-le dans votre dossier www (XAMPP / WAMP / LAMP) et ouvrez-le via http://localhost/boutique_accueil.php

// Exemple de "produits" simulés (en vrai: récupérez depuis une base de données)
$products = [
    ["id" => 1, "name" => "Robe d'été", "price" => 29.99, "image" => "https://via.placeholder.com/400x300?text=Robe"],
    ["id" => 2, "name" => "Sneakers", "price" => 59.50, "image" => "https://via.placeholder.com/400x300?text=Sneakers"],
    ["id" => 3, "name" => "Sac à main", "price" => 79.00, "image" => "https://via.placeholder.com/400x300?text=Sac"],
    ["id" => 4, "name" => "Montre élégante", "price" => 120.00, "image" => "https://via.placeholder.com/400x300?text=Montre"],
    ["id" => 5, "name" => "Lunettes de soleil", "price" => 19.99, "image" => "https://via.placeholder.com/400x300?text=Lunettes"],
    ["id" => 6, "name" => "Jean slim", "price" => 45.00, "image" => "https://via.placeholder.com/400x300?text=Jean"],
];

// Simple gestion de session pour panier (stocké côté serveur)
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Ajout au panier via POST (fetch côté client en JS)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $id = intval($_POST['id']);
    foreach ($products as $p) {
        if ($p['id'] === $id) {
            // si déjà présent, incrémente la quantité
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['qty'] += 1;
            } else {
                $_SESSION['cart'][$id] = ['id' => $id, 'name' => $p['name'], 'price' => $p['price'], 'qty' => 1];
            }
            break;
        }
    }
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ok', 'cart_count' => array_sum(array_column($_SESSION['cart'], 'qty'))]);
    exit;
}

// Endpoint pour vider le panier (exemple)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'clear_cart') {
    $_SESSION['cart'] = [];
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ok']);
    exit;
}

$cart_count = array_sum(array_column($_SESSION['cart'], 'qty')) ?: 0;
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boutique - Accueil</title>
    <style>
        /* RESET simple */
        *{box-sizing:border-box;margin:0;padding:0;font-family:Inter, Arial, sans-serif}
        body{background:#f7f7fb;color:#222}
        a{color:inherit;text-decoration:none}

        /* Header */
        .header{background:#fff;padding:18px 24px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 2px 6px rgba(10,10,10,0.05);position:sticky;top:0;z-index:10}
        .logo{font-weight:800;font-size:20px;color:#1d4ed8}
        nav ul{display:flex;gap:16px;list-style:none}
        nav a{padding:8px 12px;border-radius:8px}
        nav a:hover{background:rgba(29,78,216,0.06)}

        /* Hero */
        .hero{display:flex;gap:24px;align-items:center;padding:40px 24px;max-width:1200px;margin:20px auto}
        .hero-text{flex:1}
        .hero h1{font-size:32px;margin-bottom:12px}
        .hero p{color:#555;margin-bottom:16px}
        .cta{display:inline-block;padding:12px 18px;border-radius:10px;background:#1d4ed8;color:#fff}
        .hero-img{flex-basis:420px}
        .hero-img img{width:100%;border-radius:12px;box-shadow:0 8px 24px rgba(13,38,76,0.08)}

        /* Product grid */
        .container{max-width:1200px;margin:0 auto;padding:0 24px}
        .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:18px;margin-top:20px}
        .card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 6px 18px rgba(10,10,10,0.04);display:flex;flex-direction:column}
        .card img{width:100%;height:160px;object-fit:cover}
        .card-body{padding:12px;flex:1;display:flex;flex-direction:column}
        .card h3{font-size:16px;margin-bottom:8px}
        .price{margin-top:auto;font-weight:700}
        .actions{display:flex;gap:8px;margin-top:10px}
        .btn{padding:8px 10px;border-radius:8px;border:none;cursor:pointer}
        .btn-primary{background:#1d4ed8;color:white}
        .btn-outline{background:transparent;border:1px solid #ddd}

        /* Cart icon */
        .cart{position:relative;display:flex;align-items:center;gap:8px}
        .cart-bubble{position:absolute;top:-6px;right:-6px;background:#ef4444;color:#fff;border-radius:999px;padding:4px 7px;font-size:12px}

        /* Footer */
        footer{padding:24px;text-align:center;color:#666}

        /* Responsive */
        @media (max-width:800px){
            .hero{flex-direction:column}
            .hero-img{order:-1}
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">MaBoutique</div>
        <nav>
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Produits</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
        <div class="cart" id="cartBtn">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" stroke="#111" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="10" cy="20" r="1" fill="#111"/>
                <circle cx="18" cy="20" r="1" fill="#111"/>
            </svg>
            <div>Panier</div>
            <div class="cart-bubble" id="cartCount"><?php echo $cart_count; ?></div>
        </div>
    </header>

    <section class="hero">
        <div class="hero-text">
            <h1>Bienvenue sur MaBoutique</h1>
            <p>Découvrez notre sélection de vêtements, accessoires et plus. Livraison rapide et retours faciles.</p>
            <a href="#products" class="cta">Voir les produits</a>
        </div>
        <div class="hero-img">
            <img src="https://via.placeholder.com/820x520?text=Promotions" alt="Promotions">
        </div>
    </section>

    <main class="container">
        <h2 id="products">Nos produits populaires</h2>
        <div class="grid">
            <?php foreach ($products as $p): ?>
            <div class="card">
                <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
                <div class="card-body">
                    <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                    <div class="price"><?php echo number_format($p['price'], 2, ',', ' '); ?> €</div>
                    <div class="actions">
                        <button class="btn btn-primary add-to-cart" data-id="<?php echo $p['id']; ?>">Ajouter</button>
                        <a class="btn btn-outline" href="#">Voir</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        &copy; <?php echo date('Y'); ?> MaBoutique. Tous droits réservés.
    </footer>

    <script>
        // JS: gestion ajout au panier (fetch vers le même fichier)
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                const id = btn.dataset.id;
                btn.disabled = true;
                btn.textContent = 'Ajout...';
                try {
                    const form = new FormData();
                    form.append('action', 'add');
                    form.append('id', id);
                    const resp = await fetch(location.href, {method: 'POST', body: form});
                    const data = await resp.json();
                    if (data.status === 'ok') {
                        document.getElementById('cartCount').textContent = data.cart_count;
                        btn.textContent = 'Ajouté ✓';
                        setTimeout(()=>{ btn.textContent = 'Ajouter'; btn.disabled = false; }, 900);
                    } else {
                        btn.textContent = 'Erreur';
                        btn.disabled = false;
                    }
                } catch (err) {
                    console.error(err);
                    btn.textContent = 'Erreur';
                    btn.disabled = false;
                }
            });
        });

        // Afficher un aperçu du panier en cliquant sur l'icône (exemple simple)
        document.getElementById('cartBtn').addEventListener('click', async () => {
            // Récupère le panier côté serveur via fetch GET (ici on construira un mini aperçu en PHP côté session)
            // Pour garder tout simple: ouvre une petite fenêtre avec le contenu du panier actuel (basé sur session)
            const w = window.open('', 'Panier', 'width=500,height=600');
            w.document.title = 'Votre panier';
            w.document.body.style.fontFamily = 'Inter, Arial, sans-serif';
            w.document.body.innerHTML = '<h2 style="padding:16px">Votre panier</h2><div id="content" style="padding:16px">Chargement...</div>';
            // Nous allons demander via fetch un fragment HTML retourné par PHP (simplifié)
            try {
                const resp = await fetch(location.href + '?_cart_preview=1');
                const html = await resp.text();
                w.document.getElementById('content').innerHTML = html;
            } catch (e) {
                w.document.getElementById('content').textContent = 'Impossible de charger le panier.';
            }
        });
    </script>

<?php
// Si on reçoit une requête GET avec _cart_preview, on renvoie un fragment HTML du panier (appelé par la popup JS)
if (isset($_GET['_cart_preview'])) {
    if (empty($_SESSION['cart'])) {
        echo '<p>Votre panier est vide.</p>';
    } else {
        echo '<ul style="list-style:none;padding:0;">';
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $sub = $item['price'] * $item['qty'];
            $total += $sub;
            echo '<li style="padding:8px 0;border-bottom:1px solid #eee">'.htmlspecialchars($item['name']).' × '.intval($item['qty']).'<div style="float:right">'.number_format($sub,2,',',' ').' €</div></li>';
        }
        echo '</ul>';
        echo '<p style="margin-top:12px;font-weight:700">Total: '.number_format($total,2,',',' ').' €</p>';
        echo '<div style="margin-top:12px"><form method="POST"><input type="hidden" name="action" value="clear_cart"><button type="submit" style="padding:8px 12px;border-radius:8px;border:none;background:#ef4444;color:#fff">Vider le panier</button></form></div>';
    }
    exit;
}
?>