<?php
// api.php - version corrigée et unifiée
require_once '../config/config.php'; // doit définir class Config::connect() renvoyant un PDO

// Headers CORS + JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Preflight CORS
    http_response_code(200);
    exit;
}

/**
 * Helper: read JSON body
 */
function getJsonInput() {
    $input = file_get_contents('php://input');
    if (!$input) return [];
    $data = json_decode($input, true);
    return is_array($data) ? $data : [];
}
function findOrCreateCart($pdo, $customer_id, $session_id) {
    // Chercher un panier existant
    if ($customer_id) {
        $stmt = $pdo->prepare("SELECT * FROM carts WHERE customer_id = ?");
        $stmt->execute([$customer_id]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM carts WHERE session_id = ?");
        $stmt->execute([$session_id]);
    }
    
    $cart = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$cart) {
        // Créer un nouveau panier
        $stmt = $pdo->prepare("INSERT INTO carts (customer_id, session_id) VALUES (?, ?)");
        $stmt->execute([$customer_id, $session_id]);
        $cart_id = $pdo->lastInsertId();
        
        $stmt = $pdo->prepare("SELECT * FROM carts WHERE id = ?");
        $stmt->execute([$cart_id]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    return $cart;
}

function getCartItems($pdo, $cart_id) {
    $stmt = $pdo->prepare("
        SELECT ci.*, p.name, p.price, p.image 
        FROM cart_items ci 
        JOIN products p ON ci.product_id = p.id 
        WHERE ci.cart_id = ?
    ");
    $stmt->execute([$cart_id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Formater pour le frontend
    return array_map(function($item) {
        return [
            'id' => $item['product_id'],
            'name' => $item['name'],
            'price' => floatval($item['price']),
            'quantity' => intval($item['quantity']),
            'size' => $item['size'],
            'color' => $item['color'],
            'image' => normalizeImagePath($item['image'])
        ];
    }, $items);
}

function findCartBySession($pdo, $session_id) {
    $stmt = $pdo->prepare("SELECT * FROM carts WHERE session_id = ?");
    $stmt->execute([$session_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function mergeCartItems($pdo, $source_cart_id, $target_cart_id) {
    // Récupérer les items du panier source
    $stmt = $pdo->prepare("SELECT * FROM cart_items WHERE cart_id = ?");
    $stmt->execute([$source_cart_id]);
    $source_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($source_items as $item) {
        // Vérifier si l'article existe déjà dans le panier cible
        $stmt = $pdo->prepare("SELECT * FROM cart_items WHERE cart_id = ? AND product_id = ? AND size = ? AND color = ?");
        $stmt->execute([$target_cart_id, $item['product_id'], $item['size'], $item['color']]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existing) {
            // Mettre à jour la quantité
            $stmt = $pdo->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE id = ?");
            $stmt->execute([$item['quantity'], $existing['id']]);
        } else {
            // Ajouter nouvel item
            $stmt = $pdo->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, size, color) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$target_cart_id, $item['product_id'], $item['quantity'], $item['size'], $item['color']]);
        }
    }
}
/**
 * Simple sanitizer for ints
 */
function intValOrNull($v) {
    if ($v === null) return null;
    $i = intval($v);
    return $i > 0 ? $i : null;
}

class API {
    private $pdo;

    public function __construct() {
        $this->pdo = Config::connect();
        // Ensure PDO throws exceptions
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // --------------------
    // Responses
    // --------------------
    public function sendResponse($success, $message, $data = null, $httpCode = 200) {
        http_response_code($httpCode);
        $payload = ['success' => (bool)$success, 'message' => $message];
        if ($data !== null) $payload['data'] = $data;
        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // --------------------
    // PRODUCTS
    // --------------------
    public function getProducts($category = null) {
        try {
            if ($category !== null && $category !== 'null' && $category !== '') {
                $stmt = $this->pdo->prepare("SELECT * FROM products WHERE category = ? ORDER BY created_at DESC");
                $stmt->execute([$category]);
            } else {
                $stmt = $this->pdo->query("SELECT * FROM products ORDER BY created_at DESC");
            }
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($products as &$p) {
                $p['image'] = normalizeImagePath($p['image']);
                $p['sizes'] = !empty($p['sizes']) ? json_decode($p['sizes'], true) : [];
                $p['colors'] = !empty($p['colors']) ? json_decode($p['colors'], true) : [];
            }
            $this->sendResponse(true, 'Produits récupérés', $products);
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur getProducts: ' . $e->getMessage(), null, 500);
        }
    }

    public function getProduct($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $p = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$p) $this->sendResponse(false, 'Produit non trouvé', null, 404);
            $p['image'] = normalizeImagePath($p['image']);
            $p['sizes'] = !empty($p['sizes']) ? json_decode($p['sizes'], true) : [];
            $p['colors'] = !empty($p['colors']) ? json_decode($p['colors'], true) : [];
            $this->sendResponse(true, 'Produit récupéré', $p);
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur getProduct: ' . $e->getMessage(), null, 500);
        }
    }

    public function createProduct() {
        try {
            // support JSON body or multipart/form-data
            $data = getJsonInput();
            $isMultipart = !empty($_POST);

            $name = $isMultipart ? ($_POST['name'] ?? '') : ($data['name'] ?? '');
            $description = $isMultipart ? ($_POST['description'] ?? '') : ($data['description'] ?? '');
            $price = $isMultipart ? ($_POST['price'] ?? 0) : ($data['price'] ?? 0);
            $original_price = $isMultipart ? ($_POST['original_price'] ?? null) : ($data['original_price'] ?? null);
            $category = $isMultipart ? ($_POST['category'] ?? '') : ($data['category'] ?? '');
            $stock = $isMultipart ? ($_POST['stock'] ?? 0) : ($data['stock'] ?? 0);

            // sizes/colors: accept JSON array or comma-separated string
            $sizesRaw = $isMultipart ? ($_POST['sizes'] ?? '[]') : ($data['sizes'] ?? '[]');
            $colorsRaw = $isMultipart ? ($_POST['colors'] ?? '[]') : ($data['colors'] ?? '[]');

            $sizes = $this->normalizeArrayField($sizesRaw);
            $colors = $this->normalizeArrayField($colorsRaw);

            // image
            $imagePath = '';
            if ($isMultipart && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = $this->handleImageUpload($_FILES['image']);
                if (!$imagePath) $this->sendResponse(false, "Erreur upload image", null, 400);
            } else {
                $imagePath = $data['image'] ?? '';
            }

            if (empty($name) || empty($category) || empty($imagePath)) {
                $this->sendResponse(false, 'Champs obligatoires manquants (name, category, image).', null, 400);
            }

            $stmt = $this->pdo->prepare("INSERT INTO products (name, description, price, original_price, category, image, sizes, colors, stock) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $name,
                $description,
                $price,
                $original_price,
                $category,
                $imagePath,
                json_encode($sizes, JSON_UNESCAPED_UNICODE),
                json_encode($colors, JSON_UNESCAPED_UNICODE),
                intval($stock)
            ]);
            $this->sendResponse(true, 'Produit créé', ['id' => $this->pdo->lastInsertId()]);
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur createProduct: ' . $e->getMessage(), null, 500);
        }
    }

    public function updateProduct($id) {
        try {
            $data = getJsonInput();
            $isMultipart = !empty($_POST);

            // Read fields either from $_POST (multipart) or JSON body
            $name = $isMultipart ? ($_POST['name'] ?? null) : ($data['name'] ?? null);
            $description = $isMultipart ? ($_POST['description'] ?? null) : ($data['description'] ?? null);
            $price = $isMultipart ? ($_POST['price'] ?? null) : ($data['price'] ?? null);
            $original_price = $isMultipart ? ($_POST['original_price'] ?? null) : ($data['original_price'] ?? null);
            $category = $isMultipart ? ($_POST['category'] ?? null) : ($data['category'] ?? null);
            $stock = $isMultipart ? ($_POST['stock'] ?? null) : ($data['stock'] ?? null);

            $sizesRaw = $isMultipart ? ($_POST['sizes'] ?? null) : ($data['sizes'] ?? null);
            $colorsRaw = $isMultipart ? ($_POST['colors'] ?? null) : ($data['colors'] ?? null);

            $imagePath = null;
            if ($isMultipart && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = $this->handleImageUpload($_FILES['image']);
            } elseif (isset($data['image'])) {
                $imagePath = $data['image'];
            }

            $updateFields = [];
            $params = [];

            if ($name !== null) { $updateFields[] = "name = ?"; $params[] = $name; }
            if ($description !== null) { $updateFields[] = "description = ?"; $params[] = $description; }
            if ($price !== null) { $updateFields[] = "price = ?"; $params[] = $price; }
            if ($original_price !== null) { $updateFields[] = "original_price = ?"; $params[] = $original_price; }
            if ($category !== null) { $updateFields[] = "category = ?"; $params[] = $category; }
            if ($stock !== null) { $updateFields[] = "stock = ?"; $params[] = intval($stock); }

            if ($sizesRaw !== null) {
                $sizes = $this->normalizeArrayField($sizesRaw);
                $updateFields[] = "sizes = ?";
                $params[] = json_encode($sizes, JSON_UNESCAPED_UNICODE);
            }
            if ($colorsRaw !== null) {
                $colors = $this->normalizeArrayField($colorsRaw);
                $updateFields[] = "colors = ?";
                $params[] = json_encode($colors, JSON_UNESCAPED_UNICODE);
            }
            if ($imagePath !== null) {
                $updateFields[] = "image = ?";
                $params[] = $imagePath;
            }

            if (count($updateFields) === 0) $this->sendResponse(false, 'Aucune donnée fournie pour mise à jour', null, 400);

            $params[] = $id;
            $sql = "UPDATE products SET " . implode(', ', $updateFields) . " WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            if ($stmt->rowCount() > 0) $this->sendResponse(true, 'Produit mis à jour');
            else $this->sendResponse(false, 'Aucune modification effectuée (ou produit introuvable)');
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur updateProduct: ' . $e->getMessage(), null, 500);
        }
    }

    public function deleteProduct($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$id]);
            if ($stmt->rowCount() > 0) $this->sendResponse(true, 'Produit supprimé');
            else $this->sendResponse(false, 'Produit non trouvé', null, 404);
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur deleteProduct: ' . $e->getMessage(), null, 500);
        }
    }

    // --------------------
    // ORDERS
    // --------------------
    public function createOrder() {
        $input = getJsonInput();
        if (!$input) $this->sendResponse(false, 'Données JSON invalides', null, 400);

        try {
            $this->pdo->beginTransaction();

            // generate order number
            $orderNumber = 'CMD-' . date('Ymd-His') . '-' . rand(1000,9999);

            $subtotal = 0;
            if (!empty($input['items']) && is_array($input['items'])) {
                foreach ($input['items'] as $it) {
                    $subtotal += (float)($it['price'] ?? 0) * intval($it['quantity'] ?? 1);
                }
            }

            $promoCode = $input['promo_code'] ?? null;
            $discountAmount = 0;
            $shippingAmount = floatval($input['shipping_amount'] ?? 0);

            if ($promoCode) {
                $validation = $this->validatePromoCode($promoCode, $input['customer_email'] ?? null, $subtotal);
                if ($validation['success']) {
                    $promoData = $validation['data'];
                    if ($promoData['discount_type'] === 'percentage') {
                        $discountAmount = ($subtotal * $promoData['discount_value']) / 100;
                        if (!empty($promoData['max_discount_amount']) && $discountAmount > $promoData['max_discount_amount']) {
                            $discountAmount = $promoData['max_discount_amount'];
                        }
                    } else {
                        $discountAmount = $promoData['discount_value'];
                    }
                } else {
                    // invalid promo -> ignore
                    $promoCode = null;
                    $discountAmount = 0;
                }
            }

            $totalAmount = $subtotal - $discountAmount + $shippingAmount;

            $stmt = $this->pdo->prepare("INSERT INTO orders (order_number, customer_name, customer_email, customer_phone, customer_address, customer_country, customer_region, customer_city, notes, subtotal_amount, discount_amount, shipping_amount, total_amount, promo_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $orderNumber,
                $input['customer_name'] ?? '',
                $input['customer_email'] ?? '',
                $input['customer_phone'] ?? '',
                $input['customer_address'] ?? '',
                $input['customer_country'] ?? 'Algérie',
                $input['customer_region'] ?? '',
                $input['customer_city'] ?? '',
                $input['notes'] ?? '',
                $subtotal,
                $discountAmount,
                $shippingAmount,
                $totalAmount,
                $promoCode
            ]);
            $orderId = $this->pdo->lastInsertId();

            if (!empty($input['items']) && is_array($input['items'])) {
                $stmtItem = $this->pdo->prepare("INSERT INTO order_items (order_id, product_name, product_price, quantity, size, color) VALUES (?, ?, ?, ?, ?, ?)");
                foreach ($input['items'] as $it) {
                    $stmtItem->execute([
                        $orderId,
                        $it['name'] ?? '',
                        $it['price'] ?? 0,
                        $it['quantity'] ?? 1,
                        $it['size'] ?? '',
                        $it['color'] ?? ''
                    ]);
                }
            }

            if ($promoCode && $discountAmount > 0) {
                $this->recordPromoCodeUsage($promoCode, $orderId, $input['customer_email'] ?? null);
            }

            $this->pdo->commit();

            $this->sendResponse(true, 'Commande créée', [
                'order_id' => $orderId,
                'order_number' => $orderNumber,
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount
            ]);
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            $this->sendResponse(false, 'Erreur createOrder: ' . $e->getMessage(), null, 500);
        }
    }

    public function getOrders() {
        try {
            $stmt = $this->pdo->query("SELECT o.*, COUNT(oi.id) AS items_count FROM orders o LEFT JOIN order_items oi ON o.id = oi.order_id GROUP BY o.id ORDER BY o.created_at DESC");
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->sendResponse(true, 'Commandes récupérées', $orders);
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur getOrders: ' . $e->getMessage(), null, 500);
        }
    }

    public function getOrder($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = ?");
            $stmt->execute([$id]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$order) $this->sendResponse(false, 'Commande non trouvée', null, 404);
            $stmt2 = $this->pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
            $stmt2->execute([$id]);
            $order['items'] = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            $this->sendResponse(true, 'Commande récupérée', $order);
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur getOrder: ' . $e->getMessage(), null, 500);
        }
    }

    public function updateOrderStatus($id) {
        $input = getJsonInput();
        $status = $input['status'] ?? null;
        $allowed = ['pending','confirmed','shipped','delivered','cancelled'];
        if (!$status || !in_array($status, $allowed)) $this->sendResponse(false, 'Statut invalide', null, 400);
        try {
            $stmt = $this->pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            $this->sendResponse(true, 'Statut mis à jour');
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur updateOrderStatus: ' . $e->getMessage(), null, 500);
        }
    }

    // --------------------
    // PROMO CODES
    // --------------------
    public function getPromoCodes() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM promo_codes ORDER BY created_at DESC");
            $codes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->sendResponse(true, 'Codes promo', $codes);
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur getPromoCodes: ' . $e->getMessage(), null, 500);
        }
    }

    public function getPromoCode($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM promo_codes WHERE id = ?");
            $stmt->execute([$id]);
            $code = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$code) $this->sendResponse(false, 'Code promo non trouvé', null, 404);
            $this->sendResponse(true, 'Code promo récupéré', $code);
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur getPromoCode: ' . $e->getMessage(), null, 500);
        }
    }

    public function addPromoCode() {
        $input = getJsonInput();
        try {
            $stmt = $this->pdo->prepare("INSERT INTO promo_codes (code, description, discount_type, discount_value, min_order_amount, max_discount_amount, usage_limit, start_date, end_date, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $input['code'] ?? '',
                $input['description'] ?? '',
                $input['discount_type'] ?? 'percentage',
                $input['discount_value'] ?? 0,
                $input['min_order_amount'] ?? 0,
                $input['max_discount_amount'] ?? null,
                $input['usage_limit'] ?? null,
                $input['start_date'] ?? null,
                $input['end_date'] ?? null,
                isset($input['is_active']) ? (bool)$input['is_active'] : true
            ]);
            $this->sendResponse(true, 'Code promo ajouté', ['id' => $this->pdo->lastInsertId()]);
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur addPromoCode: ' . $e->getMessage(), null, 500);
        }
    }

    public function updatePromoCode($id) {
        $input = getJsonInput();
        try {
            $stmt = $this->pdo->prepare("UPDATE promo_codes SET code = ?, description = ?, discount_type = ?, discount_value = ?, min_order_amount = ?, max_discount_amount = ?, usage_limit = ?, start_date = ?, end_date = ?, is_active = ? WHERE id = ?");
            $stmt->execute([
                $input['code'] ?? '',
                $input['description'] ?? '',
                $input['discount_type'] ?? 'percentage',
                $input['discount_value'] ?? 0,
                $input['min_order_amount'] ?? 0,
                $input['max_discount_amount'] ?? null,
                $input['usage_limit'] ?? null,
                $input['start_date'] ?? null,
                $input['end_date'] ?? null,
                isset($input['is_active']) ? (bool)$input['is_active'] : true,
                $id
            ]);
            $this->sendResponse(true, 'Code promo mis à jour');
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur updatePromoCode: ' . $e->getMessage(), null, 500);
        }
    }

    public function deletePromoCode($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM promo_codes WHERE id = ?");
            $stmt->execute([$id]);
            if ($stmt->rowCount() > 0) $this->sendResponse(true, 'Code promo supprimé');
            else $this->sendResponse(false, 'Code promo non trouvé', null, 404);
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur deletePromoCode: ' . $e->getMessage(), null, 500);
        }
    }

    // validate promo (public)
    public function validatePromoCodePublic() {
        $input = getJsonInput();
        $code = $input['code'] ?? '';
        $email = $input['email'] ?? null;
        $orderAmount = floatval($input['order_amount'] ?? 0);
        $res = $this->validatePromoCode($code, $email, $orderAmount);
        if ($res['success']) $this->sendResponse(true, 'Code valide', $res['data']);
        else $this->sendResponse(false, $res['message']);
    }

    // internal validation helper
    private function validatePromoCode($code, $email = null, $orderAmount = 0) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM promo_codes WHERE code = ? AND is_active = TRUE AND (start_date IS NULL OR start_date <= NOW()) AND (end_date IS NULL OR end_date >= NOW())");
            $stmt->execute([$code]);
            $promo = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$promo) return ['success' => false, 'message' => 'Code invalide ou expiré'];

            if (!empty($promo['usage_limit']) && $promo['used_count'] >= $promo['usage_limit']) return ['success' => false, 'message' => 'Limite d\'utilisation atteinte'];
            if ($orderAmount < floatval($promo['min_order_amount'])) return ['success' => false, 'message' => 'Montant minimum non atteint'];

            if ($email) {
                $stmt2 = $this->pdo->prepare("SELECT COUNT(*) as usage_count FROM promo_code_usage pcu JOIN orders o ON pcu.order_id = o.id WHERE pcu.promo_code_id = ? AND o.customer_email = ?");
                $stmt2->execute([$promo['id'], $email]);
                $usage = $stmt2->fetch(PDO::FETCH_ASSOC);
                if (!empty($usage['usage_count']) && $usage['usage_count'] > 0) return ['success' => false, 'message' => 'Vous avez déjà utilisé ce code'];
            }

            return ['success' => true, 'data' => [
                'id' => $promo['id'],
                'code' => $promo['code'],
                'discount_type' => $promo['discount_type'],
                'discount_value' => floatval($promo['discount_value']),
                'max_discount_amount' => $promo['max_discount_amount']
            ]];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erreur validatePromoCode: ' . $e->getMessage()];
        }
    }

    private function recordPromoCodeUsage($code, $orderId, $email = null) {
        try {
            // increment used_count
            $stmt = $this->pdo->prepare("UPDATE promo_codes SET used_count = used_count + 1 WHERE code = ?");
            $stmt->execute([$code]);

            // insert into usage table
            $stmt2 = $this->pdo->prepare("INSERT INTO promo_code_usage (promo_code_id, order_id, customer_email) SELECT id, ?, ? FROM promo_codes WHERE code = ?");
            $stmt2->execute([$orderId, $email, $code]);
            return true;
        } catch (PDOException $e) {
            error_log("Erreur recordPromoCodeUsage: " . $e->getMessage());
            return false;
        }
    }

    // --------------------
    // CUSTOMERS
    // --------------------
    public function customerRegister() {
        $input = getJsonInput();
        $first = trim($input['first_name'] ?? '');
        $last = trim($input['last_name'] ?? '');
        $email = trim($input['email'] ?? '');
        $phone = trim($input['phone'] ?? '');
        $password = $input['password'] ?? '';

        if (!$first || !$last || !$email || !$password) $this->sendResponse(false, 'Champs obligatoires manquants', null, 400);
        if (strlen($password) < 6) $this->sendResponse(false, 'Mot de passe trop court', null, 400);

        try {
            $stmt = $this->pdo->prepare("SELECT id FROM customers WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) $this->sendResponse(false, 'Email déjà utilisé', null, 409);

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt2 = $this->pdo->prepare("INSERT INTO customers (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
            $stmt2->execute([$first, $last, $email, $phone, $hash]);
            $id = $this->pdo->lastInsertId();

            $stmt3 = $this->pdo->prepare("SELECT id, first_name, last_name, email, phone, address, wilaya, is_admin FROM customers WHERE id = ?");
            $stmt3->execute([$id]);
            $customer = $stmt3->fetch(PDO::FETCH_ASSOC);
            if ($customer) {
                // remove password
                unset($customer['password']);
                $this->sendResponse(true, 'Compte créé', $customer);
            } else {
                $this->sendResponse(false, 'Erreur récupération client après création', null, 500);
            }
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur customerRegister: ' . $e->getMessage(), null, 500);
        }
    }

    public function customerLogin() {
        $input = getJsonInput();
        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';
        if (!$email || !$password) $this->sendResponse(false, 'Email et mot de passe requis', null, 400);

        try {
            $stmt = $this->pdo->prepare("SELECT id, first_name, last_name, email, phone, password, address, wilaya, is_admin FROM customers WHERE email = ?");
            $stmt->execute([$email]);
            $c = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($c && password_verify($password, $c['password'])) {
                unset($c['password']);
                // Optionally start session and mark admin session if admin login via backend session-based auth is desired
                // session_start(); if ($c['is_admin']) $_SESSION['admin_logged_in'] = true;
                $this->sendResponse(true, 'Connexion réussie', $c);
            } else {
                $this->sendResponse(false, 'Email ou mot de passe incorrect', null, 401);
            }
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur customerLogin: ' . $e->getMessage(), null, 500);
        }
    }

    public function getCustomerProfile($customerId) {
        try {
            $stmt = $this->pdo->prepare("SELECT id, first_name, last_name, email, phone, address, wilaya, is_admin FROM customers WHERE id = ?");
            $stmt->execute([$customerId]);
            $c = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($c) $this->sendResponse(true, 'Profil récupéré', $c);
            else $this->sendResponse(false, 'Client non trouvé', null, 404);
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur getCustomerProfile: ' . $e->getMessage(), null, 500);
        }
    }

    public function updateCustomerProfile() {
        $input = getJsonInput();
        $id = $input['id'] ?? null;
        if (!$id) $this->sendResponse(false, 'ID client manquant', null, 400);

        try {
            $stmt = $this->pdo->prepare("UPDATE customers SET first_name = ?, last_name = ?, phone = ?, address = ?, wilaya = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([
                $input['first_name'] ?? '',
                $input['last_name'] ?? '',
                $input['phone'] ?? '',
                $input['address'] ?? '',
                $input['wilaya'] ?? '',
                $id
            ]);
            if ($stmt->rowCount() > 0) $this->sendResponse(true, 'Profil mis à jour');
            else $this->sendResponse(false, 'Aucune modification effectuée');
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur updateCustomerProfile: ' . $e->getMessage(), null, 500);
        }
    }

    // Public helper - get user info by id
    public function getUserInfo($customerId) {
        return $this->getCustomerProfile($customerId);
    }

    // --------------------
    // ADMIN helpers
    // --------------------
    public function checkAdminStatus($customerId) {
        try {
            $stmt = $this->pdo->prepare("SELECT is_admin FROM customers WHERE id = ?");
            $stmt->execute([$customerId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) $this->sendResponse(false, 'Client non trouvé', null, 404);
            $is_admin = (bool)$row['is_admin'];
            $this->sendResponse(true, 'Statut admin', ['is_admin' => $is_admin]);
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur checkAdminStatus: ' . $e->getMessage(), null, 500);
        }
    }

    // promote/demote - require session admin
    private function requireAdminSession() {
        session_start();
        if (empty($_SESSION['admin_logged_in']) && empty($_SESSION['admin'])) {
            $this->sendResponse(false, 'Accès non autorisé (admin requis)', null, 403);
        }
    }

    public function promoteToAdmin($customerId) {
        $this->requireAdminSession();
        try {
            $stmt = $this->pdo->prepare("UPDATE customers SET is_admin = 1 WHERE id = ?");
            $stmt->execute([$customerId]);
            if ($stmt->rowCount() > 0) $this->sendResponse(true, 'Client promu administrateur');
            else $this->sendResponse(false, 'Client non trouvé ou déjà admin');
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur promoteToAdmin: ' . $e->getMessage(), null, 500);
        }
    }

    public function demoteFromAdmin($customerId) {
        $this->requireAdminSession();
        try {
            $stmt = $this->pdo->prepare("UPDATE customers SET is_admin = 0 WHERE id = ?");
            $stmt->execute([$customerId]);
            if ($stmt->rowCount() > 0) $this->sendResponse(true, 'Droits admin révoqués');
            else $this->sendResponse(false, 'Client non trouvé ou pas admin');
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur demoteFromAdmin: ' . $e->getMessage(), null, 500);
        }
    }

    public function getAdmins() {
        try {
            $stmt = $this->pdo->query("SELECT id, first_name, last_name, email, is_admin, created_at FROM customers WHERE is_admin = 1 ORDER BY created_at DESC");
            $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->sendResponse(true, 'Admins récupérés', $admins);
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur getAdmins: ' . $e->getMessage(), null, 500);
        }
    }

    public function searchCustomers($q) {
        try {
            $stmt = $this->pdo->prepare("SELECT id, first_name, last_name, email, is_admin, created_at FROM customers WHERE email LIKE ? OR first_name LIKE ? OR last_name LIKE ? LIMIT 10");
            $like = '%' . $q . '%';
            $stmt->execute([$like, $like, $like]);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->sendResponse(true, 'Clients trouvés', $res);
        } catch (PDOException $e) {
            $this->sendResponse(false, 'Erreur searchCustomers: ' . $e->getMessage(), null, 500);
        }
    }

    // --------------------
    // IMAGE UPLOAD
    // --------------------
    private function handleImageUpload($file) {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) return null;
        $allowed = ['image/jpeg','image/png','image/gif','image/webp'];
        $type = mime_content_type($file['tmp_name']);
        if (!in_array($type, $allowed)) return null;
        $uploadDir = dirname(__DIR__) . '/assets/images/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $file['name']);
        $filename = uniqid() . '_' . $safeName;
        $target = $uploadDir . $filename;
        if (move_uploaded_file($file['tmp_name'], $target)) {
            // return relative path
            return 'assets/images/' . $filename;
        }
        return null;
    }

    // Normalize sizes/colors fields
    private function normalizeArrayField($raw) {
        if (is_array($raw)) return $raw;
        // if JSON string
        if (is_string($raw)) {
            $trim = trim($raw);
            if ($trim === '') return [];
            // try decode JSON
            $j = json_decode($trim, true);
            if (is_array($j)) return $j;
            // else comma separated
            $parts = array_map('trim', explode(',', $raw));
            $parts = array_values(array_filter($parts, fn($v) => $v !== ''));
            return $parts;
        }
        return [];
    }
}

// Router
try {
    $api = new API();
    $method = $_SERVER['REQUEST_METHOD'];
    // Normalize action: read from GET (preferred)
    $rawAction = $_GET['action'] ?? '';
    $action = trim($rawAction);

    // Shortcut helpers
    $getId = function($keyCandidates) {
        foreach ($keyCandidates as $k) {
            if (isset($_GET[$k]) && $_GET[$k] !== '') return $_GET[$k];
            // also check POST body
            if (isset($_POST[$k]) && $_POST[$k] !== '') return $_POST[$k];
        }
        $body = getJsonInput();
        foreach ($keyCandidates as $k) {
            if (isset($body[$k]) && $body[$k] !== '') return $body[$k];
        }
        return null;
    };

    switch ($action) {
        // PRODUCTS
        case 'get_products':
        case 'getProducts':
            $category = $_GET['category'] ?? null;
            $api->getProducts($category);
            break;
        case 'get_product':
        case 'getProduct':
            $id = $getId(['id','product_id']);
            if (!$id) $api->sendResponse(false, 'ID produit manquant', null, 400);
            $api->getProduct($id);
            break;
        case 'add_product':
        case 'create_product':
            if ($method !== 'POST') $api->sendResponse(false,'Méthode non autorisée',null,405);
            $api->createProduct();
            break;
        case 'update_product':
            $id = $getId(['id','product_id']);
            if (!$id) $api->sendResponse(false,'ID produit manquant',null,400);
            // Accept POST (form) or PUT (json)
            if (!in_array($method, ['POST','PUT'])) $api->sendResponse(false,'Méthode non autorisée',null,405);
            $api->updateProduct($id);
            break;
        case 'delete_product':
            if ($method !== 'DELETE') $api->sendResponse(false,'Méthode non autorisée',null,405);
            $id = $getId(['id','product_id']);
            if (!$id) $api->sendResponse(false,'ID produit manquant',null,400);
            $api->deleteProduct($id);
            break;

        // ORDERS
        case 'create_order':
            if ($method !== 'POST') $api->sendResponse(false,'Méthode non autorisée',null,405);
            $api->createOrder();
            break;
        case 'get_orders':
            $api->getOrders();
            break;
        case 'get_order':
            $id = $getId(['id','order_id']);
            if (!$id) $api->sendResponse(false,'ID commande manquant',null,400);
            $api->getOrder($id);
            break;
        case 'update_order_status':
            $id = $getId(['id','order_id']);
            if (!$id) $api->sendResponse(false,'ID commande manquant',null,400);
            if (!in_array($method,['PUT','POST'])) $api->sendResponse(false,'Méthode non autorisée',null,405);
            $api->updateOrderStatus($id);
            break;

        // PROMO
        case 'get_promo_codes':
            $api->getPromoCodes();
            break;
        case 'get_promo_code':
            $id = $getId(['id','promo_id']);
            if (!$id) $api->sendResponse(false,'ID promo manquant',null,400);
            $api->getPromoCode($id);
            break;
        case 'add_promo_code':
            if ($method !== 'POST') $api->sendResponse(false,'Méthode non autorisée',null,405);
            $api->addPromoCode();
            break;
        case 'update_promo_code':
            $id = $getId(['id','promo_id']);
            if (!$id) $api->sendResponse(false,'ID promo manquant',null,400);
            if (!in_array($method,['PUT','POST'])) $api->sendResponse(false,'Méthode non autorisée',null,405);
            $api->updatePromoCode($id);
            break;
        case 'delete_promo_code':
            if ($method !== 'DELETE') $api->sendResponse(false,'Méthode non autorisée',null,405);
            $id = $getId(['id','promo_id']);
            if (!$id) $api->sendResponse(false,'ID promo manquant',null,400);
            $api->deletePromoCode($id);
            break;
        case 'validate_promo_code':
            if ($method !== 'POST') $api->sendResponse(false,'Méthode non autorisée',null,405);
            $api->validatePromoCodePublic();
            break;

        // CUSTOMERS
        case 'customer_register':
        case 'user_register':
            if ($method !== 'POST') $api->sendResponse(false,'Méthode non autorisée',null,405);
            $api->customerRegister();
            break;
        case 'customer_login':
        case 'user_login':
            if ($method !== 'POST') $api->sendResponse(false,'Méthode non autorisée',null,405);
            $api->customerLogin();
            break;
        case 'customer_profile':
        case 'get_customer_profile':
            // Accept GET with ?customer_id= or id= or POST/PUT with JSON
            $id = $getId(['customer_id','id']);
            if (!$id) $api->sendResponse(false,'ID client manquant',null,400);
            $api->getCustomerProfile($id);
            break;
        case 'update_customer_profile':
            if (!in_array($method, ['PUT','POST'])) $api->sendResponse(false,'Méthode non autorisée',null,405);
            $api->updateCustomerProfile();
            break;
// === NOUVELLES ROUTES PANIER ===

case 'get_cart':
    $customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : null;
    $session_id = isset($_GET['session_id']) ? $_GET['session_id'] : null;
    
    // Trouver ou créer le panier
    $cart = findOrCreateCart($pdo, $customer_id, $session_id);
    
    if ($cart) {
        $items = getCartItems($pdo, $cart['id']);
        $response = [
            'success' => true,
            'data' => [
                'cart_id' => $cart['id'],
                'items' => $items
            ]
        ];
    } else {
        $response = ['success' => false, 'message' => 'Erreur panier'];
    }
    break;

case 'update_cart':
    $input = json_decode(file_get_contents('php://input'), true);
    $cart_id = intval($input['cart_id']);
    $items = $input['items'];
    
    // Vider le panier existant
    $stmt = $pdo->prepare("DELETE FROM cart_items WHERE cart_id = ?");
    $stmt->execute([$cart_id]);
    
    // Ajouter les nouveaux items
    foreach ($items as $item) {
        $stmt = $pdo->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, size, color) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $cart_id,
            intval($item['id']),
            intval($item['quantity']),
            $item['size'] ?? null,
            $item['color'] ?? null
        ]);
    }
    
    $response = ['success' => true, 'message' => 'Panier mis à jour'];
    break;

case 'merge_carts':
    $customer_id = intval($_GET['customer_id']);
    $session_id = $_GET['session_id'];
    
    // Trouver le panier invité
    $guest_cart = findCartBySession($pdo, $session_id);
    // Trouver le panier utilisateur
    $user_cart = findOrCreateCart($pdo, $customer_id, null);
    
    if ($guest_cart && $user_cart) {
        // Fusionner les items
        mergeCartItems($pdo, $guest_cart['id'], $user_cart['id']);
        // Supprimer le panier invité
        $stmt = $pdo->prepare("DELETE FROM carts WHERE id = ?");
        $stmt->execute([$guest_cart['id']]);
    }
    
    $response = ['success' => true, 'message' => 'Paniers fusionnés'];
    break;
        // ADMIN
        case 'get_user_info':
            $id = $getId(['customer_id','id']);
            if (!$id) $api->sendResponse(false,'ID client manquant',null,400);
            $api->getUserInfo($id);
            break;
        case 'check_admin_status':
        case 'checkAdminStatus':
            $id = $getId(['customer_id','id']);
            if (!$id) $api->sendResponse(false,'ID client manquant',null,400);
            $api->checkAdminStatus($id);
            break;
        case 'promote_to_admin':
            if ($method !== 'POST') $api->sendResponse(false,'Méthode non autorisée',null,405);
            $id = $getId(['customer_id','id']);
            if (!$id) $api->sendResponse(false,'ID client manquant',null,400);
            $api->promoteToAdmin($id);
            break;
        case 'demote_from_admin':
            if ($method !== 'POST') $api->sendResponse(false,'Méthode non autorisée',null,405);
            $id = $getId(['customer_id','id']);
            if (!$id) $api->sendResponse(false,'ID client manquant',null,400);
            $api->demoteFromAdmin($id);
            break;
        case 'get_admins':
            $api->getAdmins();
            break;
        case 'search_customers':
            $q = $_GET['q'] ?? '';
            $api->searchCustomers($q);
            break;

        default:
            $api->sendResponse(false, 'Action non reconnue: ' . $action, null, 400);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
    exit;
}
