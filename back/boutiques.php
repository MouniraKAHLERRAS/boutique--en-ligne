<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutiques - MYNA FASHN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Réutiliser les mêmes variables CSS que accueil.php */
        :root {
            --primary-color: #8b4513;
            --secondary-color: #daa520;
            --accent-color: #cd853f;
            --gold-color: #daa520;
            --dark-color: #2c1810;
            --light-color: #faf0e6;
            --white: #ffffff;
            --gray-light: #f8f9fa;
            --shadow: 0 10px 30px rgba(0,0,0,0.1);
            --shadow-hover: 0 20px 40px rgba(0,0,0,0.15);
            --transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: var(--white);
            color: var(--dark-color);
            overflow-x: hidden;
        }

        /* Header identique à accueil.php */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 1.5rem 3rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            border-bottom: 1px solid rgba(139, 69, 19, 0.1);
            transition: var(--transition);
        }

        .header.scrolled {
            padding: 1rem 3rem;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: var(--shadow);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2.5rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            font-size: 1.1rem;
            position: relative;
            padding: 0.5rem 0;
            transition: var(--transition);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            transition: var(--transition);
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
            padding: 0.75rem;
            border-radius: 50%;
            background: var(--light-color);
            transition: var(--transition);
        }

        .cart-icon:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-2px);
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--secondary-color);
            color: var(--white);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Pages de boutique */
        .shop-page {
            padding-top: 120px;
            min-height: 100vh;
            background: var(--light-color);
        }

        .shop-header {
            text-align: center;
            padding: 4rem 2rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            margin-bottom: 2rem;
            position: relative;
        }

        .shop-page-title {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            color: white;
        }

        .shop-page-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .back-to-home {
            position: absolute;
            top: 2rem;
            left: 2rem;
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-to-home:hover {
            background: rgba(255,255,255,0.3);
            transform: translateX(-5px);
        }

        /* Section produits */
        .section {
            padding: 4rem 2rem;
            position: relative;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2.5rem;
            max-width: 1300px;
            margin: 0 auto;
        }

        .product-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .product-image {
            position: relative;
            height: 350px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--secondary-color);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .product-description {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .current-price {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .original-price {
            font-size: 1.1rem;
            color: #999;
            text-decoration: line-through;
        }

        .product-variants {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .variant-select {
            padding: 0.5rem 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.9rem;
            background: var(--white);
            transition: var(--transition);
        }

        .variant-select:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .product-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
            box-shadow: 0 10px 30px rgba(139, 69, 19, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(139, 69, 19, 0.4);
        }

        .btn-sm {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            border-radius: 8px;
        }

        /* Footer identique */
        .footer {
            background: var(--dark-color);
            color: var(--white);
            padding: 4rem 2rem 1rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }

        .footer-section h3 {
            margin-bottom: 1.5rem;
            color: var(--gold-color);
            font-size: 1.3rem;
        }

        .footer-section p {
            color: #ccc;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            display: block;
            margin-bottom: 0.75rem;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--gold-color);
            transform: translateX(5px);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            color: var(--white);
            text-decoration: none;
            transition: var(--transition);
        }

        .social-links a:hover {
            background: var(--gold-color);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #999;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.8s ease both;
        }

        /* Modal Panier (identique à accueil.php) */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: var(--white);
            border-radius: 20px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 2rem;
            position: relative;
            box-shadow: var(--shadow-hover);
        }

        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--dark-color);
            transition: var(--transition);
        }

        .close-modal:hover {
            color: var(--primary-color);
            transform: rotate(90deg);
        }

        .empty-cart {
            text-align: center;
            padding: 3rem;
            color: #666;
        }

        .empty-cart i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #ddd;
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 100px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 3000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }

        .notification.success {
            background: #4CAF50;
            color: white;
        }

        .notification.error {
            background: #f44336;
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 1rem;
            }

            .nav-container {
                flex-direction: column;
                gap: 1rem;
            }

            .nav-links {
                gap: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }

            .shop-page-title {
                font-size: 2.5rem;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header" id="header">
        <div class="nav-container">
            <a href="../index.php" class="logo">
                <i class="fas fa-crown"></i>
                MYNA FASHN
            </a>
            <nav>
                <ul class="nav-links">
                    <li><a href="../index.php">Accueil</a></li>
                    <li><a href="../index.php#new-arrivals">Nouveautés</a></li>
                    <li><a href="../index.php#boutiques" class="active">Boutiques</a></li>
                    <li><a href="../index.php#about">À propos</a></li>
                    <li><a href="../index.php#contact">Contact</a></li>
                </ul>
            </nav>
            <div class="nav-actions">
                <div class="cart-icon" id="cartBtn">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="cart-count" id="cartCount">0</span>
                </div>
            </div>
        </div>
    </header>

    <?php
    // Récupérer le paramètre de catégorie depuis l'URL
    $category = isset($_GET['category']) ? $_GET['category'] : 'jupes';
    $category_names = [
        'jupes' => 'Jupes',
        'robes' => 'Robes',
        'foulards' => 'Foulards',
        'ensembles' => 'Ensembles',
        'hijabs' => 'Hijabs'
    ];
    
    $category_name = isset($category_names[$category]) ? $category_names[$category] : 'Produits';
    ?>

    <!-- Page de boutique dynamique -->
    <div class="shop-page">
        <div class="shop-header">
            <a href="../index.php" class="back-to-home">
                <i class="fas fa-arrow-left"></i> Retour à l'accueil
            </a>
            <h1 class="shop-page-title">Boutique <?php echo $category_name; ?></h1>
            <p class="shop-page-subtitle">
                <?php 
                switch($category) {
                    case 'jupes': echo 'Découvrez notre collection exclusive de jupes algériennes, alliant tradition et modernité'; break;
                    case 'robes': echo 'Robes traditionnelles et modernes avec broderies et motifs authentiques'; break;
                    case 'foulards': echo 'Foulards en soie et coton aux couleurs vibrantes de notre patrimoine algérien'; break;
                    case 'ensembles': echo 'Ensembles complets pour toutes occasions, mariages, fêtes et cérémonies'; break;
                    case 'hijabs': echo 'Hijabs élégants et modestes dans le pur style algérien, pour toutes les occasions'; break;
                    default: echo 'Découvrez nos créations uniques qui allient tradition et modernité';
                }
                ?>
            </p>
        </div>
        
        <div class="section">
            <div class="products-grid" id="products-grid">
                <!-- Les produits seront chargés dynamiquement ici -->
                <div style="grid-column: 1/-1; text-align: center; padding: 2rem;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary-color);"></i>
                    <p>Chargement des produits...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>MYNA FASHN</h3>
                <p>Votre destination de mode privilégiée pour des créations qui allient tradition et modernité avec élégance.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Boutiques</h3>
                <ul class="footer-links">
                    <li><a href="boutiques.php?category=jupes">Boutique Jupes</a></li>
                    <li><a href="boutiques.php?category=foulards">Boutique Foulards</a></li>
                    <li><a href="boutiques.php?category=robes">Boutique Robes</a></li>
                    <li><a href="boutiques.php?category=ensembles">Boutique Ensembles</a></li>
                    <li><a href="boutiques.php?category=hijabs">Boutique Hijabs</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Service Client</h3>
                <ul class="footer-links">
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Livraison</a></li>
                    <li><a href="#">Retours</a></li>
                    <li><a href="#">Guide des Tailles</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <p><i class="fas fa-phone"></i> +213 123 45 67 89</p>
                <p><i class="fas fa-envelope"></i> contact@MYNAFASHN.dz</p>
                <p><i class="fas fa-map-marker-alt"></i> Alger, Algérie</p>
            </div>
        </div>
        <div class="copyright">
            &copy; 2025 MYNA FASHN. Tous droits réservés.
        </div>
    </footer>

    <!-- Modal Panier -->
    <div class="modal" id="cartModal">
        <div class="modal-content">
            <button class="close-modal" id="closeCart">&times;</button>
            <h2 style="margin-bottom: 2rem;">Votre Panier</h2>
            <div id="cartContent">
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <p>Votre panier est vide.</p>
                    <a href="../index.php" class="btn btn-primary">Découvrir nos collections</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Configuration de l'API
        const API_BASE_URL = window.location.origin + 'back/api.php';

        // Gestion du panier
        let cart = {
            items: [],
            total: 0,
            count: 0
        };

        // Charger les produits de la catégorie
        async function loadCategoryProducts() {
            const urlParams = new URLSearchParams(window.location.search);
            const category = urlParams.get('category') || 'jupes';
            
            try {
                const response = await fetch(`${API_BASE_URL}?action=get_products&category=${category}`);
                const data = await response.json();
                
                const productsGrid = document.getElementById('products-grid');
                
                if (data.success && data.data && data.data.length > 0) {
                    productsGrid.innerHTML = data.data.map(product => createProductHTML(product)).join('');
                    attachProductEvents();
                    
                    // Observer pour les animations
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('fade-in');
                            }
                        });
                    }, { threshold: 0.1 });

                    document.querySelectorAll('.product-card').forEach(card => {
                        observer.observe(card);
                    });
                } else {
                    productsGrid.innerHTML = `
                        <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                            <i class="fas fa-tshirt" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
                            <p style="color: #666; font-size: 1.2rem;">Aucun produit disponible dans cette catégorie</p>
                            <p style="color: #999; margin-top: 0.5rem;">Revenez bientôt pour découvrir nos nouvelles collections</p>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Erreur:', error);
                document.getElementById('products-grid').innerHTML = `
                    <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 4rem; color: #ff6b6b; margin-bottom: 1rem;"></i>
                        <p style="color: #666; font-size: 1.2rem;">Erreur de chargement des produits</p>
                        <button onclick="loadCategoryProducts()" class="btn btn-primary" style="margin-top: 1rem;">
                            <i class="fas fa-redo"></i> Réessayer
                        </button>
                    </div>
                `;
            }
        }

        // Créer le HTML d'un produit
        function createProductHTML(product) {
            const imageUrl = product.image || `https://via.placeholder.com/300x400/8b4513/ffffff?text=${encodeURIComponent(product.name)}`;
            
            return `
                <div class="product-card fade-in">
                    <div class="product-image">
                        <img src="${imageUrl}" alt="${product.name}" 
                             onerror="this.src='https://via.placeholder.com/300x400/8b4513/ffffff?text=Produit'">
                        ${product.original_price && product.original_price > product.price ? 
                            '<div class="product-badge">PROMO</div>' : ''}
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">${product.name}</h3>
                        <p class="product-description">${product.description}</p>
                        
                        <div class="product-price">
                            <span class="current-price">${formatPrice(product.price)}</span>
                            ${product.original_price && product.original_price > product.price ? 
                                `<span class="original-price">${formatPrice(product.original_price)}</span>` : ''}
                        </div>

                        <div class="product-variants">
                            ${product.sizes && product.sizes.length > 0 ? `
                                <select class="variant-select size-select">
                                    <option value="">Taille</option>
                                    ${product.sizes.map(size => `<option value="${size}">${size}</option>`).join('')}
                                </select>
                            ` : ''}
                            
                            ${product.colors && product.colors.length > 0 ? `
                                <select class="variant-select color-select">
                                    <option value="">Couleur</option>
                                    ${product.colors.map(color => `<option value="${color}">${color}</option>`).join('')}
                                </select>
                            ` : ''}
                        </div>

                        <div class="product-actions">
                            <button class="btn btn-primary btn-sm add-to-cart" 
                                    data-id="${product.id}"
                                    data-name="${product.name}"
                                    data-price="${product.price}"
                                    data-image="${imageUrl}">
                                <i class="fas fa-shopping-bag"></i> Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        // Attacher les événements aux produits
        function attachProductEvents() {
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productCard = this.closest('.product-card');
                    const productImage = this.dataset.image;
                    const productName = this.dataset.name;
                    const productPrice = parseInt(this.dataset.price);
                    const productId = this.dataset.id;
                    
                    const sizeSelect = productCard.querySelector('.size-select');
                    const colorSelect = productCard.querySelector('.color-select');
                    
                    const size = sizeSelect ? sizeSelect.value : '';
                    const color = colorSelect ? colorSelect.value : '';
                    
                    if ((sizeSelect && !size) || (colorSelect && !color)) {
                        showNotification('Veuillez sélectionner une taille et une couleur', 'error');
                        return;
                    }
                    
                    const product = {
                        id: productId,
                        name: productName,
                        price: productPrice,
                        size: size,
                        color: color,
                        quantity: 1,
                        image: productImage
                    };
                    
                    addToCart(product);
                });
            });
        }

        // Fonctions utilitaires
        function formatPrice(price) {
            return new Intl.NumberFormat('fr-DZ', {
                style: 'currency',
                currency: 'DZD',
                minimumFractionDigits: 0
            }).format(price);
        }

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(400px)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Fonctions de gestion du panier
        function loadCart() {
            const savedCart = localStorage.getItem('mynafashnCart');
            if (savedCart) {
                cart = JSON.parse(savedCart);
                updateCartUI();
            }
        }

        function saveCart() {
            localStorage.setItem('mynafashnCart', JSON.stringify(cart));
        }

        function updateCartUI() {
            document.getElementById('cartCount').textContent = cart.count;
        }

        function addToCart(product) {
            const existingItemIndex = cart.items.findIndex(item => 
                item.id === product.id && 
                item.size === product.size && 
                item.color === product.color
            );
            
            if (existingItemIndex !== -1) {
                cart.items[existingItemIndex].quantity += product.quantity;
            } else {
                cart.items.push(product);
            }
            
            updateCartTotals();
            saveCart();
            updateCartUI();
            showNotification(`${product.name} ajouté au panier!`);
        }

        function updateCartTotals() {
            cart.total = cart.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            cart.count = cart.items.reduce((sum, item) => sum + item.quantity, 0);
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            loadCart();
            loadCategoryProducts();
            
            // Header scroll effect
            window.addEventListener('scroll', () => {
                const header = document.getElementById('header');
                header.classList.toggle('scrolled', window.scrollY > 100);
            });

            // Gestion du panier
            document.getElementById('cartBtn').addEventListener('click', () => {
                document.getElementById('cartModal').style.display = 'flex';
            });

            document.getElementById('closeCart').addEventListener('click', () => {
                document.getElementById('cartModal').style.display = 'none';
            });

            // Fermer le modal en cliquant à l'extérieur
            window.addEventListener('click', (e) => {
                if (e.target === document.getElementById('cartModal')) {
                    document.getElementById('cartModal').style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>