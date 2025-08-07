<?php
// Database configuration
$host = 'localhost';
$dbname = 'smart_mart';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle different API endpoints
$action = $_GET['action'] ?? '';

header('Content-Type: application/json');

switch($action) {
    case 'get_products':
        getProducts();
        break;
    case 'add_product':
        addProduct();
        break;
    case 'update_product':
        updateProduct();
        break;
    case 'delete_product':
        deleteProduct();
        break;
    case 'get_orders':
        getOrders();
        break;
    case 'add_order':
        addOrder();
        break;
    case 'update_order_status':
        updateOrderStatus();
        break;
    case 'get_stats':
        getStats();
        break;
    default:
        echo json_encode(['error' => 'Invalid action']);
}

function getProducts() {
    global $pdo;
    
    $category = $_GET['category'] ?? '';
    $search = $_GET['search'] ?? '';
    
    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];
    
    if ($category && $category !== 'all') {
        $sql .= " AND category = ?";
        $params[] = $category;
    }
    
    if ($search) {
        $sql .= " AND (name LIKE ? OR description LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    
    $sql .= " ORDER BY name";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($products);
}

function addProduct() {
    global $pdo;
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $sql = "INSERT INTO products (name, category, price, description, image, stock, bestseller) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $data['name'],
        $data['category'],
        $data['price'],
        $data['description'],
        $data['image'],
        $data['stock'],
        $data['bestseller'] ? 1 : 0
    ]);
    
    if ($result) {
        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to add product']);
    }
}

function updateProduct() {
    global $pdo;
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $sql = "UPDATE products SET name = ?, category = ?, price = ?, description = ?, 
            image = ?, stock = ?, bestseller = ? WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $data['name'],
        $data['category'],
        $data['price'],
        $data['description'],
        $data['image'],
        $data['stock'],
        $data['bestseller'] ? 1 : 0,
        $data['id']
    ]);
    
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update product']);
    }
}

function deleteProduct() {
    global $pdo;
    
    $id = $_GET['id'] ?? 0;
    
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$id]);
    
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete product']);
    }
}

function getOrders() {
    global $pdo;
    
    $sql = "SELECT o.*, GROUP_CONCAT(CONCAT(oi.product_name, ' x', oi.quantity) SEPARATOR ', ') as items
            FROM orders o 
            LEFT JOIN order_items oi ON o.id = oi.order_id 
            GROUP BY o.id 
            ORDER BY o.created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($orders);
}

function addOrder() {
    global $pdo;
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    try {
        $pdo->beginTransaction();
        
        // Insert order
        $sql = "INSERT INTO orders (customer_name, customer_class, customer_phone, 
                delivery_time, special_instructions, total_amount, status) 
                VALUES (?, ?, ?, ?, ?, ?, 'pending')";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['customer_name'],
            $data['customer_class'],
            $data['customer_phone'],
            $data['delivery_time'],
            $data['special_instructions'],
            $data['total_amount']
        ]);
        
        $orderId = $pdo->lastInsertId();
        
        // Insert order items
        $sql = "INSERT INTO order_items (order_id, product_id, product_name, quantity, price) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        foreach ($data['items'] as $item) {
            $stmt->execute([
                $orderId,
                $item['product_id'],
                $item['product_name'],
                $item['quantity'],
                $item['price']
            ]);
        }
        
        $pdo->commit();
        echo json_encode(['success' => true, 'order_id' => $orderId]);
        
    } catch (Exception $e) {
        $pdo->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function updateOrderStatus() {
    global $pdo;
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$data['status'], $data['id']]);
    
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update order status']);
    }
}

function getStats() {
    global $pdo;
    
    // Get total products
    $stmt = $pdo->query("SELECT COUNT(*) as total_products FROM products");
    $totalProducts = $stmt->fetch(PDO::FETCH_ASSOC)['total_products'];
    
    // Get total orders
    $stmt = $pdo->query("SELECT COUNT(*) as total_orders FROM orders");
    $totalOrders = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];
    
    // Get pending orders
    $stmt = $pdo->query("SELECT COUNT(*) as pending_orders FROM orders WHERE status = 'pending'");
    $pendingOrders = $stmt->fetch(PDO::FETCH_ASSOC)['pending_orders'];
    
    // Get total revenue
    $stmt = $pdo->query("SELECT SUM(total_amount) as total_revenue FROM orders WHERE status = 'completed'");
    $totalRevenue = $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;
    
    // Get low stock products
    $stmt = $pdo->query("SELECT COUNT(*) as low_stock FROM products WHERE stock <= 5");
    $lowStock = $stmt->fetch(PDO::FETCH_ASSOC)['low_stock'];
    
    // Get recent orders
    $stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5");
    $recentOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get top selling products
    $stmt = $pdo->query("
        SELECT p.name, SUM(oi.quantity) as total_sold 
        FROM products p 
        JOIN order_items oi ON p.id = oi.product_id 
        GROUP BY p.id 
        ORDER BY total_sold DESC 
        LIMIT 5
    ");
    $topProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'total_products' => $totalProducts,
        'total_orders' => $totalOrders,
        'pending_orders' => $pendingOrders,
        'total_revenue' => $totalRevenue,
        'low_stock' => $lowStock,
        'recent_orders' => $recentOrders,
        'top_products' => $topProducts
    ]);
}

// Database schema (run this once to create tables)
function createTables() {
    global $pdo;
    
    // Products table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            category VARCHAR(50) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            description TEXT,
            image VARCHAR(500),
            stock INT DEFAULT 0,
            bestseller BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ");
    
    // Orders table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            customer_name VARCHAR(255) NOT NULL,
            customer_class VARCHAR(100),
            customer_phone VARCHAR(20),
            delivery_time VARCHAR(50),
            special_instructions TEXT,
            total_amount DECIMAL(10,2) NOT NULL,
            status ENUM('pending', 'confirmed', 'preparing', 'ready', 'delivered', 'cancelled') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ");
    
    // Order items table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS order_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            product_id INT NOT NULL,
            product_name VARCHAR(255) NOT NULL,
            quantity INT NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        )
    ");
}

// Uncomment the line below to create tables (run once)
// createTables();
?>