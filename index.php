<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MYNA FASHN - Mode Algérienne Élégante</title>
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
            --success-color: #4CAF50;
            --error-color: #f44336;
            --info-color: #2196F3;
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
            cursor: pointer;
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

        /* Styles améliorés pour l'authentification */
        .auth-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
        }

        .auth-dropdown {
            position: relative;
        }

        .auth-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
            box-shadow: 0 4px 15px rgba(139, 69, 19, 0.3);
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 69, 19, 0.4);
        }

        .auth-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: var(--white);
            min-width: 220px;
            box-shadow: var(--shadow-hover);
            border-radius: 12px;
            padding: 1rem;
            z-index: 1000;
            margin-top: 0.5rem;
            border: 1px solid rgba(0,0,0,0.1);
        }

        .auth-dropdown-content.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-user-info {
            padding: 0.75rem;
            border-bottom: 1px solid #eee;
            margin-bottom: 0.75rem;
            text-align: center;
        }

        .auth-user-name {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
        }

        .auth-user-email {
            font-size: 0.8rem;
            color: #666;
        }

        .auth-actions {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .auth-action-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 8px;
            background: none;
            cursor: pointer;
            transition: var(--transition);
            text-align: left;
            width: 100%;
            font-size: 0.9rem;
        }

        .auth-action-btn:hover {
            background: var(--light-color);
        }

        .auth-action-btn i {
            width: 16px;
            text-align: center;
        }

        .auth-action-btn.admin {
            color: var(--success-color);
        }

        .auth-action-btn.logout {
            color: var(--error-color);
        }

        .auth-action-btn.login {
            color: var(--primary-color);
        }

        .auth-action-btn.register {
            color: var(--secondary-color);
        }

        .auth-badge {
            background: var(--success-color);
            color: white;
            border-radius: 12px;
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
            margin-left: auto;
        }

        .btn-admin {
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: left;
        }

        .btn-admin:hover {
            background-color: #a0522d;
        }

        .hero {
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('assets/images/foulard3.jpg') no-repeat center center/cover;
            color: white;
            padding: 80px 20px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
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
            max-width: 800px;
            position: relative;
            z-index: 2;
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
        }

        .shop-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
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
            flex: 1;
            min-width: 120px;
        }

        .variant-select:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(139, 69, 19, 0.1);
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

        .validation-message {
            display: none;
            color: var(--error-color);
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .new-arrivals {
            background: linear-gradient(135deg, var(--light-color), #f8f0ff);
        }

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

        .shop-page {
            display: none;
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
            color: var(--error-color);
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

        .promo-section {
            margin: 1.5rem 0;
            padding: 1rem;
            background: var(--light-color);
            border-radius: 10px;
        }

        .promo-input-group {
            display: flex;
            gap: 0.5rem;
        }

        .promo-input {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .promo-btn {
            padding: 0.75rem 1.5rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        .promo-btn:hover {
            background: var(--secondary-color);
        }

        .promo-message {
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }

        .promo-success {
            color: var(--success-color);
        }

        .promo-error {
            color: var(--error-color);
        }

        .shipping-options {
            margin: 1.5rem 0;
        }

        .shipping-option {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .shipping-option:hover {
            border-color: var(--primary-color);
        }

        .shipping-option.selected {
            border-color: var(--primary-color);
            background: rgba(139, 69, 19, 0.05);
        }

        .shipping-radio {
            width: 20px;
            height: 20px;
        }

        .shipping-info {
            flex: 1;
        }

        .shipping-price {
            font-weight: 600;
            color: var(--primary-color);
        }

        .payment-info {
            background: var(--light-color);
            padding: 1rem;
            border-radius: 10px;
            margin: 1rem 0;
            text-align: center;
            border-left: 4px solid var(--primary-color);
        }

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
            max-width: 400px;
        }

        .notification.success {
            background: var(--success-color);
            color: white;
        }

        .notification.error {
            background: var(--error-color);
            color: white;
        }

        .notification.info {
            background: var(--info-color);
            color: white;
        }

        .notification-content {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkout-form {
            max-width: 800px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        .checkout-summary {
            background: var(--light-color);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .summary-title {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            font-size: 1.2rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .summary-discount {
            color: var(--success-color);
        }

        .summary-shipping {
            color: var(--info-color);
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: var(--white);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Modal d'authentification unifiée */
        .auth-modal {
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

        .auth-content {
            background: var(--white);
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            padding: 2rem;
            position: relative;
            box-shadow: var(--shadow-hover);
        }

        .auth-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }

        .tab-buttons {
            display: flex;
            margin-bottom: 2rem;
            border-bottom: 2px solid #eee;
        }

        .tab-btn {
            flex: 1;
            padding: 1rem;
            background: none;
            border: none;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            color: #666;
        }

        .tab-btn.active {
            color: var(--primary-color);
            border-bottom: 3px solid var(--primary-color);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .auth-form .form-group {
            margin-bottom: 1.5rem;
        }

        .auth-submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .auth-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 69, 19, 0.4);
        }

        .auth-submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .auth-links {
            text-align: center;
            margin-top: 1rem;
        }

        .auth-links a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        .auth-error {
            color: var(--error-color);
            text-align: center;
            margin-top: 1rem;
            padding: 0.5rem;
            background: rgba(244, 67, 54, 0.1);
            border-radius: 5px;
            display: none;
        }

        .user-type-selector {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .user-type-btn {
            flex: 1;
            padding: 1rem;
            border: 2px solid #e0e0e0;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            font-weight: 600;
        }

        .user-type-btn.active {
            border-color: var(--primary-color);
            background: rgba(139, 69, 19, 0.05);
            color: var(--primary-color);
        }

        .user-type-btn i {
            display: block;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .admin-info {
            margin-top: 2rem;
            padding: 1rem;
            background: var(--light-color);
            border-radius: 10px;
            font-size: 0.9rem;
        }

        .admin-info h4 {
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

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

            .form-row {
                grid-template-columns: 1fr;
            }

            .product-variants {
                flex-direction: column;
            }

            .variant-select {
                min-width: 100%;
            }

            .promo-input-group {
                flex-direction: column;
            }

            .back-to-home {
                position: relative;
                top: auto;
                left: auto;
                margin-bottom: 1rem;
            }

            .auth-section {
                gap: 0.5rem;
            }
            
            .auth-btn {
                padding: 0.6rem 1rem;
                font-size: 0.8rem;
            }
            
            .auth-dropdown-content {
                right: -50px;
                min-width: 200px;
            }

            .user-type-selector {
                flex-direction: column;
            }
            .cart-owner-indicator {
    text-align: center;
    padding: 0.75rem;
    background: var(--light-color);
    border-radius: 10px;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
    border-left: 4px solid var(--primary-color);
}

.cart-owner-indicator i {
    margin-right: 0.5rem;
}

.user-cart {
    border: 2px solid var(--success-color);
}

.guest-cart {
    border: 2px solid var(--info-color);
}
        }
    </style>
</head>
<body>
    <header class="header" id="header">
        <div class="nav-container">
            <div class="logo" onclick="showMainPage()">
                <i class="fas fa-crown"></i>
                MYNA FASHN
            </div>
            <nav>
    <ul class="nav-links">
        <li><a href="#" class="active" onclick="showMainPage()">Accueil</a></li>
        <li><a href="#new-arrivals" onclick="handleNavClick(event, '#new-arrivals')">Nouveautés</a></li>
        <li><a href="#boutiques" onclick="handleNavClick(event, '#boutiques')">Boutiques</a></li>
        <li><a href="#about" onclick="handleNavClick(event, '#about')">À propos</a></li>
        <li><a href="#contact" onclick="handleNavClick(event, '#contact')">Contact</a></li>
    </ul>
</nav>
            <div class="nav-actions">
                <div class="cart-icon" id="cartBtn">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="cart-count" id="cartCount">0</span>
                </div>
                
                <!-- Authentification unifiée -->
                <div class="auth-section" id="authSection">
                    <div class="auth-dropdown">
                        <button class="auth-btn" id="authToggle">
                            <i class="fas fa-user"></i>
                            <span id="authText">Mon Compte</span>
                            <i class="fas fa-chevron-down" style="font-size: 0.8rem;"></i>
                        </button>
                        <div class="auth-dropdown-content" id="authDropdown">
                            <!-- Contenu pour invité (non connecté) -->
                            <div class="auth-guest">
                                <div class="auth-user-info">
                                    <p>Bienvenue chez MYNA FASHN</p>
                                </div>
                                <div class="auth-actions">
                                    <button class="auth-action-btn login" onclick="showAuthModal('login')">
                                        <i class="fas fa-sign-in-alt"></i>
                                        Se connecter
                                    </button>
                                    <button class="auth-action-btn register" onclick="showAuthModal('register')">
                                        <i class="fas fa-user-plus"></i>
                                        Créer un compte
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Contenu pour utilisateur connecté -->
                            <div class="auth-customer">
                                <div class="auth-user-info">
                                    <div class="auth-user-name" id="userName"></div>
                                    <div class="auth-user-email" id="userEmail"></div>
                                </div>
                               <div class="auth-actions">
    <!-- Bouton Admin pour les utilisateurs administrateurs -->
    <a href="back/admin_dashboard.php?access=admin" class="btn-admin" id="adminAccessLink" style="display:none;">
    <i class="fas fa-crown"></i> Espace Administrateur
</a>

    <span id="adminBadge" style="display:none;">Admin</span>

    <!-- Bouton de déconnexion -->
    <button class="auth-action-btn logout" onclick="handleLogout()" style="display:none;">
        <i class="fas fa-sign-out-alt"></i> Déconnexion
    </button>
</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main id="main-content">
        <section class="hero">
            <div class="hero-content">
                <h1 class="hero-title">MYNA FASHN</h1>
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

        <section id="new-arrivals" class="section new-arrivals">
            <h2 class="section-title">Nouveautés</h2>
            <p class="section-subtitle">Découvrez nos dernières créations exclusives</p>
            <div class="products-grid" id="new-arrivals-grid">
            </div>
        </section>

        <section id="boutiques" class="shops-section">
            <h2 class="section-title">Nos Boutiques</h2>
            <p class="section-subtitle">Explorez nos collections spécialisées par catégorie</p>
            <div class="shops-grid">
                <div class="shop-card">
                    <h3 class="shop-name">Boutique Jupes</h3>
                    <img src="assets/images/jupes-images.jpg" alt="Jupe algérienne" style="width:100%; border-radius:10px; margin-bottom:15px;">
                    <p class="shop-description">Découvrez notre collection exclusive de jupes algériennes, alliant tradition et modernité.</p>
                    <button class="shop-btn" onclick="showShopPage('boutique-jupes')">Visiter la boutique</button>
                </div>
                <div class="shop-card">
                    <h3 class="shop-name">Boutique Foulards</h3>
                    <img src="assets/images/foulard2.jpg" alt="Foulard algérien" style="width:100%; border-radius:10px; margin-bottom:15px;">
                    <p class="shop-description">Foulards en soie et coton aux couleurs vibrantes de notre patrimoine algérien.</p>
                    <button class="shop-btn" onclick="showShopPage('boutique-foulards')">Visiter la boutique</button>
                </div>
                <div class="shop-card">
                    <h3 class="shop-name">Boutique Robes</h3>
                    <img src="assets/images/robes-image.jpg" alt="Robe algérienne" style="width:100%; border-radius:10px; margin-bottom:15px;">
                    <p class="shop-description">Robes traditionnelles et modernes avec broderies et motifs authentiques.</p>
                    <button class="shop-btn" onclick="showShopPage('boutique-robes')">Visiter la boutique</button>
                </div>
                <div class="shop-card">
                    <h3 class="shop-name">Boutique Ensembles</h3>
                    <img src="assets/images/ensembles-hidjabes.jpg" alt="Ensemble algérien" style="width:100%; border-radius:10px; margin-bottom:15px;">
                    <p class="shop-description">Ensembles complets pour toutes occasions, mariages, fêtes et cérémonies.</p>
                    <button class="shop-btn" onclick="showShopPage('boutique-ensembles')">Visiter la boutique</button>
                </div>
                <div class="shop-card">
                    <h3 class="shop-name">Boutique Hijabs</h3>
                    <img src="assets/images/image-hidjab.jpg" alt="Hijab algérien" style="width:100%; border-radius:10px; margin-bottom:15px;">
                    <p class="shop-description">Hijabs élégants et modestes dans le pur style algérien, pour toutes les occasions.</p>
                    <button class="shop-btn" onclick="showShopPage('boutique-hijabs')">Visiter la boutique</button>
                </div>
            </div>
        </section>

        <section id="about" class="section">
            <h2 class="section-title">Notre Histoire</h2>
            <p class="section-subtitle">MYNA FASHN incarne l'élégance et l'authenticité de la mode algérienne</p>
            <div style="max-width: 1000px; margin: 0 auto; text-align: center;">
                <p style="font-size: 1.2rem; line-height: 1.8; margin-bottom: 2rem;">
                    Fondée en 2025, MYNA FASHN s'est imposée comme la référence de la mode féminine algérienne. 
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
    </main>

    <div id="boutique-jupes" class="shop-page">
        <div class="shop-header">
            <button class="back-to-home" onclick="showMainPage()">
                <i class="fas fa-arrow-left"></i> Retour à l'accueil
            </button>
            <h1 class="shop-page-title">Boutique Jupes</h1>
            <p class="shop-page-subtitle">Découvrez notre collection exclusive de jupes algériennes, alliant tradition et modernité</p>
        </div>
        <div class="section">
            <div class="products-grid" id="boutique-jupes-grid">
            </div>
        </div>
    </div>

    <div id="boutique-robes" class="shop-page">
        <div class="shop-header">
            <button class="back-to-home" onclick="showMainPage()">
                <i class="fas fa-arrow-left"></i> Retour à l'accueil
            </button>
            <h1 class="shop-page-title">Boutique Robes</h1>
            <p class="shop-page-subtitle">Robes traditionnelles et modernes avec broderies et motifs authentiques</p>
        </div>
        <div class="section">
            <div class="products-grid" id="boutique-robes-grid">
            </div>
        </div>
    </div>

    <div id="boutique-foulards" class="shop-page">
        <div class="shop-header">
            <button class="back-to-home" onclick="showMainPage()">
                <i class="fas fa-arrow-left"></i> Retour à l'accueil
            </button>
            <h1 class="shop-page-title">Boutique Foulards</h1>
            <p class="shop-page-subtitle">Foulards en soie et coton aux couleurs vibrantes de notre patrimoine algérien</p>
        </div>
        <div class="section">
            <div class="products-grid" id="boutique-foulards-grid">
            </div>
        </div>
    </div>

    <div id="boutique-ensembles" class="shop-page">
        <div class="shop-header">
            <button class="back-to-home" onclick="showMainPage()">
                <i class="fas fa-arrow-left"></i> Retour à l'accueil
            </button>
            <h1 class="shop-page-title">Boutique Ensembles</h1>
            <p class="shop-page-subtitle">Ensembles complets pour toutes occasions, mariages, fêtes et cérémonies</p>
        </div>
        <div class="section">
            <div class="products-grid" id="boutique-ensembles-grid">
            </div>
        </div>
    </div>

    <div id="boutique-hijabs" class="shop-page">
        <div class="shop-header">
            <button class="back-to-home" onclick="showMainPage()">
                <i class="fas fa-arrow-left"></i> Retour à l'accueil
            </button>
            <h1 class="shop-page-title">Boutique Hijabs</h1>
            <p class="shop-page-subtitle">Hijabs élégants et modestes dans le pur style algérien, pour toutes les occasions</p>
        </div>
        <div class="section">
            <div class="products-grid" id="boutique-hijabs-grid">
            </div>
        </div>
    </div>

    <div class="modal" id="cartModal">
        <div class="modal-content">
            <button class="close-modal" id="closeCart">&times;</button>
            <h2 style="margin-bottom: 2rem;">Votre Panier</h2>
            <div id="cartContent">
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <p>Votre panier est vide.</p>
                    <button class="btn btn-primary" onclick="showMainPage(); document.getElementById('cartModal').style.display='none'">Découvrir nos collections</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="checkoutModal">
        <div class="modal-content">
            <button class="close-modal" id="closeCheckout">&times;</button>
            <h2 style="margin-bottom: 2rem;">Finaliser votre commande</h2>
            <div class="checkout-form" id="checkoutForm">
            </div>
        </div>
    </div>
    
    <!-- Modal d'authentification unifiée -->
    <div class="modal auth-modal" id="authModal">
        <div class="modal-content auth-content">
            <button class="close-modal" id="closeAuth">&times;</button>
            <h2 class="auth-title"><i class="fas fa-user-circle"></i> Authentification</h2>
            
            <div class="tab-buttons">
                <button class="tab-btn active" data-tab="login">Connexion</button>
                <button class="tab-btn" data-tab="register">Inscription</button>
            </div>
            
            <!-- Formulaire de connexion -->
            <div id="loginTab" class="tab-content active">
                <form id="loginForm" class="auth-form">
                    <div class="form-group">
                        <label class="form-label" for="loginEmail">Email</label>
                        <input type="email" id="loginEmail" class="form-input" placeholder="votre@email.com" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="loginPassword">Mot de passe</label>
                        <input type="password" id="loginPassword" class="form-input" placeholder="Votre mot de passe" required>
                    </div>
                    <button type="submit" class="auth-submit-btn" id="submitLogin">
                        <i class="fas fa-sign-in-alt"></i> Se connecter
                    </button>
                    <div class="auth-links">
                        <a onclick="showTab('register')">Pas encore de compte ? S'inscrire</a>
                    </div>
                </form>
            </div>
            
            <!-- Formulaire d'inscription -->
            <div id="registerTab" class="tab-content">
                <form id="registerForm" class="auth-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="registerFirstName">Prénom *</label>
                            <input type="text" id="registerFirstName" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="registerLastName">Nom *</label>
                            <input type="text" id="registerLastName" class="form-input" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="registerEmail">Email *</label>
                        <input type="email" id="registerEmail" class="form-input" placeholder="votre@email.com" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="registerPhone">Téléphone</label>
                        <input type="tel" id="registerPhone" class="form-input" placeholder="+213 XX XX XX XX">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="registerPassword">Mot de passe *</label>
                        <input type="password" id="registerPassword" class="form-input" placeholder="Minimum 6 caractères" minlength="6" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="registerConfirmPassword">Confirmer le mot de passe *</label>
                        <input type="password" id="registerConfirmPassword" class="form-input" placeholder="Retapez votre mot de passe" required>
                    </div>
                    <button type="submit" class="auth-submit-btn" id="submitRegister">
                        <i class="fas fa-user-plus"></i> Créer mon compte
                    </button>
                    <div class="auth-links">
                        <a onclick="showTab('login')">Déjà un compte ? Se connecter</a>
                    </div>
                </form>
            </div>
            
            <div class="auth-error" id="authError"></div>

            <!-- Informations de test -->
            
        </div>
    </div>

    <footer class="footer" id="contact">
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
        <li><a href="javascript:void(0)" onclick="navigateToSection('#boutiques'); showShopPage('boutique-jupes')">Boutique Jupes</a></li>
        <li><a href="javascript:void(0)" onclick="navigateToSection('#boutiques'); showShopPage('boutique-foulards')">Boutique Foulards</a></li>
        <li><a href="javascript:void(0)" onclick="navigateToSection('#boutiques'); showShopPage('boutique-robes')">Boutique Robes</a></li>
        <li><a href="javascript:void(0)" onclick="navigateToSection('#boutiques'); showShopPage('boutique-ensembles')">Boutique Ensembles</a></li>
        <li><a href="javascript:void(0)" onclick="navigateToSection('#boutiques'); showShopPage('boutique-hijabs')">Boutique Hijabs</a></li>
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
                <p><i class="fas fa-envelope"></i> contact@mynafashn.dz</p>
                <p><i class="fas fa-map-marker-alt"></i> Alger, Algérie</p>
            </div>
        </div>
        <div class="copyright">
            &copy; 2025 MYNA FASHN. Tous droits réservés.
        </div>
    </footer>

    <script>
        const API_BASE_URL = window.location.origin + 'back/api.php';

        const validPromoCodes = {
            'MYNA10': 10,
            'FASHN15': 15,
            'ALGERIE20': 20
        };

        const algerianWilayas = [
            "Adrar", "Chlef", "Laghouat", "Oum El Bouaghi", "Batna", "Béjaïa", "Biskra", "Béchar", "Blida", "Bouira",
            "Tamanrasset", "Tébessa", "Tlemcen", "Tiaret", "Tizi Ouzou", "Alger", "Djelfa", "Jijel", "Sétif", "Saïda",
            "Skikda", "Sidi Bel Abbès", "Annaba", "Guelma", "Constantine", "Médéa", "Mostaganem", "M'Sila", "Mascara",
            "Ouargla", "Oran", "El Bayadh", "Illizi", "Bordj Bou Arreridj", "Boumerdès", "El Tarf", "Tindouf", "Tissemsilt",
            "El Oued", "Khenchela", "Souk Ahras", "Tipaza", "Mila", "Aïn Defla", "Naâma", "Aïn Témouchent", "Ghardaïa", "Relizane"
        ];

        const shippingOptions = [
            { id: 'bureau', name: 'Livraison au bureau de poste', price: 400, description: 'Retrait dans votre bureau de poste le plus proche' },
            { id: 'domicile', name: 'Livraison à domicile', price: 500, description: 'Livraison directement à votre adresse' }
        ];

        let cart = {
            items: [],
            total: 0,
            count: 0,
            promoCode: null,
            discount: 0,
            shipping: null,
            shippingPrice: 0
        };
     
        // Gestion du menu déroulant
        function setupAuthDropdown() {
            const authToggle = document.getElementById('authToggle');
            const authDropdown = document.getElementById('authDropdown');
            
            authToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                authDropdown.classList.toggle('show');
            });
            
            // Fermer le menu déroulant en cliquant ailleurs
            document.addEventListener('click', function() {
                authDropdown.classList.remove('show');
            });
            
            // Empêcher la fermeture en cliquant dans le menu
            authDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Fonctions d'affichage des modals
        function showAuthModal(tab = 'login') {
            document.getElementById('authModal').style.display = 'flex';
            document.getElementById('authDropdown').classList.remove('show');
            showTab(tab);
        }

        function hideAuthModal() {
            document.getElementById('authModal').style.display = 'none';
            document.getElementById('authError').style.display = 'none';
            document.getElementById('loginForm').reset();
            document.getElementById('registerForm').reset();
        }

        // Gestion des onglets
        function showTab(tabName) {
            // Masquer tous les contenus d'onglets
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Désactiver tous les boutons d'onglets
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Activer l'onglet sélectionné
            document.getElementById(tabName + 'Tab').classList.add('active');
            document.querySelector(`.tab-btn[data-tab="${tabName}"]`).classList.add('active');
            
            // Réinitialiser les erreurs
            document.getElementById('authError').style.display = 'none';
        }

        // Connexion utilisateur
        async function handleLogin(event) {
            event.preventDefault();
            
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            const submitBtn = document.getElementById('submitLogin');
            const errorDiv = document.getElementById('authError');
            
            if (!email || !password) {
                errorDiv.textContent = 'Veuillez remplir tous les champs';
                errorDiv.style.display = 'block';
                return;
            }
            
            submitBtn.innerHTML = '<div class="loading"></div> Connexion...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch('back/api.php?action=customer_login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    localStorage.setItem('mynafashn_user', JSON.stringify(data.data));
                    showNotification('Connexion réussie ! Bienvenue ' + data.data.first_name, 'success');
                    hideAuthModal();
                    checkAuthStatus();
                    
                    // Vérifier si l'utilisateur est admin
                    if (data.data.is_admin) {
                        showNotification('Redirection vers l\'administration...', 'info');
                        // Rediriger vers l'admin après un court délai
                        setTimeout(() => {
                            window.location.href = 'back/admin_dashboard.php?access=admin';
                        }, 1500);
                    }
                    
                    // Pré-remplir le formulaire de commande si l'utilisateur a des informations sauvegardées
                    prefillCheckoutForm(data.data);
                } else {
                    errorDiv.textContent = data.message;
                    errorDiv.style.display = 'block';
                }
            } catch (error) {
                console.error('Erreur de connexion:', error);
                errorDiv.textContent = 'Erreur de connexion. Veuillez réessayer.';
                errorDiv.style.display = 'block';
            } finally {
                submitBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Se connecter';
                submitBtn.disabled = false;
            }
        }

        // Inscription utilisateur
        async function handleRegister(event) {
            event.preventDefault();
            
            const firstName = document.getElementById('registerFirstName').value;
            const lastName = document.getElementById('registerLastName').value;
            const email = document.getElementById('registerEmail').value;
            const phone = document.getElementById('registerPhone').value;
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('registerConfirmPassword').value;
            const submitBtn = document.getElementById('submitRegister');
            const errorDiv = document.getElementById('authError');
            
            // Validation
            if (!firstName || !lastName || !email || !password) {
                errorDiv.textContent = 'Veuillez remplir tous les champs obligatoires';
                errorDiv.style.display = 'block';
                return;
            }
            
            if (password !== confirmPassword) {
                errorDiv.textContent = 'Les mots de passe ne correspondent pas';
                errorDiv.style.display = 'block';
                return;
            }
            
            if (password.length < 6) {
                errorDiv.textContent = 'Le mot de passe doit contenir au moins 6 caractères';
                errorDiv.style.display = 'block';
                return;
            }
            
            submitBtn.innerHTML = '<div class="loading"></div> Création du compte...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch('back/api.php?action=user_register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        first_name: firstName,
                        last_name: lastName,
                        email: email,
                        phone: phone,
                        password: password
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    localStorage.setItem('mynafashn_user', JSON.stringify(data.data));
                    showNotification('Compte créé avec succès ! Bienvenue ' + data.data.first_name, 'success');
                    hideAuthModal();
                    checkAuthStatus();
                } else {
                    errorDiv.textContent = data.message;
                    errorDiv.style.display = 'block';
                }
            } catch (error) {
                console.error('Erreur d\'inscription:', error);
                errorDiv.textContent = 'Erreur lors de la création du compte. Veuillez réessayer.';
                errorDiv.style.display = 'block';
            } finally {
                submitBtn.innerHTML = '<i class="fas fa-user-plus"></i> Créer mon compte';
                submitBtn.disabled = false;
            }
        }

        // Déconnexion utilisateur
        function handleLogout() {
            if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
                localStorage.removeItem('mynafashn_user');
                localStorage.removeItem('mynafashn_user_checkout_data');
                localStorage.removeItem('mynafashn_user_is_admin');
                showNotification('Déconnexion réussie', 'info');
                checkAuthStatus();
                document.getElementById('authDropdown').classList.remove('show');
            }
        }

        // Fonctions de navigation
        function showUserProfile() {
            alert('Fonctionnalité "Mon profil" à implémenter');
            document.getElementById('authDropdown').classList.remove('show');
        }

        function showOrderHistory() {
            alert('Fonctionnalité "Mes commandes" à implémenter');
            document.getElementById('authDropdown').classList.remove('show');
        }

        // Pré-remplir le formulaire de commande avec les infos de l'utilisateur
        function prefillCheckoutForm(user) {
            if (!user) return;
            
            const userData = {
                firstName: user.first_name,
                lastName: user.last_name,
                email: user.email,
                phone: user.phone,
                address: user.address,
                wilaya: user.wilaya
            };
            
            localStorage.setItem('mynafashn_user_checkout_data', JSON.stringify(userData));
        }
        // Fonction pour gérer le clic sur les liens de navigation
function handleNavClick(event, sectionId) {
    event.preventDefault();
    
    // Si nous sommes dans une boutique, revenir à la page principale d'abord
    const isInShop = Array.from(document.querySelectorAll('.shop-page')).some(page => 
        page.style.display === 'block'
    );
    
    if (isInShop) {
        showMainPage();
        
        // Attendre que la page principale soit affichée avant de scroller
        setTimeout(() => {
            scrollToSection(sectionId);
        }, 150);
    } else {
        scrollToSection(sectionId);
    }
}

// Fonction pour scroller vers une section
function scrollToSection(sectionId) {
    const targetSection = document.querySelector(sectionId);
    if (targetSection) {
        targetSection.scrollIntoView({ behavior: 'smooth' });
    }
    
    // Mettre à jour le lien actif en fonction de la section
    updateActiveNavLink(sectionId);
}

// Fonction pour mettre à jour le lien actif
function updateActiveNavLink(sectionId) {
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.classList.remove('active');
    });
    
    const activeLink = document.querySelector(`.nav-links a[href="${sectionId}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', checkAuthStatus);

async function checkAuthStatus() {
    const user = JSON.parse(localStorage.getItem('mynafashn_user'));
    const authDropdown = document.getElementById('authDropdown');
    const authText = document.getElementById('authText');
    const adminAccessLink = document.getElementById('adminAccessLink');
    const adminBadge = document.getElementById('adminBadge');
    const logoutBtn = document.querySelector('.auth-action-btn.logout');

    if (user) {
        document.getElementById('userName').textContent = `${user.first_name} ${user.last_name}`;
        document.getElementById('userEmail').textContent = user.email;

        authDropdown.querySelector('.auth-guest').style.display = 'none';
        authDropdown.querySelector('.auth-customer').style.display = 'block';
        authText.textContent = 'Mon Compte';
        logoutBtn.style.display = 'flex';

        // ✅ SYNCHRONISER LE PANIER APRÈS CONNEXION
        if (user.id) {
            await syncCartOnLogin(user.id);
        }

        const isAdmin = await checkUserAdminStatus(user.id);
        if (isAdmin) {
            adminAccessLink.style.display = 'flex';
            adminBadge.style.display = 'inline-block';
            localStorage.setItem('mynafashn_user_is_admin', 'true');
        } else {
            adminAccessLink.style.display = 'none';
            adminBadge.style.display = 'none';
            localStorage.removeItem('mynafashn_user_is_admin');
        }

    } else {
        authDropdown.querySelector('.auth-guest').style.display = 'block';
        authDropdown.querySelector('.auth-customer').style.display = 'none';
        authText.textContent = 'Mon Compte';
        adminAccessLink.style.display = 'none';
        adminBadge.style.display = 'none';
        logoutBtn.style.display = 'none';
        
        // Charger le panier invité
        loadCart();
    }
}


// Fonction pour interroger l’API
async function checkUserAdminStatus(userId) {
    try {
        const response = await fetch(`back/api.php?action=checkAdminStatus&id=${userId}`);
        const data = await response.json();

        if (data.success && data.data && data.data.is_admin === true) {
            console.log('✅ Utilisateur admin détecté :', data);
            return true;
        } else {
            console.warn('❌ Utilisateur non admin :', data);
            return false;
        }
    } catch (error) {
        console.error('Erreur lors de la vérification admin :', error);
        return false;
    }
}



function handleLogout() {
    if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
        // Créer une nouvelle session pour l'invité
        const newSessionId = 'guest_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('mynafashn_session_id', newSessionId);
        
        localStorage.removeItem('mynafashn_user');
        localStorage.removeItem('mynafashn_user_checkout_data');
        localStorage.removeItem('mynafashn_user_is_admin');
        
        showNotification('Déconnexion réussie', 'info');
        checkAuthStatus();
        document.getElementById('authDropdown').classList.remove('show');
    }
}

// Appel initial
document.addEventListener('DOMContentLoaded', checkAuthStatus);


        // Fonctions existantes (non modifiées)
        function showShopPage(shopId) {
            document.getElementById('main-content').style.display = 'none';
            document.querySelectorAll('.shop-page').forEach(page => {
                page.style.display = 'none';
            });
            const shopPage = document.getElementById(shopId);
            if (shopPage) {
                shopPage.style.display = 'block';
                window.scrollTo(0, 0);
                displayShopProducts(shopId);
            }
        }

        function showMainPage() {
    document.querySelectorAll('.shop-page').forEach(page => {
        page.style.display = 'none';
    });
    document.getElementById('main-content').style.display = 'block';
    window.scrollTo(0, 0);
    
    // Réactiver les liens de navigation
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.classList.remove('active');
    });
    document.querySelector('.nav-links a[onclick="showMainPage()"]').classList.add('active');
}
// Fonction pour naviguer vers une section depuis une boutique
function navigateToSection(sectionId) {
    showMainPage();
    
    // Petit délai pour laisser le temps à la page principale de s'afficher
    setTimeout(() => {
        const targetSection = document.querySelector(sectionId);
        if (targetSection) {
            targetSection.scrollIntoView({ behavior: 'smooth' });
        }
        
        // Mettre à jour l'état actif du menu
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.classList.remove('active');
        });
        
        // Trouver et activer le lien correspondant
        const activeLink = document.querySelector(`.nav-links a[href="${sectionId}"]`);
        if (activeLink) {
            activeLink.classList.add('active');
        }
    }, 100);
}

// Fonction pour afficher les boutiques depuis une boutique
function showBoutiquesFromShop() {
    showMainPage();
    
    setTimeout(() => {
        const boutiquesSection = document.querySelector('#boutiques');
        if (boutiquesSection) {
            boutiquesSection.scrollIntoView({ behavior: 'smooth' });
        }
        
        // Mettre à jour l'état actif du menu
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.classList.remove('active');
        });
        
        const boutiquesLink = document.querySelector('.nav-links a[href="#boutiques"]');
        if (boutiquesLink) {
            boutiquesLink.classList.add('active');
        }
    }, 100);
}

        async function loadProducts(category = null) {
            try {
                let url = `back/api.php?action=get_products`;
                if (category) {
                    url += `&category=${encodeURIComponent(category)}`;
                }
                const response = await fetch(url);
                if (!response.ok) throw new Error(`Erreur HTTP: ${response.status}`);
                const data = await response.json();
                return data.success ? data.data || [] : [];
            } catch (error) {
                console.error('Erreur loadProducts:', error);
                showNotification('Erreur de chargement des produits', 'error');
                return [];
            }
        }

        async function displayNewArrivals() {
            const newArrivalsGrid = document.getElementById('new-arrivals-grid');
            newArrivalsGrid.innerHTML = `<div style="grid-column: 1/-1; text-align: center; padding: 2rem;"><i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary-color);"></i><p>Chargement des nouveautés...</p></div>`;
            
            let products = await loadProducts();
            if (products.length === 0) {
                newArrivalsGrid.innerHTML = `<div style="grid-column: 1/-1; text-align: center; padding: 2rem;"><i class="fas fa-box-open" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i><p style="color: #666; font-size: 1.1rem;">Aucun produit disponible pour le moment</p></div>`;
                return;
            }

            const newProducts = products.sort((a, b) => b.id - a.id).slice(0, 3);
            newArrivalsGrid.innerHTML = newProducts.map(product => createProductHTML(product, true)).join('');
            attachProductEvents();
        }

        async function displayShopProducts(shopId) {
            const category = shopId.replace('boutique-', '');
            const productsGrid = document.getElementById(`${shopId}-grid`);
            if (!productsGrid) return;

            productsGrid.innerHTML = `<div style="grid-column: 1/-1; text-align: center; padding: 2rem;"><i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary-color);"></i><p>Chargement des ${getCategoryName(category)}...</p></div>`;

            let products = await loadProducts(category);
            if (products.length === 0) {
                productsGrid.innerHTML = `<div style="grid-column: 1/-1; text-align: center; padding: 3rem;"><i class="fas fa-tshirt" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i><p style="color: #666; font-size: 1.2rem;">Aucun ${getCategoryName(category)} disponible</p></div>`;
                return;
            }

            productsGrid.innerHTML = products.map(product => createProductHTML(product, false)).join('');
            attachProductEvents();
        }

        function createProductHTML(product, isNewArrival = false) {
            const imageUrl = product.image || `https://via.placeholder.com/300x400/8b4513/ffffff?text=${encodeURIComponent(product.name)}`;
            return `
                <div class="product-card fade-in" data-category="${product.category}">
                    <div class="product-image">
                        <img src="${imageUrl}" alt="${product.name}" onerror="this.src='https://via.placeholder.com/300x400/8b4513/ffffff?text=${encodeURIComponent(product.name.substring(0, 20))}'">
                        ${isNewArrival ? '<div class="product-badge">NOUVEAU</div>' : ''}
                        ${product.original_price && product.original_price > product.price ? '<div class="product-badge">PROMO</div>' : ''}
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">${product.name}</h3>
                        <p class="product-description">${product.description}</p>
                        <div class="product-price">
                            <span class="current-price">${formatPrice(product.price)}</span>
                            ${product.original_price && product.original_price > product.price ? `<span class="original-price">${formatPrice(product.original_price)}</span>` : ''}
                        </div>
                        <div class="product-variants">
                            ${product.sizes && product.sizes.length > 0 && product.sizes[0] !== '' ? `
                                <select class="variant-select size-select" required>
                                    <option value="">Choisir la taille *</option>
                                    ${product.sizes.map(size => `<option value="${size}">${size}</option>`).join('')}
                                </select>
                                <div class="validation-message size-message">Veuillez choisir une taille</div>
                            ` : ''}
                            ${product.colors && product.colors.length > 0 && product.colors[0] !== '' ? `
                                <select class="variant-select color-select" required>
                                    <option value="">Choisir la couleur *</option>
                                    ${product.colors.map(color => `<option value="${color}">${color}</option>`).join('')}
                                </select>
                                <div class="validation-message color-message">Veuillez choisir une couleur</div>
                            ` : ''}
                        </div>
                        <div class="product-actions">
                            <button class="btn btn-primary btn-sm add-to-cart" 
                                    data-id="${product.id}"
                                    data-name="${product.name}"
                                    data-price="${product.price}"
                                    data-image="${imageUrl}"
                                    disabled>
                                <i class="fas fa-shopping-bag"></i> Ajouter
                            </button>
                            ${isNewArrival ? `<button class="btn btn-outline btn-sm view-boutique" onclick="showShopPage('boutique-${product.category}')"><i class="fas fa-store"></i> Voir la boutique</button>` : ''}
                        </div>
                    </div>
                </div>
            `;
        }

        function checkVariantsSelection(productCard) {
            const sizeSelect = productCard.querySelector('.size-select');
            const colorSelect = productCard.querySelector('.color-select');
            const addButton = productCard.querySelector('.add-to-cart');
            let isSizeValid = true;
            let isColorValid = true;
            
            if (sizeSelect) {
                isSizeValid = sizeSelect.value !== '';
                const sizeMessage = productCard.querySelector('.size-message');
                if (sizeMessage) sizeMessage.style.display = isSizeValid ? 'none' : 'block';
            }
            if (colorSelect) {
                isColorValid = colorSelect.value !== '';
                const colorMessage = productCard.querySelector('.color-message');
                if (colorMessage) colorMessage.style.display = isColorValid ? 'none' : 'block';
            }
            addButton.disabled = !(isSizeValid && isColorValid);
        }

        function attachProductEvents() {
            document.querySelectorAll('.variant-select').forEach(select => {
                select.addEventListener('change', function() {
                    const productCard = this.closest('.product-card');
                    checkVariantsSelection(productCard);
                });
            });

            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    if (this.disabled) return;
                    const productCard = this.closest('.product-card');
                    const productId = this.dataset.id;
                    const productName = this.dataset.name;
                    const productPrice = parseFloat(this.dataset.price);
                    const productImage = this.dataset.image;
                    const sizeSelect = productCard.querySelector('.size-select');
                    const colorSelect = productCard.querySelector('.color-select');
                    const size = sizeSelect ? sizeSelect.value : null;
                    const color = colorSelect ? colorSelect.value : null;
                    
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

        function getCategoryName(category) {
            const categoryNames = {
                'jupes': 'jupes', 'robes': 'robes', 'foulards': 'foulards', 'ensembles': 'ensembles', 'hijabs': 'hijabs'
            };
            return categoryNames[category] || 'produits';
        }

        // Fonctions de gestion du panier par utilisateur
function getUserId() {
    const user = JSON.parse(localStorage.getItem('mynafashn_user'));
    return user ? user.id : 'guest';
}
// === FONCTIONS MODIFIÉES POUR BD ===
let currentCartId = null;

async function loadCart() {
    const user = JSON.parse(localStorage.getItem('mynafashn_user'));
    
    try {
        let url = 'back/api.php?action=get_cart';
        if (user && user.id) {
            url += `&customer_id=${user.id}`;
        } else {
            // Pour les invités, utiliser une session temporaire
            let sessionId = localStorage.getItem('mynafashn_session_id');
            if (!sessionId) {
                sessionId = 'guest_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                localStorage.setItem('mynafashn_session_id', sessionId);
            }
            url += `&session_id=${encodeURIComponent(sessionId)}`;
        }

        const response = await fetch(url);
        const data = await response.json();
        
        if (data.success) {
            currentCartId = data.data.cart_id;
            cart.items = data.data.items || [];
            updateCartTotals();
            updateCartUI();
        } else {
            // Fallback au localStorage si erreur
            loadCartFromLocalStorage();
        }
    } catch (error) {
        console.error('Erreur chargement panier BD:', error);
        loadCartFromLocalStorage();
    }
}

async function saveCart() {
    // Sauvegarder en BD ET en localStorage (fallback)
    saveCartToLocalStorage();
    
    if (!currentCartId) return;
    
    try {
        const response = await fetch('back/api.php?action=update_cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                cart_id: currentCartId,
                items: cart.items
            })
        });
        
        const data = await response.json();
        if (!data.success) {
            console.error('Erreur sauvegarde panier BD:', data.message);
        }
    } catch (error) {
        console.error('Erreur sauvegarde panier BD:', error);
    }
}

// Fallback: fonctions localStorage (gardez vos anciennes fonctions)
function loadCartFromLocalStorage() {
    const cartKey = getCartKey();
    const savedCart = localStorage.getItem(cartKey);
    if (savedCart) {
        try {
            const parsedCart = JSON.parse(savedCart);
            cart = { ...cart, ...parsedCart };
            updateCartUI();
        } catch (error) {
            console.error('Erreur chargement panier localStorage:', error);
            resetCart();
        }
    }
}

function saveCartToLocalStorage() {
    const cartKey = getCartKey();
    localStorage.setItem(cartKey, JSON.stringify(cart));
}

function getCartKey() {
    const user = JSON.parse(localStorage.getItem('mynafashn_user'));
    if (user && user.id) {
        return `mynafashnCart_user_${user.id}`;
    } else {
        const sessionId = localStorage.getItem('mynafashn_session_id') || 'guest';
        return `mynafashnCart_${sessionId}`;
    }
}

function resetCart() {
    cart = { 
        items: [], 
        total: 0, 
        count: 0, 
        promoCode: null, 
        discount: 0, 
        shipping: null, 
        shippingPrice: 0 
    };
    updateCartUI();
}

// Synchronisation à la connexion
async function syncCartOnLogin(userId) {
    try {
        // Récupérer le panier invité
        const sessionId = localStorage.getItem('mynafashn_session_id');
        if (sessionId) {
            const response = await fetch(`back/api.php?action=merge_carts&customer_id=${userId}&session_id=${encodeURIComponent(sessionId)}`);
            const data = await response.json();
            
            if (data.success) {
                console.log('🔄 Panier fusionné avec succès');
                // Supprimer la session invité
                localStorage.removeItem('mynafashn_session_id');
            }
        }
        
        // Recharger le panier utilisateur
        loadCart();
    } catch (error) {
        console.error('Erreur synchronisation panier:', error);
        loadCart();
    }
}
function clearUserCart() {
    const cartKey = getCartKey();
    localStorage.removeItem(cartKey);
    cart = { items: [], total: 0, count: 0, promoCode: null, discount: 0, shipping: null, shippingPrice: 0 };
    updateCartUI();
}



function mergeCarts(guestCartJson, userCartJson, userCartKey) {
    try {
        const guestCart = JSON.parse(guestCartJson);
        const userCart = JSON.parse(userCartJson);
        
        // Fusionner les articles
        guestCart.items.forEach(guestItem => {
            const existingItemIndex = userCart.items.findIndex(userItem => 
                userItem.id === guestItem.id && 
                userItem.size === guestItem.size && 
                userItem.color === guestItem.color
            );
            
            if (existingItemIndex !== -1) {
                // Si l'article existe déjà, augmenter la quantité
                userCart.items[existingItemIndex].quantity += guestItem.quantity;
            } else {
                // Sinon, ajouter l'article
                userCart.items.push(guestItem);
            }
        });
        
        // Mettre à jour les totaux
        const subtotal = userCart.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        userCart.count = userCart.items.reduce((sum, item) => sum + item.quantity, 0);
        
        // Appliquer les promotions et frais de livraison de l'utilisateur
        // (on garde les préférences de l'utilisateur connecté)
        
        localStorage.setItem(userCartKey, JSON.stringify(userCart));
        
    } catch (error) {
        console.error('Erreur lors de la fusion des paniers:', error);
    }
}

        function updateCartUI() {
            const cartCount = document.getElementById('cartCount');
            cartCount.textContent = cart.count;
            const cartContent = document.getElementById('cartContent');
            
            if (cart.items.length === 0) {
        cartContent.innerHTML = `<div class="empty-cart"><i class="fas fa-shopping-cart"></i><p>Votre panier est vide.</p><button class="btn btn-primary" onclick="showMainPage(); document.getElementById('cartModal').style.display='none'">Découvrir nos collections</button></div>`;
        updateCartOwnerIndicator();
        return;
    }
            
            let cartHTML = '<div class="cart-items">';
            let subtotal = 0;
            cart.items.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                cartHTML += `
                    <div class="cart-item" data-index="${index}">
                        <img src="${item.image}" alt="${item.name}" onerror="this.src='https://via.placeholder.com/80x80?text=Image'">
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
                            <button class="btn-remove" title="Supprimer"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `;
            });
            cartHTML += '</div>';
            
            cartHTML += `
                <div class="promo-section">
                    <h4>Code Promo</h4>
                    <div class="promo-input-group">
                        <input type="text" class="promo-input" id="promoCodeInput" placeholder="Entrez votre code promo" value="${cart.promoCode || ''}">
                        <button class="promo-btn" onclick="applyPromoCode()">Appliquer</button>
                    </div>
                    <div class="promo-message" id="promoMessage"></div>
                </div>
            `;
            
            const discountAmount = (subtotal * cart.discount) / 100;
            const totalAfterDiscount = subtotal - discountAmount;
            const finalTotal = totalAfterDiscount + cart.shippingPrice;
            
            cartHTML += `
                <div class="cart-total">
                    <div class="summary-item">
                        <span>Sous-total:</span>
                        <span>${formatPrice(subtotal)}</span>
                    </div>
                    ${cart.discount > 0 ? `<div class="summary-item summary-discount"><span>Réduction (${cart.discount}%):</span><span>-${formatPrice(discountAmount)}</span></div>` : ''}
                    <div class="summary-item summary-shipping">
                        <span>Livraison:</span>
                        <span>${cart.shipping ? formatPrice(cart.shippingPrice) : 'À sélectionner'}</span>
                    </div>
                    <div class="summary-total">
                        <span>Total:</span>
                        <span>${formatPrice(finalTotal)}</span>
                    </div>
                </div>
                <div class="cart-actions">
                    <button class="btn btn-outline" id="clearCartBtn">Vider le panier</button>
                    <button class="btn btn-primary" id="checkoutBtn">Passer la commande</button>
                </div>
            `;
            
            cartContent.innerHTML = cartHTML;
            cart.total = finalTotal;
            attachCartEvents();
            updateCartOwnerIndicator();
        }

        function attachCartEvents() {
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
            const clearCartBtn = document.getElementById('clearCartBtn');
            const checkoutBtn = document.getElementById('checkoutBtn');
            if (clearCartBtn) clearCartBtn.addEventListener('click', clearCart);
            if (checkoutBtn) checkoutBtn.addEventListener('click', showCheckoutForm);
        }

        function addToCart(product) {
            const existingItemIndex = cart.items.findIndex(item => item.id === product.id && item.size === product.size && item.color === product.color);
            if (existingItemIndex !== -1) {
                cart.items[existingItemIndex].quantity += product.quantity;
            } else {
                cart.items.push(product);
            }
            updateCartTotals();
            saveCart();
            updateCartUI();
            showNotification(`${product.name} ajouté au panier!`, 'success');
        }

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

        function removeFromCart(index) {
            const removedItem = cart.items[index];
            cart.items.splice(index, 1);
            updateCartTotals();
            saveCart();
            updateCartUI();
            showNotification(`${removedItem.name} retiré du panier`, 'info');
        }

        function clearCart() {
    if (confirm('Êtes-vous sûr de vouloir vider votre panier ?')) {
        cart.items = [];
        cart.promoCode = null;
        cart.discount = 0;
        cart.shipping = null;
        cart.shippingPrice = 0;
        updateCartTotals();
        saveCart();
        updateCartUI();
        showNotification('Panier vidé', 'info');
    }
}
function updateCartOwnerIndicator() {
    const user = JSON.parse(localStorage.getItem('mynafashn_user'));
    const cartContent = document.getElementById('cartContent');
    
    if (cartContent && !cartContent.querySelector('.cart-owner-indicator')) {
        const ownerIndicator = document.createElement('div');
        ownerIndicator.className = 'cart-owner-indicator';
        ownerIndicator.style.cssText = 'text-align: center; padding: 0.5rem; background: var(--light-color); border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem;';
        
        if (user) {
            ownerIndicator.innerHTML = `<i class="fas fa-user-check"></i> Panier de ${user.first_name} ${user.last_name}`;
            ownerIndicator.style.color = 'var(--success-color)';
        } else {
            ownerIndicator.innerHTML = `<i class="fas fa-user-clock"></i> Panier visiteur (connectez-vous pour le sauvegarder)`;
            ownerIndicator.style.color = 'var(--info-color)';
        }
        
        if (cartContent.querySelector('.empty-cart')) {
            cartContent.insertBefore(ownerIndicator, cartContent.querySelector('.empty-cart'));
        } else if (cartContent.querySelector('.cart-items')) {
            cartContent.insertBefore(ownerIndicator, cartContent.querySelector('.cart-items'));
        }
    }
}

        function updateCartTotals() {
            const subtotal = cart.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const discountAmount = (subtotal * cart.discount) / 100;
            const totalAfterDiscount = subtotal - discountAmount;
            cart.total = totalAfterDiscount + cart.shippingPrice;
            cart.count = cart.items.reduce((sum, item) => sum + item.quantity, 0);
        }

        async function applyPromoCode() {
            const promoCodeInput = document.getElementById('promoCodeInput');
            const promoMessage = document.getElementById('promoMessage');
            const code = promoCodeInput.value.trim().toUpperCase();
            
            if (!code) {
                promoMessage.textContent = 'Veuillez entrer un code promo';
                promoMessage.className = 'promo-message promo-error';
                return;
            }
            
            const subtotal = cart.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            
            try {
                const response = await fetch('back/api.php?action=validate_promo_code', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        code: code,
                        order_amount: subtotal
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const promo = data.data;
                    let discountAmount = 0;
                    
                    if (promo.discount_type === 'percentage') {
                        discountAmount = (subtotal * promo.discount_value) / 100;
                        if (promo.max_discount_amount && discountAmount > promo.max_discount_amount) {
                            discountAmount = promo.max_discount_amount;
                        }
                    } else {
                        discountAmount = promo.discount_value;
                    }
                    
                    cart.promoCode = code;
                    cart.discount = promo.discount_type === 'percentage' ? promo.discount_value : 0;
                    cart.discountAmount = discountAmount;
                    
                    updateCartTotals();
                    saveCart();
                    updateCartUI();
                    
                    promoMessage.textContent = `Code promo appliqué ! Réduction de ${formatPrice(discountAmount)}`;
                    promoMessage.className = 'promo-message promo-success';
                    showNotification(`Code promo ${code} appliqué !`, 'success');
                } else {
                    promoMessage.textContent = data.message;
                    promoMessage.className = 'promo-message promo-error';
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                console.error('Erreur:', error);
                promoMessage.textContent = 'Erreur de validation du code promo';
                promoMessage.className = 'promo-message promo-error';
                showNotification('Erreur de validation du code promo', 'error');
            }
        }

        function selectShipping(shippingId) {
            console.log('Sélection livraison:', shippingId);
            const selectedOption = shippingOptions.find(option => option.id === shippingId);
            if (selectedOption) {
                cart.shipping = shippingId;
                cart.shippingPrice = selectedOption.price;
                updateCartTotals();
                saveCart();
                
                // Mettre à jour l'interface
                document.querySelectorAll('.shipping-option').forEach(option => {
                    option.classList.remove('selected');
                });
                
                const selectedElement = document.querySelector(`.shipping-option[onclick*="${shippingId}"]`);
                if (selectedElement) {
                    selectedElement.classList.add('selected');
                }
                
                // Mettre à jour le résumé
                updateCheckoutSummary();
                
                showNotification(`Livraison sélectionnée: ${selectedOption.name}`, 'success');
            }
        }

        function updateCheckoutSummary() {
            const subtotal = cart.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const discountAmount = (subtotal * cart.discount) / 100;
            const totalAfterDiscount = subtotal - discountAmount;
            const finalTotal = totalAfterDiscount + cart.shippingPrice;
            
            const summaryElement = document.querySelector('.checkout-summary');
            if (summaryElement) {
                const selectedShipping = shippingOptions.find(option => option.id === cart.shipping);
                summaryElement.innerHTML = `
                    <h3 class="summary-title">Résumé de votre commande</h3>
                    ${cart.items.map(item => `
                        <div class="summary-item">
                            <span>${item.name} ${item.size ? `(Taille: ${item.size})` : ''} ${item.color ? `(Couleur: ${item.color})` : ''} (x${item.quantity})</span>
                            <span>${formatPrice(item.price * item.quantity)}</span>
                        </div>
                    `).join('')}
                    ${cart.discount > 0 ? `
                        <div class="summary-item summary-discount">
                            <span>Réduction (${cart.discount}%):</span>
                            <span>-${formatPrice(discountAmount)}</span>
                        </div>
                    ` : ''}
                    <div class="summary-item summary-shipping">
                        <span>Livraison:</span>
                        <span>${selectedShipping ? selectedShipping.name + ' - ' + formatPrice(cart.shippingPrice) : 'À sélectionner'}</span>
                    </div>
                    <div class="summary-total">
                        <span>Total:</span>
                        <span>${formatPrice(finalTotal)}</span>
                    </div>
                `;
            }
        }

        function showCheckoutForm() {
            if (cart.items.length === 0) {
                showNotification('Votre panier est vide', 'error');
                return;
            }
            
            const subtotal = cart.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const discountAmount = (subtotal * cart.discount) / 100;
            const totalAfterDiscount = subtotal - discountAmount;
            const finalTotal = totalAfterDiscount + (cart.shippingPrice || 0);
            const selectedShipping = shippingOptions.find(option => option.id === cart.shipping);
            
            const checkoutForm = document.getElementById('checkoutForm');
            checkoutForm.innerHTML = `
                <div class="checkout-summary">
                    <h3 class="summary-title">Résumé de votre commande</h3>
                    ${cart.items.map(item => `
                        <div class="summary-item">
                            <span>${item.name} ${item.size ? `(Taille: ${item.size})` : ''} ${item.color ? `(Couleur: ${item.color})` : ''} (x${item.quantity})</span>
                            <span>${formatPrice(item.price * item.quantity)}</span>
                        </div>
                    `).join('')}
                    ${cart.discount > 0 ? `
                        <div class="summary-item summary-discount">
                            <span>Réduction (${cart.discount}%):</span>
                            <span>-${formatPrice(discountAmount)}</span>
                        </div>
                    ` : ''}
                    <div class="summary-item summary-shipping">
                        <span>Livraison:</span>
                        <span>${selectedShipping ? selectedShipping.name + ' - ' + formatPrice(cart.shippingPrice) : 'À sélectionner'}</span>
                    </div>
                    <div class="summary-total">
                        <span>Total:</span>
                        <span>${formatPrice(finalTotal)}</span>
                    </div>
                </div>
                
                <div class="payment-info">
                    <i class="fas fa-info-circle" style="color: var(--primary-color);"></i>
                    <strong> Paiement à la réception de la commande</strong>
                    <p style="margin-top: 0.5rem; font-size: 0.9rem; color: #666;">
                        Vous payez uniquement lorsque vous recevez votre commande. Aucun paiement en ligne requis.
                    </p>
                </div>
                
                <form id="orderForm">
                    <h3 style="margin-bottom: 1.5rem;">Informations de livraison</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="firstName">Prénom *</label>
                            <input type="text" id="firstName" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="lastName">Nom *</label>
                            <input type="text" id="lastName" class="form-input" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">Email *</label>
                        <input type="email" id="email" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="phone">Téléphone *</label>
                        <input type="tel" id="phone" class="form-input" placeholder="+213 XX XX XX XX" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="wilaya">Wilaya *</label>
                        <select id="wilaya" class="form-select" required>
                            <option value="">Sélectionnez votre wilaya</option>
                            ${algerianWilayas.map(wilaya => `<option value="${wilaya}">${wilaya}</option>`).join('')}
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="address">Adresse complète *</label>
                        <input type="text" id="address" class="form-input" placeholder="Numéro, rue, quartier, commune..." required>
                    </div>
                    
                    <div class="shipping-options">
                        <h4 style="margin-bottom: 1rem;">Options de livraison *</h4>
                        ${shippingOptions.map(option => `
                            <div class="shipping-option ${cart.shipping === option.id ? 'selected' : ''}" onclick="selectShipping('${option.id}')">
                                <div class="shipping-info">
                                    <div style="font-weight: 600;">${option.name}</div>
                                    <div style="font-size: 0.9rem; color: #666;">${option.description}</div>
                                </div>
                                <div class="shipping-price">${formatPrice(option.price)}</div>
                            </div>
                        `).join('')}
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="notes">Notes pour la commande</label>
                        <textarea id="notes" class="form-textarea" placeholder="Informations supplémentaires, préférences de livraison..."></textarea>
                    </div>
                    
                    <div class="form-group" style="margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary" style="width: 100%;" id="submitOrderBtn">
                            <i class="fas fa-check-circle"></i> Confirmer la commande
                        </button>
                    </div>
                </form>
            `;
            
            document.getElementById('checkoutModal').style.display = 'flex';
            
            // Pré-remplir le formulaire avec les données utilisateur si disponibles
            setTimeout(() => {
                const userData = JSON.parse(localStorage.getItem('mynafashn_user_checkout_data') || '{}');
                if (userData.firstName) {
                    document.getElementById('firstName').value = userData.firstName || '';
                    document.getElementById('lastName').value = userData.lastName || '';
                    document.getElementById('email').value = userData.email || '';
                    document.getElementById('phone').value = userData.phone || '';
                    document.getElementById('address').value = userData.address || '';
                    if (userData.wilaya) {
                        document.getElementById('wilaya').value = userData.wilaya;
                    }
                }
            }, 100);
            
            attachCheckoutFormEvents();
        }

        function attachCheckoutFormEvents() {
            document.getElementById('orderForm').addEventListener('submit', function(e) {
                e.preventDefault();
                if (!cart.shipping) {
                    showNotification('Veuillez sélectionner une option de livraison', 'error');
                    return;
                }
                processOrder();
            });
        }

        async function processOrder() {
            const submitBtn = document.getElementById('submitOrderBtn');
            const originalText = submitBtn.innerHTML;
            
            // Afficher le loading
            submitBtn.innerHTML = '<div class="loading"></div> Traitement...';
            submitBtn.disabled = true;
            
            const selectedShipping = shippingOptions.find(option => option.id === cart.shipping);
            
            const formData = {
                customer_name: document.getElementById('firstName').value + ' ' + document.getElementById('lastName').value,
                customer_email: document.getElementById('email').value,
                customer_phone: document.getElementById('phone').value,
                customer_country: document.getElementById('wilaya').value,
                customer_region: document.getElementById('wilaya').value,
                customer_city: document.getElementById('wilaya').value,
                customer_address: document.getElementById('address').value,
                shipping_method: selectedShipping ? selectedShipping.name : '',
                shipping_amount: cart.shippingPrice,
                promo_code: cart.promoCode,
                discount_amount: cart.discountAmount || 0,
                subtotal_amount: cart.items.reduce((sum, item) => sum + (item.price * item.quantity), 0),
                total_amount: cart.total,
                notes: document.getElementById('notes').value,
                items: cart.items.map(item => ({
                    name: item.name,
                    price: item.price,
                    quantity: item.quantity,
                    size: item.size,
                    color: item.color
                }))
            };
            
            // Validation
            if (!formData.customer_name || !formData.customer_email || !formData.customer_phone || 
                !formData.customer_country || !formData.customer_address) {
                showNotification('Veuillez remplir tous les champs obligatoires', 'error');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                return;
            }
            
            try {
                const url = `back/api.php?action=create_order`;
                console.log('🔄 Envoi de la commande à:', url);
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                });
                
                console.log('📡 Statut HTTP:', response.status);
                
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('❌ Réponse d\'erreur:', errorText);
                    throw new Error(`Erreur HTTP ${response.status}: ${response.statusText}`);
                }
                
                const data = await response.json();
                console.log('✅ Réponse API:', data);
                
                if (data.success) {
                    let successMessage = `✅ Commande confirmée! Votre numéro: ${data.data.order_number}`;
                    
                    if (data.data.promo_code) {
                        successMessage += ` | Code promo: ${data.data.promo_code} appliqué (-${formatPrice(data.data.discount_amount)})`;
                    }
                    
                    showNotification(successMessage, 'success');
                    
                    // Fermer les modals et vider le panier
                    document.getElementById('checkoutModal').style.display = 'none';
                    document.getElementById('cartModal').style.display = 'none';
                    clearCart();
                } else {
                    showNotification('❌ Erreur: ' + data.message, 'error');
                }
            } catch (error) {
                console.error('❌ Erreur complète:', error);
                showNotification('❌ Erreur lors de la commande: ' + error.message, 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }

        function formatPrice(price) {
            return new Intl.NumberFormat('fr-DZ', {style: 'currency', currency: 'DZD', minimumFractionDigits: 0}).format(price);
        }

        function showNotification(message, type = 'success') {
            document.querySelectorAll('.notification').forEach(notification => notification.remove());
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `<div class="notification-content"><i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i><span>${message}</span></div>`;
            document.body.appendChild(notification);
            setTimeout(() => notification.style.transform = 'translateX(0)', 10);
            setTimeout(() => {
                notification.style.transform = 'translateX(400px)';
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }

        // Initialisation
        // Initialisation
document.addEventListener('DOMContentLoaded', function() {
    // ✅ CHANGEMENT ICI : Charger le panier selon l'utilisateur connecté
    loadCart();
    displayNewArrivals();
    setupAuthDropdown();
    checkAuthStatus();
    
    // Événements d'authentification
    document.getElementById('closeAuth').addEventListener('click', hideAuthModal);
    document.getElementById('loginForm').addEventListener('submit', handleLogin);
    document.getElementById('registerForm').addEventListener('submit', handleRegister);

    // Gestion des onglets
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            showTab(tabName);
        });
    });
    
    window.addEventListener('scroll', () => {
        const header = document.getElementById('header');
        header.classList.toggle('scrolled', window.scrollY > 100);
    });

    document.getElementById('cartBtn').addEventListener('click', () => {
        document.getElementById('cartModal').style.display = 'flex';
    });

    document.getElementById('closeCart').addEventListener('click', () => {
        document.getElementById('cartModal').style.display = 'none';
    });

    document.getElementById('closeCheckout').addEventListener('click', () => {
        document.getElementById('checkoutModal').style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === document.getElementById('cartModal')) document.getElementById('cartModal').style.display = 'none';
        if (e.target === document.getElementById('checkoutModal')) document.getElementById('checkoutModal').style.display = 'none';
        if (e.target === document.getElementById('authModal')) hideAuthModal();
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            if (this.getAttribute('href') !== '#') {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({behavior: 'smooth'});
            }
        });
    });
});
    </script>
</body>
</html>