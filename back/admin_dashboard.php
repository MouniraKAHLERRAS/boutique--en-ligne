<?php
// admin_dashboard.php
//session_start();
//if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
  //  header('Location: index.php');
    //exit;
//}
session_start();

// Empêche l'ouverture directe du dashboard sans passer par le bouton
if (!isset($_GET['access']) || $_GET['access'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Gestion de la déconnexion
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../index.php');
    exit;
}

require_once '../config/config.php';
$pdo = Config::connect();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - MYNA FASHN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    * { 
        margin: 0; 
        padding: 0; 
        box-sizing: border-box; 
    }
    
    :root {
        /* Palette principale orange claire */
        --primary-orange: rgba(221, 136, 17, 1);       /* Orange principal */
        --primary-light: rgba(255, 224, 186, 1);       /* Orange très clair pastel */
        --primary-lighter: rgba(255, 240, 220, 1);     /* Fond crème orangé */
        
        /* Secondaires claires */
        --secondary-light: rgba(255, 245, 230, 1);     /* Beige clair */
        --secondary-cream: rgba(255, 250, 240, 1);     /* Crème doux */

        /* Accents lumineux */
        --accent-gold: rgba(255, 200, 80, 1);          /* Or clair lumineux */
        --accent-white: #ffffff;                       /* Blanc pur */
        --accent-cream: #fffdf7;                       /* Blanc cassé doux */

        /* Texte lisible sur fond clair */
        --text-dark: rgba(80, 60, 30, 1);              /* Brun doux (lisible mais pas noir dur) */
        --text-medium: rgba(120, 80, 40, 1);           /* Brun moyen */
        --text-light: rgba(180, 120, 60, 1);           /* Orange-brun doux */
        --text-white: #ffffff;                         /* Blanc pur */

        /* Fonds */
        --bg-main: linear-gradient(135deg, #fffdf7, #ffe8cc); /* Dégradé clair */
        --bg-card: rgba(255, 255, 255, 0.95);          /* Cartes blanches légèrement transparentes */
        --bg-glass: rgba(255, 255, 255, 0.4);          /* Fond translucide */
        --bg-glass-strong: rgba(255, 255, 255, 0.7);   /* Verre plus opaque */

        /* Ombres légères (pas foncées) */
        --shadow: 0 4px 20px rgba(221, 136, 17, 0.15);   /* Ombre douce orangée */
        --shadow-hover: 0 6px 25px rgba(221, 136, 17, 0.25);
        --shadow-light: 0 2px 10px rgba(221, 136, 17, 0.1);

        /* Bordures */
        --border-orange: rgba(221, 136, 17, 0.3);
        --border-light: rgba(255, 224, 186, 0.5);
        --border-white: rgba(255, 255, 255, 0.3);

        /* Styles */
        --border-radius: 20px;
        --border-radius-sm: 12px;
        --transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    body { 
        font-family: 'Poppins', 'Segoe UI', sans-serif; 
        background: var(--bg-main);
        color: var(--text-dark);
        line-height: 1.7;
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }
    
    /* Effet de texture subtile */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.2) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.2) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        pointer-events: none;
        z-index: -1;
    }
    
    /* Header élégant */
    .header { 
        background: var(--bg-glass);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--border-white);
        color: var(--text-dark); 
        padding: 1.5rem 3rem; 
        display: flex; 
        justify-content: space-between;
        align-items: center;
        box-shadow: var(--shadow-light);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    
    .header h2 {
        font-size: 2.2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 1rem;
        color: var(--text-dark);
    }
    
    .header h2 i {
        color: var(--primary-orange);
        font-size: 2.8rem;
        animation: glow 2s ease-in-out infinite alternate;
    }
    
    .header div {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        font-weight: 500;
        color: var(--text-dark);
    }
    
    .header a {
        color: var(--text-dark);
        text-decoration: none;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        background: var(--bg-glass);
        backdrop-filter: blur(10px);
        border: 1px solid var(--border-orange);
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
    }
    
    .header a:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
        border-color: var(--primary-orange);
    }
    
    .container { 
        display: flex; 
        min-height: calc(100vh - 80px);
        gap: 2rem;
        padding: 2rem;
    }
    
    /* Sidebar luxueux */
    .sidebar { 
        background: var(--bg-glass);
        backdrop-filter: blur(25px);
        border: 1px solid var(--border-white);
        color: var(--text-dark); 
        width: 340px; 
        padding: 2rem 0;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        height: fit-content;
        position: sticky;
        top: 100px;
    }
    
    .sidebar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--primary-orange), transparent);
    }
    
    .menu-item { 
        padding: 1.5rem 2.5rem; 
        cursor: pointer; 
        border-left: 4px solid transparent;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 1.2rem;
        font-weight: 600;
        font-size: 1.1rem;
        margin: 0.5rem 1rem;
        border-radius: var(--border-radius-sm);
        position: relative;
        overflow: hidden;
        color: var(--text-dark);
    }
    
    .menu-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: var(--transition);
    }
    
    .menu-item:hover::before {
        left: 100%;
    }
    
    .menu-item:hover { 
        background: var(--primary-light);
        border-left-color: var(--primary-orange);
        transform: translateX(10px);
        box-shadow: var(--shadow);
    }
    
    .menu-item.active { 
        background: linear-gradient(135deg, var(--primary-orange), var(--accent-gold));
        border-left-color: var(--accent-gold);
        color: var(--text-white);
        box-shadow: var(--shadow-hover);
    }
    
    .menu-item i {
        font-size: 1.4rem;
        width: 30px;
        text-align: center;
        color: var(--primary-orange);
    }
    
    .menu-item.active i {
        color: var(--text-white);
    }
    
    /* Contenu principal premium */
    .main { 
        flex: 1; 
        padding: 3rem; 
        background: var(--bg-card);
        border: 1px solid var(--border-light);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow-x: auto;
        position: relative;
    }
    
    .main::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--primary-orange), transparent);
    }
    
    .tab-content { 
        display: none; 
        animation: slideInUp 0.6s ease;
    }
    
    .tab-content.active { 
        display: block; 
    }
    
    @keyframes slideInUp {
        from { 
            opacity: 0; 
            transform: translateY(30px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
    
    @keyframes glow {
        from {
            filter: drop-shadow(0 0 5px rgba(221, 136, 17, 0.3));
        }
        to {
            filter: drop-shadow(0 0 15px rgba(221, 136, 17, 0.6));
        }
    }
    
    /* Titres élégants */
    h3 {
        font-size: 2.2rem;
        margin-bottom: 2.5rem;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 1rem;
        padding-bottom: 1.5rem;
        border-bottom: 3px solid var(--primary-orange);
    }
    
    h3 i {
        color: var(--primary-orange);
        font-size: 2.5rem;
    }
    
    /* Tables modernes */
    table { 
        width: 100%; 
        background: var(--bg-card);
        border-collapse: collapse;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-light);
    }
    
    th, td { 
        padding: 1.5rem; 
        border-bottom: 1px solid var(--border-light); 
        text-align: left; 
        color: var(--text-dark);
    }
    
    th { 
        background: var(--primary-light);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
        color: var(--text-dark);
    }
    
    tr {
        transition: var(--transition);
    }
    
    tr:hover {
        background: rgba(221, 136, 17, 0.05);
        transform: scale(1.01);
    }
    
    /* Boutons orange vibrants */
    .btn { 
        padding: 0.85rem 1.75rem; 
        border: none; 
        border-radius: 50px; 
        cursor: pointer; 
        margin: 0.2rem;
        font-weight: 700;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
    }
    
    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: var(--transition);
    }
    
    .btn:hover::before {
        left: 100%;
    }
    
    .btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }
    
    .btn-primary { 
        background: linear-gradient(135deg, var(--primary-orange), var(--accent-gold));
        color: var(--text-white); 
    }
    
    .btn-danger { 
        background: linear-gradient(135deg, #ff8a8a, #ff5252);
        color: var(--text-white); 
    }
    
    .btn-success { 
        background: linear-gradient(135deg, #6fcf97, #27ae60);
        color: var(--text-white); 
    }
    
    .btn-warning { 
        background: linear-gradient(135deg, #ffd166, #ff9e00);
        color: var(--text-dark); 
    }
    
    .btn-info {
        background: linear-gradient(135deg, #74c0fc, #339af0);
        color: var(--text-white);
    }
    
    /* Formulaires élégants */
    .form-group { 
        margin-bottom: 2rem; 
    }
    
    .form-group label { 
        display: block; 
        margin-bottom: 0.75rem; 
        font-weight: 700;
        color: var(--text-dark);
        font-size: 1.1rem;
    }
    
    .form-group input, 
    .form-group select, 
    .form-group textarea { 
        width: 100%; 
        padding: 1.2rem 1.5rem; 
        background: var(--bg-card);
        border: 2px solid var(--border-light);
        border-radius: var(--border-radius-sm);
        font-size: 1rem;
        transition: var(--transition);
        color: var(--text-dark);
        font-weight: 500;
    }
    
    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: rgba(80, 60, 30, 0.5);
    }
    
    .form-group input:focus, 
    .form-group select:focus, 
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary-orange);
        box-shadow: 0 0 0 3px rgba(221, 136, 17, 0.2);
        background: var(--bg-card);
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
    
    /* Status badges */
    .status-pending { 
        color: var(--primary-orange); 
        font-weight: 700;
        background: rgba(221, 136, 17, 0.15);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        display: inline-block;
        border: 1px solid rgba(221, 136, 17, 0.3);
    }
    
    .status-confirmed { 
        color: #27ae60; 
        font-weight: 700;
        background: rgba(39, 174, 96, 0.15);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        display: inline-block;
        border: 1px solid rgba(39, 174, 96, 0.3);
    }
    
    .status-shipped { 
        color: #339af0; 
        font-weight: 700;
        background: rgba(51, 154, 240, 0.15);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        display: inline-block;
        border: 1px solid rgba(51, 154, 240, 0.3);
    }
    
    .status-delivered { 
        color: #27ae60; 
        font-weight: 700;
        background: rgba(39, 174, 96, 0.15);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        display: inline-block;
        border: 1px solid rgba(39, 174, 96, 0.3);
    }
    
    .status-cancelled { 
        color: #ff5252; 
        font-weight: 700;
        background: rgba(255, 82, 82, 0.15);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        display: inline-block;
        border: 1px solid rgba(255, 82, 82, 0.3);
    }
    
    /* Alertes */
    .alert { 
        padding: 1.5rem 2rem; 
        margin-bottom: 2rem; 
        border-radius: var(--border-radius);
        border-left: 5px solid;
        animation: slideInLeft 0.5s ease;
        background: var(--bg-card);
        color: var(--text-dark);
        box-shadow: var(--shadow);
    }
    
    @keyframes slideInLeft {
        from { transform: translateX(-20px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    .alert-success { 
        border-left-color: #27ae60;
        background: rgba(39, 174, 96, 0.1);
    }
    
    .alert-error { 
        border-left-color: #ff5252;
        background: rgba(255, 82, 82, 0.1);
    }
    
    /* Modals */
    .modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        animation: fadeIn 0.4s ease;
    }
    
    .modal-content {
        background: var(--bg-card);
        margin: 5% auto;
        padding: 3rem;
        border-radius: var(--border-radius);
        width: 85%;
        max-width: 900px;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: var(--shadow-hover);
        animation: modalSlideIn 0.5s ease;
        color: var(--text-dark);
        border: 2px solid var(--primary-orange);
    }
    
    @keyframes modalSlideIn {
        from { transform: translateY(-50px) scale(0.9); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }
    
    .close {
        float: right;
        font-size: 2rem;
        cursor: pointer;
        color: var(--primary-orange);
        transition: var(--transition);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .close:hover {
        color: var(--text-dark);
        background: rgba(221, 136, 17, 0.1);
        transform: rotate(90deg);
    }
    
    /* Images produits */
    .product-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: var(--border-radius-sm);
        border: 2px solid var(--primary-orange);
        transition: var(--transition);
        box-shadow: var(--shadow-light);
    }
    
    .product-image:hover {
        transform: scale(1.2);
        border-color: var(--accent-gold);
    }
    
    /* Codes promo */
    .promo-active { 
        color: #27ae60; 
        font-weight: 700;
        background: rgba(39, 174, 96, 0.15);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        border: 1px solid rgba(39, 174, 96, 0.3);
    }
    
    .promo-inactive { 
        color: #ff5252; 
        font-weight: 700;
        background: rgba(255, 82, 82, 0.15);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        border: 1px solid rgba(255, 82, 82, 0.3);
    }
    
    .promo-highlight {
        background: rgba(221, 136, 17, 0.1) !important;
        border-left: 4px solid var(--primary-orange);
    }
    
    .promo-badge {
        background: linear-gradient(135deg, var(--primary-orange), var(--accent-gold));
        color: var(--text-white);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: var(--shadow);
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .container {
            flex-direction: column;
        }
        
        .sidebar {
            width: 100%;
            position: static;
        }
        
        .menu-item {
            display: inline-block;
            margin: 0.5rem;
            min-width: 220px;
        }
    }
    
    @media (max-width: 768px) {
        body {
            padding: 0.5rem;
        }
        
        .header {
            padding: 1rem;
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .container {
            padding: 1rem;
            gap: 1rem;
        }
        
        .main {
            padding: 2rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        table {
            display: block;
            overflow-x: auto;
        }
        
        .modal-content {
            margin: 10% auto;
            padding: 2rem;
            width: 95%;
        }
    }
    
    /* Scrollbar orange */
    ::-webkit-scrollbar {
        width: 12px;
    }
    
    ::-webkit-scrollbar-track {
        background: rgba(221, 136, 17, 0.1);
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, var(--primary-orange), var(--accent-gold));
        border-radius: 10px;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, var(--accent-gold), var(--primary-orange));
    }
</style>
</head>
<body>
    <div class="header">
        <h2><i class="fas fa-crown"></i> MYNA FASHN - Admin</h2>
        <div>
            <span>Bienvenue, Admin</span>
            <a href="?logout" style="color: black; margin-left: 1rem; text-decoration: none;">
                <i class="fas fa-sign-out-alt"></i> Acceuil
            </a>
        </div>
    </div>
    
    <div class="container">
        <div class="sidebar">
            <div class="menu-item active" onclick="showTab('products')">
                <i class="fas fa-box"></i> Gestion Produits
            </div>
            <div class="menu-item" onclick="showTab('orders')">
                <i class="fas fa-shopping-cart"></i> Commandes
            </div>
            <div class="menu-item" onclick="showTab('add-product')">
                <i class="fas fa-plus-circle"></i> Ajouter Produit
            </div>
            <div class="menu-item" onclick="showTab('promo-codes')">
                <i class="fas fa-tag"></i> Codes Promo
            </div>
        </div>
        
        <div class="main">
            <!-- Gestion des produits -->
            <div id="products" class="tab-content active">
                <h3><i class="fas fa-box"></i> Gestion des Produits</h3>
                <div id="productsMessage"></div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Prix</th>
                            <th>Catégorie</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
                            $products = $stmt->fetchAll();
                            
                            if (empty($products)) {
                                echo '<tr><td colspan="7" style="text-align: center;">Aucun produit trouvé</td></tr>';
                            } else {
                                foreach ($products as $product):
                                    $imagePath = normalizeImagePath($product['image']);
                                    $imageSrc = preg_match('#^(?:[a-z][a-z0-9+.-]*:|/)#i', $imagePath) ? $imagePath : '../' . $imagePath;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                            <td>
                                <?php if ($product['image']): ?>
                                    <img src="<?php echo htmlspecialchars($imageSrc); ?>" width="50" height="50" style="object-fit: cover;">
                                <?php else: ?>
                                    <i class="fas fa-image" style="font-size: 2rem; color: #ccc;"></i>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo number_format($product['price'], 0, ',', ' '); ?> DA</td>
                            <td><?php echo htmlspecialchars($product['category']); ?></td>
                            <td><?php echo htmlspecialchars($product['stock']); ?></td>
                            <td>
                                <button class="btn btn-primary" onclick="editProduct(<?php echo $product['id']; ?>)">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                                <button class="btn btn-danger" onclick="deleteProduct(<?php echo $product['id']; ?>)">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </td>
                        </tr>
                        <?php 
                                endforeach;
                            }
                        } catch(PDOException $e) {
                            echo '<tr><td colspan="7" style="text-align: center; color: red;">Erreur: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
                        <!-- Commandes -->
<div id="orders" class="tab-content">
    <h3><i class="fas fa-shopping-cart"></i> Commandes</h3>
    <div id="ordersMessage"></div>
    <table>
        <thead>
            <tr>
                <th>N° Commande</th>
                <th>Client</th>
                <th>Téléphone</th>
                <th>Sous-total</th>
                <th>Réduction</th>
                <th>Livraison</th>
                <th>Total</th>
                <th>Code Promo</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
                $orders = $stmt->fetchAll();
                
                if (empty($orders)) {
                    echo '<tr><td colspan="11" style="text-align: center;">Aucune commande trouvée</td></tr>';
                } else {
                    foreach ($orders as $order):
                        $statusClass = 'status-' . $order['status'];
                        $hasPromo = !empty($order['promo_code']);
            ?>
            <tr style="<?php echo $hasPromo ? 'background-color: #f0fff0;' : ''; ?>">
                <td>
                    <?php echo htmlspecialchars($order['order_number']); ?>
                    <?php if ($hasPromo): ?>
                        <i class="fas fa-tag" style="color: #28a745; margin-left: 5px;" title="Commande avec code promo"></i>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($order['customer_phone']); ?></td>
                <td><?php echo number_format($order['subtotal_amount'], 0, ',', ' '); ?> DA</td>
                <td style="color: #dc3545; font-weight: bold;">
                    <?php if ($order['discount_amount'] > 0): ?>
                        -<?php echo number_format($order['discount_amount'], 0, ',', ' '); ?> DA
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?php echo number_format($order['shipping_amount'], 0, ',', ' '); ?> DA</td>
                <td style="font-weight: bold;"><?php echo number_format($order['total_amount'], 0, ',', ' '); ?> DA</td>
                <td>
                    <?php if ($hasPromo): ?>
                        <span style="background: #28a745; color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.8rem; font-weight: bold;">
                            <i class="fas fa-tag"></i> <?php echo htmlspecialchars($order['promo_code']); ?>
                        </span>
                    <?php else: ?>
                        <span style="color: #6c757d;">-</span>
                    <?php endif; ?>
                </td>
                <td>
                    <select onchange="updateOrderStatus(<?php echo $order['id']; ?>, this.value)" class="<?php echo $statusClass; ?>">
                        <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>En attente</option>
                        <option value="confirmed" <?php echo $order['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmée</option>
                        <option value="shipped" <?php echo $order['status'] == 'shipped' ? 'selected' : ''; ?>>Expédiée</option>
                        <option value="delivered" <?php echo $order['status'] == 'delivered' ? 'selected' : ''; ?>>Livrée</option>
                        <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Annulée</option>
                    </select>
                </td>
                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                <td>
                    <button class="btn btn-primary" onclick="viewOrder(<?php echo $order['id']; ?>)">
                        <i class="fas fa-eye"></i> Détails
                    </button>
                </td>
            </tr>
            <?php 
                    endforeach;
                }
            } catch(PDOException $e) {
                echo '<tr><td colspan="11" style="text-align: center; color: red;">Erreur: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>
            
            <!-- Ajouter produit -->
            <div id="add-product" class="tab-content">
                <h3><i class="fas fa-plus-circle"></i> Ajouter un Produit</h3>
                <div id="formMessage"></div>
                <form id="productForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nom du produit:</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <textarea name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Prix (DA):</label>
                        <input type="number" name="price" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Ancien prix (DA):</label>
                        <input type="number" name="original_price" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Catégorie:</label>
                        <select name="category" required>
                            <option value="">Sélectionnez une catégorie</option>
                            <option value="jupes">Jupes</option>
                            <option value="robes">Robes</option>
                            <option value="foulards">Foulards</option>
                            <option value="ensembles">Ensembles</option>
                            <option value="hijabs">Hijabs</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Image:</label>
                        <input type="file" name="image" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label>Tailles (séparées par des virgules):</label>
                        <input type="text" name="sizes" placeholder="XS, S, M, L, XL" required>
                    </div>
                    <div class="form-group">
                        <label>Couleurs (séparées par des virgules):</label>
                        <input type="text" name="colors" placeholder="Rouge, Bleu, Vert, Noir" required>
                    </div>
                    <div class="form-group">
                        <label>Stock:</label>
                        <input type="number" name="stock" required>
                    </div>
                    <button type="submit" class="btn btn-success" style="padding: 0.75rem; font-size: 1.1rem;">
                        <i class="fas fa-save"></i> Ajouter le produit
                    </button>
                </form>
            </div>

            <!-- Gestion des codes promo -->
            <div id="promo-codes" class="tab-content">
                <h3><i class="fas fa-tag"></i> Gestion des Codes Promo</h3>
                <button class="btn btn-success" onclick="showAddPromoModal()" style="margin-bottom: 1rem;">
                    <i class="fas fa-plus"></i> Ajouter un code promo
                </button>
                <div id="promoMessage"></div>
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Valeur</th>
                            <th>Montant Min</th>
                            <th>Utilisations</th>
                            <th>Date Début</th>
                            <th>Date Fin</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="promoCodesTable">
                        <!-- Les codes promo seront chargés dynamiquement ici -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de modification de produit -->
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h3><i class="fas fa-edit"></i> Modifier le Produit</h3>
            <div id="editMessage"></div>
            <form id="editProductForm" enctype="multipart/form-data">
                <input type="hidden" id="editProductId" name="id">
                
                <div class="form-group">
                    <label>Nom du produit:</label>
                    <input type="text" id="editName" name="name" required>
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea id="editDescription" name="description" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Prix (DA):</label>
                    <input type="number" id="editPrice" name="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Ancien prix (DA):</label>
                    <input type="number" id="editOriginalPrice" name="original_price" step="0.01">
                </div>
                <div class="form-group">
                    <label>Catégorie:</label>
                    <select id="editCategory" name="category" required>
                        <option value="">Sélectionnez une catégorie</option>
                        <option value="jupes">Jupes</option>
                        <option value="robes">Robes</option>
                        <option value="foulards">Foulards</option>
                        <option value="ensembles">Ensembles</option>
                        <option value="hijabs">Hijabs</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Image actuelle:</label>
                    <div id="currentImage" style="margin: 10px 0;"></div>
                    <label>Nouvelle image (laisser vide pour conserver l'actuelle):</label>
                    <input type="file" id="editImage" name="image" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Tailles (séparées par des virgules):</label>
                    <input type="text" id="editSizes" name="sizes" placeholder="XS, S, M, L, XL" required>
                </div>
                <div class="form-group">
                    <label>Couleurs (séparées par des virgules):</label>
                    <input type="text" id="editColors" name="colors" placeholder="Rouge, Bleu, Vert, Noir" required>
                </div>
                <div class="form-group">
                    <label>Stock:</label>
                    <input type="number" id="editStock" name="stock" required>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <button type="button" class="btn btn-danger" onclick="closeEditModal()">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal d'ajout/modification de code promo -->
    <div id="promoModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closePromoModal()">&times;</span>
            <h3 id="promoModalTitle"><i class="fas fa-tag"></i> Ajouter un Code Promo</h3>
            <div id="promoFormMessage"></div>
            <form id="promoForm">
                <input type="hidden" id="promoId" name="id">
                
                <div class="form-group">
                    <label>Code *:</label>
                    <input type="text" id="promoCode" name="code" required maxlength="50">
                </div>
                
                <div class="form-group">
                    <label>Description:</label>
                    <textarea id="promoDescription" name="description" rows="3"></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Type de réduction *:</label>
                        <select id="promoDiscountType" name="discount_type" required>
                            <option value="percentage">Pourcentage</option>
                            <option value="fixed">Montant fixe</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Valeur de réduction *:</label>
                        <input type="number" id="promoDiscountValue" name="discount_value" step="0.01" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Montant minimum de commande:</label>
                        <input type="number" id="promoMinAmount" name="min_order_amount" step="0.01" value="0">
                    </div>
                    
                    <div class="form-group">
                        <label>Montant max de réduction (pour %):</label>
                        <input type="number" id="promoMaxDiscount" name="max_discount_amount" step="0.01">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Limite d'utilisation:</label>
                        <input type="number" id="promoUsageLimit" name="usage_limit" placeholder="Illimité si vide">
                    </div>
                    
                    <div class="form-group">
                        <label>Statut:</label>
                        <select id="promoIsActive" name="is_active">
                            <option value="1">Actif</option>
                            <option value="0">Inactif</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Date de début:</label>
                        <input type="datetime-local" id="promoStartDate" name="start_date">
                    </div>
                    
                    <div class="form-group">
                        <label>Date de fin:</label>
                        <input type="datetime-local" id="promoEndDate" name="end_date">
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <button type="button" class="btn btn-danger" onclick="closePromoModal()">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentEditingProductId = null;

        function getAdminImageUrl(imagePath) {
            if (imagePath && !/^(?:[a-z][a-z0-9+.-]*:|\/)/i.test(imagePath)) {
                return `../${imagePath}`;
            }
            return imagePath;
        }

        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('active');
            });
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');

            // Charger les codes promo si l'onglet est sélectionné
            if (tabName === 'promo-codes') {
                loadPromoCodes();
            }
        }

        // Gestion du formulaire d'ajout de produit
        document.getElementById('productForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('api.php?action=add_product', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('formMessage', data.message, 'success');
                    this.reset();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showMessage('formMessage', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showMessage('formMessage', 'Erreur: ' + error.message, 'error');
            });
        });

        function deleteProduct(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce produit?')) {
                fetch(`api.php?action=delete_product&id=${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage('productsMessage', data.message, 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showMessage('productsMessage', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showMessage('productsMessage', 'Erreur: ' + error.message, 'error');
                });
            }
        }

        function updateOrderStatus(orderId, status) {
            fetch(`api.php?action=update_order_status&id=${orderId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('ordersMessage', 'Statut mis à jour avec succès', 'success');
                } else {
                    showMessage('ordersMessage', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showMessage('ordersMessage', 'Erreur: ' + error.message, 'error');
            });
        }

        function viewOrder(orderId) {
            window.open(`order_details.php?id=${orderId}`, '_blank');
        }

        function editProduct(productId) {
            currentEditingProductId = productId;
            
            fetch(`api.php?action=get_product&id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const product = data.data;
                    
                    // Remplir le formulaire
                    document.getElementById('editProductId').value = product.id;
                    document.getElementById('editName').value = product.name;
                    document.getElementById('editDescription').value = product.description;
                    document.getElementById('editPrice').value = product.price;
                    document.getElementById('editOriginalPrice').value = product.original_price || '';
                    document.getElementById('editCategory').value = product.category;
                    document.getElementById('editStock').value = product.stock;
                    
                    // Convertir les tableaux en chaînes
                    document.getElementById('editSizes').value = Array.isArray(product.sizes) ? 
                        product.sizes.join(', ') : (product.sizes || '');
                    document.getElementById('editColors').value = Array.isArray(product.colors) ? 
                        product.colors.join(', ') : (product.colors || '');
                    
                    // Afficher l'image actuelle
                    const currentImageDiv = document.getElementById('currentImage');
                    if (product.image) {
                        currentImageDiv.innerHTML = `
                            <img src="${getAdminImageUrl(product.image)}" width="100" height="100" style="object-fit: cover; border: 1px solid #ddd;">
                            <div><small>Image actuelle</small></div>
                        `;
                    } else {
                        currentImageDiv.innerHTML = '<em>Aucune image</em>';
                    }
                    
                    document.getElementById('editProductModal').style.display = 'block';
                } else {
                    showMessage('productsMessage', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showMessage('productsMessage', 'Erreur: ' + error.message, 'error');
            });
        }

        function closeEditModal() {
            document.getElementById('editProductModal').style.display = 'none';
            currentEditingProductId = null;
            document.getElementById('editProductForm').reset();
            document.getElementById('editMessage').innerHTML = '';
        }

        // FORMULAIRE DE MODIFICATION CORRIGÉ
        document.getElementById('editProductForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!currentEditingProductId) {
                showMessage('editMessage', 'Erreur: ID produit manquant', 'error');
                return;
            }
            
            const formData = new FormData(this);
            
            fetch(`api.php?action=update_product&id=${currentEditingProductId}`, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    showMessage('editMessage', data.message, 'success');
                    setTimeout(() => {
                        closeEditModal();
                        location.reload();
                    }, 1500);
                } else {
                    showMessage('editMessage', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erreur complète:', error);
                showMessage('editMessage', 'Erreur: ' + error.message, 'error');
            });
        });

        // Gestion des codes promo
        function loadPromoCodes() {
            fetch('api.php?action=get_promo_codes')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayPromoCodes(data.data);
                    } else {
                        showMessage('promoMessage', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showMessage('promoMessage', 'Erreur de chargement des codes promo', 'error');
                });
        }

        function displayPromoCodes(codes) {
            const table = document.getElementById('promoCodesTable');
            
            if (codes.length === 0) {
                table.innerHTML = '<tr><td colspan="10" style="text-align: center;">Aucun code promo trouvé</td></tr>';
                return;
            }
            
            table.innerHTML = codes.map(code => `
                <tr>
                    <td><strong>${code.code}</strong></td>
                    <td>${code.description || '-'}</td>
                    <td>${code.discount_type === 'percentage' ? 'Pourcentage' : 'Montant fixe'}</td>
                    <td>
                        ${code.discount_type === 'percentage' ? 
                          `${code.discount_value}%` : 
                          `${formatPrice(code.discount_value)}`}
                    </td>
                    <td>${code.min_order_amount > 0 ? formatPrice(code.min_order_amount) : 'Aucun'}</td>
                    <td>${code.used_count} / ${code.usage_limit || '∞'}</td>
                    <td>${code.start_date ? formatDate(code.start_date) : '-'}</td>
                    <td>${code.end_date ? formatDate(code.end_date) : '-'}</td>
                    <td>
                        <span class="${code.is_active ? 'promo-active' : 'promo-inactive'}">
                            ${code.is_active ? 'Actif' : 'Inactif'}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-primary" onclick="editPromoCode(${code.id})">
                            <i class="fas fa-edit"></i> Modifier
                        </button>
                        <button class="btn btn-danger" onclick="deletePromoCode(${code.id})">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        function showAddPromoModal() {
            document.getElementById('promoModalTitle').textContent = 'Ajouter un Code Promo';
            document.getElementById('promoForm').reset();
            document.getElementById('promoId').value = '';
            document.getElementById('promoFormMessage').innerHTML = '';
            document.getElementById('promoModal').style.display = 'block';
        }

        function closePromoModal() {
            document.getElementById('promoModal').style.display = 'none';
        }

        function editPromoCode(id) {
            fetch(`api.php?action=get_promo_code&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const code = data.data;
                        document.getElementById('promoModalTitle').textContent = 'Modifier le Code Promo';
                        document.getElementById('promoId').value = code.id;
                        document.getElementById('promoCode').value = code.code;
                        document.getElementById('promoDescription').value = code.description || '';
                        document.getElementById('promoDiscountType').value = code.discount_type;
                        document.getElementById('promoDiscountValue').value = code.discount_value;
                        document.getElementById('promoMinAmount').value = code.min_order_amount || 0;
                        document.getElementById('promoMaxDiscount').value = code.max_discount_amount || '';
                        document.getElementById('promoUsageLimit').value = code.usage_limit || '';
                        document.getElementById('promoIsActive').value = code.is_active ? '1' : '0';
                        document.getElementById('promoStartDate').value = code.start_date ? formatDateForInput(code.start_date) : '';
                        document.getElementById('promoEndDate').value = code.end_date ? formatDateForInput(code.end_date) : '';
                        
                        document.getElementById('promoModal').style.display = 'block';
                    } else {
                        showMessage('promoMessage', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showMessage('promoMessage', 'Erreur de chargement du code promo', 'error');
                });
        }

        function deletePromoCode(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce code promo?')) {
                fetch(`api.php?action=delete_promo_code&id=${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage('promoMessage', data.message, 'success');
                        loadPromoCodes();
                    } else {
                        showMessage('promoMessage', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showMessage('promoMessage', 'Erreur de suppression', 'error');
                });
            }
        }

        // Gestion du formulaire de code promo
        document.getElementById('promoForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Convertir les valeurs numériques
            data.discount_value = parseFloat(data.discount_value);
            data.min_order_amount = parseFloat(data.min_order_amount);
            data.max_discount_amount = data.max_discount_amount ? parseFloat(data.max_discount_amount) : null;
            data.usage_limit = data.usage_limit ? parseInt(data.usage_limit) : null;
            data.is_active = data.is_active === '1';
            
            const action = data.id ? 'update_promo_code' : 'add_promo_code';
            const url = data.id ? `api.php?action=update_promo_code&id=${data.id}` : 'api.php?action=add_promo_code';
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showMessage('promoFormMessage', result.message, 'success');
                    setTimeout(() => {
                        closePromoModal();
                        loadPromoCodes();
                    }, 1500);
                } else {
                    showMessage('promoFormMessage', result.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showMessage('promoFormMessage', 'Erreur lors de l\'enregistrement', 'error');
            });
        });

        // Fonctions utilitaires
        function formatPrice(price) {
            return new Intl.NumberFormat('fr-DZ', {
                style: 'currency',
                currency: 'DZD',
                minimumFractionDigits: 0
            }).format(price);
        }

        function formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('fr-FR');
        }

        function formatDateForInput(dateString) {
            const date = new Date(dateString);
            return date.toISOString().slice(0, 16);
        }

        function showMessage(elementId, message, type) {
            const element = document.getElementById(elementId);
            element.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
            setTimeout(() => {
                element.innerHTML = '';
            }, 5000);
        }

        // Fermer les modals en cliquant en dehors
        window.onclick = function(event) {
            const modal = document.getElementById('editProductModal');
            if (event.target === modal) {
                closeEditModal();
            }
            
            const promoModal = document.getElementById('promoModal');
            if (event.target === promoModal) {
                closePromoModal();
            }
        }
    </script>
</body>
</html>