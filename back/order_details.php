<?php
// order_details.php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin.php');
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mynafashn";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données.");
}

$order_id = $_GET['id'] ?? 0;

// Récupérer les détails de la commande
$order = [];
$order_items = [];

if ($order_id) {
    // Récupérer la commande
    $sql = "SELECT * FROM orders WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    
    // Récupérer les items de la commande
    $sql = "SELECT * FROM order_items WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order_items = $result->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la Commande - MYNA FASHN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif; 
            background: #f5f5f5; 
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: #8b4513;
            color: white;
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }
        .header h1 {
            margin-bottom: 0.5rem;
        }
        .order-number {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        .promo-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #28a745;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
        }
        .content {
            padding: 2rem;
        }
        .section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background: #fafafa;
        }
        .section-title {
            color: #8b4513;
            margin-bottom: 1rem;
            font-size: 1.3rem;
            border-bottom: 2px solid #8b4513;
            padding-bottom: 0.5rem;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }
        .info-item {
            margin-bottom: 0.5rem;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .info-value {
            color: #333;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        .items-table th,
        .items-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        .items-table th {
            background: #8b4513;
            color: white;
        }
        .items-table tr:hover {
            background: #f9f9f9;
        }
        .summary-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 1rem;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #dee2e6;
        }
        .summary-label {
            font-weight: 600;
            color: #495057;
        }
        .summary-value {
            font-weight: 600;
            color: #212529;
        }
        .discount-row {
            color: #dc3545;
            font-weight: bold;
        }
        .total-row {
            font-size: 1.3rem;
            font-weight: bold;
            color: #8b4513;
            border-bottom: none;
            border-top: 2px solid #8b4513;
            padding-top: 1rem;
            margin-top: 1rem;
        }
        .total-amount {
            font-size: 1.5rem;
            font-weight: bold;
            color: #8b4513;
        }
        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.8rem;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d1ecf1; color: #0c5460; }
        .status-shipped { background: #cce7ff; color: #004085; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .actions {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #e0e0e0;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 0 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: #8b4513;
            color: white;
        }
        .btn-primary:hover {
            background: #654321;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #545b62;
        }
        .btn-print {
            background: #28a745;
            color: white;
        }
        .btn-print:hover {
            background: #218838;
        }
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #ddd;
        }
        .customer-notes {
            background: #fff3cd;
            padding: 1rem;
            border-radius: 5px;
            border-left: 4px solid #ffc107;
            margin-top: 1rem;
        }
        .print-only {
            display: none;
        }
        .promo-highlight {
            background: linear-gradient(135deg, #f0fff0 0%, #e8f5e8 100%);
            border-left: 4px solid #28a745;
        }
        .savings-badge {
            background: #dc3545;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-left: 0.5rem;
        }
        @media print {
            .no-print { display: none; }
            .print-only { display: block; }
            body { background: white; padding: 0; }
            .container { box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <?php if ($order && !empty($order['promo_code'])): ?>
                <div class="promo-badge">
                    <i class="fas fa-tag"></i> Code Promo: <?php echo htmlspecialchars($order['promo_code']); ?>
                </div>
            <?php endif; ?>
            <h1><i class="fas fa-receipt"></i> Détails de la Commande</h1>
            <?php if ($order): ?>
                <div class="order-number">N° <?php echo htmlspecialchars($order['order_number']); ?></div>
            <?php endif; ?>
        </div>

        <div class="content">
            <?php if (!$order): ?>
                <div class="empty-state">
                    <i class="fas fa-exclamation-circle"></i>
                    <h2>Commande non trouvée</h2>
                    <p>La commande que vous recherchez n'existe pas ou a été supprimée.</p>
                    <a href="admin_dashboard.php?access=admin" class="btn btn-primary">Retour au tableau de bord</a>
                </div>
            <?php else: ?>
                <!-- Informations de la commande -->
                <div class="section <?php echo !empty($order['promo_code']) ? 'promo-highlight' : ''; ?>">
                    <h2 class="section-title"><i class="fas fa-info-circle"></i> Informations de la Commande</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Numéro de commande:</span>
                            <span class="info-value"><?php echo htmlspecialchars($order['order_number']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de commande:</span>
                            <span class="info-value"><?php echo date('d/m/Y à H:i', strtotime($order['created_at'])); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Statut:</span>
                            <span class="info-value">
                                <?php 
                                $status_class = 'status-' . $order['status'];
                                $status_text = [
                                    'pending' => 'En attente',
                                    'confirmed' => 'Confirmée',
                                    'shipped' => 'Expédiée',
                                    'delivered' => 'Livrée',
                                    'cancelled' => 'Annulée'
                                ];
                                ?>
                                <span class="status-badge <?php echo $status_class; ?>">
                                    <?php echo $status_text[$order['status']] ?? $order['status']; ?>
                                </span>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Code Promo:</span>
                            <span class="info-value">
                                <?php if (!empty($order['promo_code'])): ?>
                                    <span style="color: #28a745; font-weight: bold;">
                                        <i class="fas fa-tag"></i> <?php echo htmlspecialchars($order['promo_code']); ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color: #6c757d;">Aucun</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Informations du client -->
                <div class="section">
                    <h2 class="section-title"><i class="fas fa-user"></i> Informations du Client</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Nom complet:</span>
                            <span class="info-value"><?php echo htmlspecialchars($order['customer_name']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Téléphone:</span>
                            <span class="info-value"><?php echo htmlspecialchars($order['customer_phone']); ?></span>
                        </div>
                        <?php if ($order['customer_email']): ?>
                        <div class="info-item">
                            <span class="info-label">Email:</span>
                            <span class="info-value"><?php echo htmlspecialchars($order['customer_email']); ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="info-item">
                            <span class="info-label">Pays:</span>
                            <span class="info-value"><?php echo htmlspecialchars($order['customer_country']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Région:</span>
                            <span class="info-value"><?php echo htmlspecialchars($order['customer_region']); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Ville:</span>
                            <span class="info-value"><?php echo htmlspecialchars($order['customer_city']); ?></span>
                        </div>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Adresse complète:</span>
                        <span class="info-value"><?php echo htmlspecialchars($order['customer_address']); ?></span>
                    </div>
                </div>

                <!-- Articles de la commande -->
                <div class="section">
                    <h2 class="section-title"><i class="fas fa-shopping-bag"></i> Articles Commandés</h2>
                    <?php if (count($order_items) > 0): ?>
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    <th>Taille</th>
                                    <th>Couleur</th>
                                    <th>Sous-total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $subtotal = 0;
                                foreach ($order_items as $item): 
                                    $item_subtotal = $item['product_price'] * $item['quantity'];
                                    $subtotal += $item_subtotal;
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                    <td><?php echo number_format($item['product_price'], 0, ',', ' '); ?> DA</td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo htmlspecialchars($item['size'] ?: '-'); ?></td>
                                    <td><?php echo htmlspecialchars($item['color'] ?: '-'); ?></td>
                                    <td><?php echo number_format($item_subtotal, 0, ',', ' '); ?> DA</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                        <!-- Résumé financier avec code promo -->
                        <div class="summary-section">
                            <h3 style="color: #8b4513; margin-bottom: 1rem; border-bottom: 1px solid #dee2e6; padding-bottom: 0.5rem;">
                                <i class="fas fa-calculator"></i> Résumé Financier
                            </h3>
                            
                            <div class="summary-row">
                                <span class="summary-label">Sous-total:</span>
                                <span class="summary-value"><?php echo number_format($subtotal, 0, ',', ' '); ?> DA</span>
                            </div>
                            
                            <?php if (!empty($order['promo_code']) && $order['discount_amount'] > 0): ?>
                            <div class="summary-row discount-row">
                                <span class="summary-label">
                                    Réduction 
                                    <?php if (!empty($order['promo_code'])): ?>
                                        (<?php echo htmlspecialchars($order['promo_code']); ?>)
                                    <?php endif; ?>
                                    :
                                </span>
                                <span class="summary-value">
                                    -<?php echo number_format($order['discount_amount'], 0, ',', ' '); ?> DA
                                    <span class="savings-badge">ÉCONOMISÉ</span>
                                </span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="summary-row">
                                <span class="summary-label">Frais de livraison:</span>
                                <span class="summary-value"><?php echo number_format($order['shipping_amount'], 0, ',', ' '); ?> DA</span>
                            </div>
                            
                            <div class="summary-row total-row">
                                <span class="summary-label">Total final:</span>
                                <span class="summary-value total-amount">
                                    <?php echo number_format($order['total_amount'], 0, ',', ' '); ?> DA
                                </span>
                            </div>

                            <?php if (!empty($order['promo_code']) && $order['discount_amount'] > 0): ?>
                            <div style="text-align: center; margin-top: 1rem; padding: 0.5rem; background: #d4edda; border-radius: 5px;">
                                <i class="fas fa-gift" style="color: #28a745;"></i>
                                <strong style="color: #155724;">
                                    Le client a économisé <?php echo number_format($order['discount_amount'], 0, ',', ' '); ?> DA grâce au code promo !
                                </strong>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <p>Aucun article dans cette commande.</p>
                    <?php endif; ?>
                </div>

                <!-- Notes supplémentaires -->
                <?php if ($order['notes']): ?>
                <div class="section">
                    <h2 class="section-title"><i class="fas fa-sticky-note"></i> Notes du Client</h2>
                    <div class="customer-notes">
                        <?php echo nl2br(htmlspecialchars($order['notes'])); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Actions -->
                <div class="actions no-print">
                    <button onclick="window.print()" class="btn btn-print">
                        <i class="fas fa-print"></i> Imprimer
                    </button>
                    <a href="admin_dashboard.php?access=admin" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <a href="admin_dashboard.php?access=admin" class="btn btn-primary">
                        <i class="fas fa-tachometer-alt"></i> Tableau de bord
                    </a>
                </div>

                <!-- Version imprimable -->
                <div class="print-only">
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <h2>MYNA FASHN - Facture</h2>
                        <p>Commande N°: <?php echo htmlspecialchars($order['order_number']); ?></p>
                        <p>Date: <?php echo date('d/m/Y', strtotime($order['created_at'])); ?></p>
                        <?php if (!empty($order['promo_code'])): ?>
                            <p style="color: #28a745; font-weight: bold;">
                                Code Promo: <?php echo htmlspecialchars($order['promo_code']); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function updateOrderStatus(orderId, status) {
            if (confirm('Êtes-vous sûr de vouloir modifier le statut de cette commande ?')) {
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
                        alert('Statut mis à jour avec succès');
                        location.reload();
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la mise à jour');
                });
            }
        }

        // Fonction d'impression améliorée
        function printOrder() {
            window.print();
        }

        // Animation pour les badges promo
        document.addEventListener('DOMContentLoaded', function() {
            const promoBadge = document.querySelector('.promo-badge');
            if (promoBadge) {
                promoBadge.style.transform = 'scale(0)';
                setTimeout(() => {
                    promoBadge.style.transition = 'transform 0.5s ease';
                    promoBadge.style.transform = 'scale(1)';
                }, 300);
            }
        });
    </script>
</body>
</html>