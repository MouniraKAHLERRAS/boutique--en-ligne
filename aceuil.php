<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINA FASHION - Mode Algérienne Élégante</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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

        /* Header Élégant */
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

        /* Hero Section Spectaculaire */
        .hero {
            height: 100vh;
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.9), rgba(218, 165, 32, 0.8)),
                        url('https://images.unsplash.com/photo-1566479334581-d354148c17c9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.05)" points="0,1000 1000,0 1000,1000"/></svg>');
            animation: float 20s infinite linear;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 2rem;
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            animation: fadeInUp 1s ease 0.2s both;
        }

        .btn {
            padding: 1.2rem 2.5rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
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
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: var(--transition);
        }

        .btn:hover::before {
            left: 100%;
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

        .btn-outline {
            background: transparent;
            border: 2px solid var(--white);
            color: var(--white);
        }

        .btn-outline:hover {
            background: var(--white);
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        /* Sections Animées */
        .section {
            padding: 6rem 2rem;
            position: relative;
        }

        .section-title {
            text-align: center;
            font-size: 3.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: var(--dark-color);
            opacity: 0.7;
            margin-bottom: 4rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Boutiques par Catégorie */
        .shops-section {
            padding: 4rem 2rem;
            background: var(--light-color);
        }

        .shops-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .shop-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
            padding: 2rem;
            position: relative;
        }

        .shop-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .shop-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
        }

        .shop-name {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .shop-description {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .shop-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
        }

        .shop-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(139, 69, 19, 0.3);
        }

        /* Catégories Élégantes */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .category-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            cursor: pointer;
            height: 400px;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .category-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .category-card:hover img {
            transform: scale(1.1);
        }

        .category-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(44, 24, 16, 0.9));
            color: var(--white);
            padding: 2rem;
            transform: translateY(20px);
            opacity: 0;
            transition: var(--transition);
        }

        .category-card:hover .category-overlay {
            transform: translateY(0);
            opacity: 1;
        }

        .category-name {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        /* Produits Luxueux */
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

        .btn-sm {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            border-radius: 8px;
        }

        /* Nouveautés */
        .new-arrivals {
            background: linear-gradient(135deg, var(--light-color), #f8f0ff);
        }

        /* Footer Luxueux */
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

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .fade-in {
            animation: fadeInUp 0.8s ease both;
        }

        /* Modal Panier */
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

        .cart-items {
            margin-bottom: 2rem;
        }

        .cart-item {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-details h4 {
            margin-bottom: 0.5rem;
        }

        .cart-item-variants {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #666;
        }

        .cart-item-price {
            font-weight: 600;
            color: var(--primary-color);
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .qty-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background: var(--white);
            border-radius: 5px;
            cursor: pointer;
            transition: var(--transition);
        }

        .qty-btn:hover {
            background: var(--light-color);
        }

        .cart-item-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-between;
        }

        .cart-item-subtotal {
            font-weight: 600;
            color: var(--primary-color);
        }

        .btn-remove {
            background: none;
            border: none;
            color: #ff6b6b;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-remove:hover {
            color: #ff5252;
            transform: scale(1.1);
        }

        .cart-total {
            text-align: right;
            font-size: 1.5rem;
            margin-bottom: 2rem;
            padding-top: 1rem;
            border-top: 2px solid #eee;
        }

        .cart-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
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

        .notification.info {
            background: #2196F3;
            color: white;
        }

        .notification-content {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Pages de boutique */
        .shop-page {
            padding-top: 120px;
            min-height: 100vh;
        }

        .shop-header {
            text-align: center;
            padding: 3rem 0;
            background: linear-gradient(135deg, var(--light-color), #f8f0ff);
        }

        .shop-page-title {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .shop-page-subtitle {
            font-size: 1.2rem;
            color: var(--dark-color);
            opacity: 0.7;
            max-width: 600px;
            margin: 0 auto;
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

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .section-title {
                font-size: 2.5rem;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .cart-actions {
                flex-direction: column;
            }

            .shop-page-title {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header Élégant -->
    <header class="header" id="header">
        <div class="nav-container">
            <div class="logo">
                <i class="fas fa-crown"></i>
                MINA FASHION
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#" class="active">Accueil</a></li>
                    <li><a href="#new-arrivals">Nouveautés</a></li>
                    <li><a href="#boutiques">Boutiques</a></li>
                    <li><a href="#about">À propos</a></li>
                    <li><a href="#contact">Contact</a></li>
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

    <!-- Hero Section Spectaculaire -->
    <section class="hero" style="
    background: url('images/foulard3.jpg') no-repeat center center/cover;
    color: white;
    padding: 80px 20px;
    text-align: center;
">
    <div class="hero-content" style="background-color: rgba(0,0,0,0.5); padding: 20px; border-radius: 10px;">
        <h1 class="hero-title">MINA FASHION</h1>
        <p class="hero-subtitle">Découvrez l'élégance de la mode algérienne. Des pièces uniques qui célèbrent la femme moderne avec authenticité.</p>
        <div style="display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap;">
            <a href="#boutiques" class="btn btn-primary">
                <i class="fas fa-star"></i> Découvrir
            </a>
            <a href="#new-arrivals" class="btn btn-outline">
                <i class="fas fa-bolt"></i> Nouveautés
            </a>
        </div>
    </div>
</section>


     <!-- Nouveautés -->
    <section id="new-arrivals" class="section new-arrivals">
        <h2 class="section-title">Nouveautés</h2>
        <p class="section-subtitle">Découvrez nos dernières créations exclusives</p>
        <div class="products-grid">
            <!-- Jupe Saharienne -->
            <div class="product-card fade-in" data-category="jupes">
                <div class="product-image">
                    <img src="images/jupe2.png" alt="nouvelle Jupe">
                    <div class="product-badge">NOUVEAU</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Jupe Longue </h3>
                    <p class="product-description">Jupe longue inspirée du Sahara algérien. Tissu fluide et motifs désertiques authentiques.</p>
                    
                    <div class="product-price">
                        <span class="current-price">3 900 DA</span>
                        <span class="original-price">9 200 DA</span>
                    </div>

                    <div class="product-variants">
                        <select class="variant-select size-select">
                            <option value="">Taille</option>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                        </select>
                        
                        <select class="variant-select color-select">
                            <option value="">Couleur</option>
                            <option value="Bleu désert">Bleu désert</option>
                            <option value="Sable">Sable</option>
                            <option value="Terracotta">Terracotta</option>
                        </select>
                    </div>

                    <div class="product-actions">
                        <button class="btn btn-primary btn-sm add-to-cart" 
                                data-id="1"
                                data-name="Jupe Longue Saharienne"
                                data-price="8900">
                            <i class="fas fa-shopping-bag"></i> Ajouter
                        </button>
                        <button class="btn btn-outline btn-sm view-details">
                            <i class="fas fa-eye"></i> Voir
                        </button>
                    </div>
                </div>
            </div>

            <!-- Foulard Soie DZ -->
            <div class="product-card fade-in" data-category="foulards">
                <div class="product-image">
                    <img src="images/ensemble2.jpg" alt="Ensemble double Kimono">
                    <div class="product-badge">NOUVEAU</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Ensemble double Kimono</h3>
                    <p class="product-description">Notre ensemble tendance de la saison qui ajoutera de la beauté à votre beauté .</p>
                    
                    <div class="product-price">
                        <span class="current-price">4 400 DA</span>
                        <span class="original-price">5 500 DA</span>
                    </div>
                    
                    <div class="product-variants">
                        <select class="variant-select size-select">
                            <option value="">Taille</option>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                        </select>
                        <select class="variant-select color-select">
                            <option value="">Couleur</option>
                            <option value="Vert, Blanc, Rouge">Vert, Blanc, Rouge</option>
                            <option value="Vert et Blanc">Vert et Blanc</option>
                            <option value="Rouge et Blanc">Rouge et Blanc</option>
                        </select>
                    </div>

                    <div class="product-actions">
                        <button class="btn btn-primary btn-sm add-to-cart" 
                                data-id="2"
                                data-name="Ensemble double Kimono"
                                data-price="4400">
                            <i class="fas fa-shopping-bag"></i> Ajouter
                        </button>
                        <button class="btn btn-outline btn-sm view-details">
                            <i class="fas fa-eye"></i> Voir
                        </button>
                    </div>
                </div>
            </div>

            <!-- Robe Traditionnelle -->
            <div class="product-card fade-in" data-category="robes">
                <div class="product-image">
                    <img src="images/robe2.jpg" alt="Robe hidjab">
                    <div class="product-badge">NOUVEAU</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Robe hijdab</h3>
                    <p class="product-description">Robe hidjab avec broderies détaillées. Élégance orientale raffinée.</p>
                    
                    <div class="product-price">
                        <span class="current-price">12 800 DA</span>
                        <span class="original-price">15 500 DA</span>
                    </div>

                    <div class="product-variants">
                        <select class="variant-select size-select">
                            <option value="">Taille</option>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                        </select>
                        
                        <select class="variant-select color-select">
                            <option value="">Couleur</option>
                            <option value="Ivoire">Ivoire</option>
                            <option value="Rose pâle">Rose pâle</option>
                            <option value="Bleu ciel">Bleu ciel</option>
                        </select>
                    </div>

                    <div class="product-actions">
                        <button class="btn btn-primary btn-sm add-to-cart" 
                                data-id="3"
                                data-name="Robe Traditionnelle Brodée"
                                data-price="12800">
                            <i class="fas fa-shopping-bag"></i> Ajouter
                        </button>
                        <button class="btn btn-outline btn-sm view-details">
                            <i class="fas fa-eye"></i> Voir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Boutiques par Catégorie -->
    <section id="boutiques" class="shops-section">
        <h2 class="section-title">Nos Boutiques</h2>
        <p class="section-subtitle">Explorez nos collections spécialisées par catégorie</p>
        <div class="shops-grid">
            <div class="shop-card">
                
                <div class="shop-icon">
                </div>
                <h3 class="shop-name">Boutique Jupes</h3>
                <img src="images/jupes-images.jpg" alt="Jupe algérienne" style="width:100%; border-radius:10px; margin-bottom:15px;">
                <p class="shop-description">Découvrez notre collection exclusive de jupes algériennes, alliant tradition et modernité.</p>
                <a href="#boutique-jupes" class="shop-btn">Visiter la boutique</a>
            </div>
            <div class="shop-card">
                <div class="shop-icon">
                </div>
                <h3 class="shop-name">Boutique Foulards</h3>
                <img src="images/image-foulards.jpg" alt="Jupe algérienne" style="width:100%; border-radius:10px; margin-bottom:15px;">
                <p class="shop-description">Foulards en soie et coton aux couleurs vibrantes de notre patrimoine algérien.</p>
                <a href="#boutique-foulards" class="shop-btn">Visiter la boutique</a>
            </div>
            <div class="shop-card">
                <div class="shop-icon">
                </div>
                <h3 class="shop-name">Boutique Robes</h3>
                <img src="images/robes-image.jpg" alt="Jupe algérienne" style="width:100%; border-radius:10px; margin-bottom:15px;">
                <p class="shop-description">Robes traditionnelles et modernes avec broderies et motifs authentiques.</p>
                <a href="#boutique-robes" class="shop-btn">Visiter la boutique</a>
            </div>
            <div class="shop-card">
                <div class="shop-icon">
                </div>
                <h3 class="shop-name">Boutique Ensembles</h3>
                <img src="images/ensembles-hidjabes.jpg" alt="Jupe algérienne" style="width:100%; border-radius:10px; margin-bottom:15px;">
                <p class="shop-description">Ensembles complets pour toutes occasions, mariages, fêtes et cérémonies.</p>
                <a href="#boutique-ensembles" class="shop-btn">Visiter la boutique</a>
            </div>
            <div class="shop-card">
                <div class="shop-icon">
                </div>
                <h3 class="shop-name">Boutique Hijabs</h3>
                <img src="images/image-hidjab.jpg" alt="Jupe algérienne" style="width:100%; border-radius:10px; margin-bottom:15px;">
                <p class="shop-description">Hijabs élégants et modestes dans le pur style algérien, pour toutes les occasions.</p>
                <a href="#boutique-hijabs" class="shop-btn">Visiter la boutique</a>
            </div>
        </div>
    </section>
    

    <!-- À propos -->
    <section id="about" class="section">
        <h2 class="section-title">Notre Histoire</h2>
        <p class="section-subtitle">MINA FASHION incarne l'élégance et l'authenticité de la mode algérienne</p>
        <div style="max-width: 1000px; margin: 0 auto; text-align: center;">
            <p style="font-size: 1.2rem; line-height: 1.8; margin-bottom: 2rem;">
                Fondée en 2025, MINA FASHION s'est imposée comme la référence de la mode féminine algérienne. 
                Nous créons des pièces uniques qui allient tradition et modernité, en puisant notre inspiration 
                dans le riche patrimoine culturel algérien.
            </p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 3rem;">
                <div>
                    <i class="fas fa-hands" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                    <h3 style="margin-bottom: 1rem;">Artisanat Local</h3>
                    <p>Nous travaillons avec des artisans locaux pour préserver les techniques traditionnelles.</p>
                </div>
                <div>
                    <i class="fas fa-leaf" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                    <h3 style="margin-bottom: 1rem;">Matériaux Naturels</h3>
                    <p>Nous utilisons des tissus naturels et écologiques pour nos créations.</p>
                </div>
                <div>
                    <i class="fas fa-medal" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                    <h3 style="margin-bottom: 1rem;">Qualité Supérieure</h3>
                    <p>Chaque pièce est confectionnée avec soin et attention aux détails.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="footer-content">
            <div class="footer-section">
                <h3>MINA FASHION</h3>
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
                    <li><a href="#boutique-jupes">Boutique Jupes</a></li>
                    <li><a href="#boutique-foulards">Boutique Foulards</a></li>
                    <li><a href="#boutique-robes">Boutique Robes</a></li>
                    <li><a href="#boutique-ensembles">Boutique Ensembles</a></li>
                    <li><a href="#boutique-hijabs">Boutique Hijabs</a></li>
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
                <p><i class="fas fa-envelope"></i> contact@minafashion.dz</p>
                <p><i class="fas fa-map-marker-alt"></i> Alger, Algérie</p>
            </div>
        </div>
        <div class="copyright">
            &copy; 2025 MINA FASHION. Tous droits réservés.
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
                    <a href="#collections" class="btn btn-primary">Découvrir nos collections</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pages de boutique (exemple pour jupes) -->
    <div id="boutique-jupes" class="shop-page" style="display: none;">
        <div class="shop-header">
            <h1 class="shop-page-title">Boutique Jupes</h1>
            <p class="shop-page-subtitle">Découvrez notre collection exclusive de jupes algériennes, alliant tradition et modernité</p>
        </div>
        <div class="section">
            <div class="products-grid">
                <!-- Produits de la boutique jupes -->
                <div class="product-card fade-in">
                    <div class="product-image">
                        <img src="https://images.pexels.com/photos/7679820/pexels-photo-7679820.jpeg" alt="Jupe Saharienne">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Jupe Longue Saharienne</h3>
                        <p class="product-description">Jupe longue inspirée du Sahara algérien. Tissu fluide et motifs désertiques authentiques.</p>
                        <div class="product-price">
                            <span class="current-price">8 900 DA</span>
                            <span class="original-price">11 200 DA</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn btn-primary btn-sm add-to-cart" 
                                    data-id="1"
                                    data-name="Jupe Longue Saharienne"
                                    data-price="8900">
                                <i class="fas fa-shopping-bag"></i> Ajouter
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Ajoutez d'autres produits jupes ici -->
            </div>
        </div>
    </div>

    <script>
        // Gestion du panier
        let cart = {
            items: [],
            total: 0,
            count: 0
        };

        // Charger le panier depuis le localStorage
        function loadCart() {
            const savedCart = localStorage.getItem('minaFashionCart');
            if (savedCart) {
                cart = JSON.parse(savedCart);
                updateCartUI();
            }
        }

        // Sauvegarder le panier dans le localStorage
        function saveCart() {
            localStorage.setItem('minaFashionCart', JSON.stringify(cart));
        }

        // Mettre à jour l'interface du panier
        function updateCartUI() {
            const cartCount = document.getElementById('cartCount');
            cartCount.textContent = cart.count;
            
            const cartContent = document.getElementById('cartContent');
            
            if (cart.items.length === 0) {
                cartContent.innerHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <p>Votre panier est vide.</p>
                        <a href="#collections" class="btn btn-primary">Découvrir nos collections</a>
                    </div>
                `;
                return;
            }
            
            let cartHTML = '<div class="cart-items">';
            let total = 0;
            
            cart.items.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                
                cartHTML += `
                    <div class="cart-item" data-index="${index}">
                        <img src="${item.image}" alt="${item.name}">
                        <div class="cart-item-details">
                            <h4>${item.name}</h4>
                            <div class="cart-item-variants">
                                ${item.size ? `<span>Taille: ${item.size}</span>` : ''}
                                ${item.color ? `<span>Couleur: ${item.color}</span>` : ''}
                            </div>
                            <div class="cart-item-price">${formatPrice(item.price)}</div>
                            <div class="cart-item-quantity">
                                <button class="qty-btn" data-action="decrease">-</button>
                                <span class="qty">${item.quantity}</span>
                                <button class="qty-btn" data-action="increase">+</button>
                            </div>
                        </div>
                        <div class="cart-item-actions">
                            <div class="cart-item-subtotal">${formatPrice(itemTotal)}</div>
                            <button class="btn-remove" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
            
            cartHTML += '</div>';
            cartHTML += `
                <div class="cart-total">
                    <strong>Total: ${formatPrice(total)}</strong>
                </div>
                <div class="cart-actions">
                    <button class="btn btn-outline" id="clearCartBtn">Vider le panier</button>
                    <button class="btn btn-primary" id="checkoutBtn">Passer la commande</button>
                </div>
            `;
            
            cartContent.innerHTML = cartHTML;
            
            // Ajouter les écouteurs d'événements pour les boutons du panier
            document.querySelectorAll('.qty-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const action = this.dataset.action;
                    const index = this.closest('.cart-item').dataset.index;
                    updateQuantity(index, action);
                });
            });
            
            document.querySelectorAll('.btn-remove').forEach(btn => {
                btn.addEventListener('click', function() {
                    const index = this.closest('.cart-item').dataset.index;
                    removeFromCart(index);
                });
            });
            
            document.getElementById('clearCartBtn').addEventListener('click', clearCart);
            document.getElementById('checkoutBtn').addEventListener('click', checkout);
        }

        // Ajouter un produit au panier
        function addToCart(product) {
            // Vérifier si le produit est déjà dans le panier
            const existingItemIndex = cart.items.findIndex(item => 
                item.id === product.id && 
                item.size === product.size && 
                item.color === product.color
            );
            
            if (existingItemIndex !== -1) {
                // Produit déjà dans le panier, augmenter la quantité
                cart.items[existingItemIndex].quantity += product.quantity;
            } else {
                // Nouveau produit, l'ajouter au panier
                cart.items.push(product);
            }
            
            // Mettre à jour le total et le compteur
            updateCartTotals();
            
            // Sauvegarder et mettre à jour l'interface
            saveCart();
            updateCartUI();
            
            // Afficher une notification
            showNotification(`${product.name} ajouté au panier!`);
        }

        // Mettre à jour la quantité d'un produit
        function updateQuantity(index, action) {
            if (action === 'increase') {
                cart.items[index].quantity += 1;
            } else if (action === 'decrease') {
                cart.items[index].quantity -= 1;
                if (cart.items[index].quantity <= 0) {
                    removeFromCart(index);
                    return;
                }
            }
            
            updateCartTotals();
            saveCart();
            updateCartUI();
        }

        // Supprimer un produit du panier
        function removeFromCart(index) {
            cart.items.splice(index, 1);
            updateCartTotals();
            saveCart();
            updateCartUI();
        }

        // Vider le panier
        function clearCart() {
            cart.items = [];
            updateCartTotals();
            saveCart();
            updateCartUI();
            showNotification('Panier vidé');
        }

        // Mettre à jour les totaux du panier
        function updateCartTotals() {
            cart.total = cart.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            cart.count = cart.items.reduce((sum, item) => sum + item.quantity, 0);
        }

        // Passer la commande
        function checkout() {
            if (cart.items.length === 0) {
                showNotification('Votre panier est vide', 'error');
                return;
            }
            
            showNotification('Fonctionnalité de commande à implémenter', 'info');
            // Ici, vous pouvez rediriger vers une page de paiement ou afficher un formulaire
        }

        // Formater le prix
        function formatPrice(price) {
            return new Intl.NumberFormat('fr-DZ', {
                style: 'currency',
                currency: 'DZD',
                minimumFractionDigits: 0
            }).format(price);
        }

        // Afficher une notification
        function showNotification(message, type = 'success') {
            // Créer l'élément de notification
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animation d'entrée
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);
            
            // Supprimer après 3 secondes
            setTimeout(() => {
                notification.style.transform = 'translateX(400px)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Navigation entre les pages
        function showShopPage(shopId) {
            // Masquer toutes les pages de boutique
            document.querySelectorAll('.shop-page').forEach(page => {
                page.style.display = 'none';
            });
            
            // Afficher la page demandée
            const shopPage = document.getElementById(shopId);
            if (shopPage) {
                shopPage.style.display = 'block';
                // Masquer le contenu principal
                document.querySelector('main').style.display = 'none';
                // Faire défiler vers le haut
                window.scrollTo(0, 0);
            }
        }

        function showMainPage() {
            // Masquer toutes les pages de boutique
            document.querySelectorAll('.shop-page').forEach(page => {
                page.style.display = 'none';
            });
            // Afficher le contenu principal
            document.querySelector('main').style.display = 'block';
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            loadCart();
            
            // Header scroll effect
            window.addEventListener('scroll', () => {
                const header = document.getElementById('header');
                if (window.scrollY > 100) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });

            // Animation au scroll
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

            // Navigation vers les boutiques
            document.querySelectorAll('.shop-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const shopId = this.getAttribute('href').substring(1);
                    showShopPage(shopId);
                });
            });

            // Retour à l'accueil depuis le logo
            document.querySelector('.logo').addEventListener('click', function(e) {
                e.preventDefault();
                showMainPage();
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

            // Ajouter au panier
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productCard = this.closest('.product-card');
                    const productImage = productCard.querySelector('img').src;
                    const productName = this.dataset.name;
                    const productPrice = parseInt(this.dataset.price);
                    const productId = this.dataset.id;
                    
                    // Récupérer les sélections de taille et couleur
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
        });
    </script>
</body>
</html>