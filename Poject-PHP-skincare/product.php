<?php
require_once 'config.php';
session_start();

// Merr ID-në e produktit nga URL-ja
if (!isset($_GET['id'])) {
    header("Location: produktet.php");
    exit;
}

$productId = (int)$_GET['id'];

// Kërko produktin në databazë ose nga lista statike
$product = null;
try {
    $pdo = new PDO('mysql:host=localhost;dbname=skincare_store', 'root', '');
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Nëse nuk ka databazë, përdor produkte statike
    $staticProducts = [
        1 => [
            'id' => 1,
            'name' => 'Serum me Vitaminë C',
            'description' => 'Ndriçon lëkurën dhe redukton njollat e errëta.',
            'price' => 20,
            'image' => 'serum.jpg'
        ],
        2 => [
            'id' => 2,
            'name' => 'Krem Hidratues',
            'description' => 'Hidratim i përditshëm për çdo lloj lëkure, pa yndyrë.',
            'price' => 15,
            'image' => 'images.jpg'
        ],
        3 => [
            'id' => 3,
            'name' => 'Cleanser i butë',
            'description' => 'Pastrim i thellë për lëkurë të ndjeshme, pa irritime.',
            'price' => 12,
            'image' => 'img1.jpg'
        ],
        4 => [
            'id' => 4,
            'name' => 'Krem për sytë',
            'description' => 'Redukton rrathët e zinj dhe fryrjet rreth syve.',
            'price' => 17,
            'image' => 'eyecream.png'
        ]
    ];
    if (isset($staticProducts[$productId])) {
        $product = $staticProducts[$productId];
    }
}

// Nëse produkti nuk ekziston
if (!$product) {
    echo "<h2>Produkti nuk u gjet.</h2>";
    exit;
}

// Shto në shportë
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1;
    } else {
        $_SESSION['cart'][$productId]++;
    }
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?> - Skincare Store</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .produkt-detaje {
            max-width: 400px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 30px 40px;
            text-align: center;
        }
        .produkt-detaje img {
            width: 160px;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 18px;
        }
        .produkt-detaje h2 {
            color: #7b5eea;
        }
        .produkt-detaje span {
            font-size: 1.2rem;
            color: #fda085;
            font-weight: bold;
        }
        .produkt-detaje form button {
            background: #7b5eea;
            color: #fff;
            border: none;
            padding: 10px 22px;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 18px;
        }
        .produkt-detaje form button:hover {
            background: #5a3fc0;
        }
        .back-link {
            margin-top: 30px;
            display: block;
            color: #fda085;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <h1>Detajet e Produktit</h1>
        <nav>
            <a href="index.php">Kreu</a>
            <a href="produktet.php">Produktet</a>
            <a href="rreth_nesh.php">Rreth Nesh</a>
            <a href="kontakti.php">Kontakti</a>
            <a href="cart.php">Shporta</a>
        </nav>
    </header>
    <main>
        <section class="produkt-detaje">
            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <span><?php echo htmlspecialchars($product['price']); ?> Euro</span>
            <form method="post" style="margin-top:20px;">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <button type="submit">Shto në shportë</button>
            </form>
            <a href="produktet.php" class="back-link">&larr; Kthehu te produktet</a>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Skincare Store. Të gjitha të drejtat e rezervuara.</p>
    </footer>
</body>
</html>