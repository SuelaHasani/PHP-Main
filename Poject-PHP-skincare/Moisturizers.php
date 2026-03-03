
<?php
require_once 'config.php';
session_start();

// Lidhja me databazën
$pdo = new PDO('mysql:host=localhost;dbname=skincare_store', 'root', '');

// Merr produktet nga databaza (nëse ke tabelën 'products')
$products = [];
try {
    $products = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Nëse nuk ka databazë, përdor produkte statike skincare
    $products = [
        [
            'id' => 1,
            'name' => 'Serum me Vitaminë C',
            'description' => 'Ndriçon lëkurën dhe redukton njollat e errëta.',
            'price' => 20,
            'image' => 'serum.jpg'
        ],
        [
            'id' => 2,
            'name' => 'Krem Hidratues',
            'description' => 'Hidratim i përditshëm për çdo lloj lëkure, pa yndyrë.',
            'price' => 15,
            'image' => 'images.jpg'
        ],
        [
            'id' => 3,
            'name' => 'Cleanser i butë',
            'description' => 'Pastrim i thellë për lëkurë të ndjeshme, pa irritime.',
            'price' => 12,
            'image' => 'img1.jpg'
        ],
        [
            'id' => 4,
            'name' => 'Krem për sytë',
            'description' => 'Redukton rrathët e zinj dhe fryrjet rreth syve.',
            'price' => 17,
            'image' => 'eyecream.png'
        ]
    ];
}

// Shto në shportë
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1;
    } else {
        $_SESSION['cart'][$productId]++;
    }
    header("Location: produktet.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Produktet - Skincare Store</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .produkt-lista {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }
        .produkt {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 20px;
            width: 230px;
            text-align: center;
        }
        .produkt img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .produkt h3 {
            margin: 10px 0 5px 0;
            color: #7b5eea;
        }
        .produkt p {
            font-size: 0.97em;
            color: #444;
            min-height: 48px;
        }
        .produkt span {
            display: block;
            margin: 10px 0;
            font-weight: bold;
            color: #fda085;
        }
        .produkt form button {
            background: #7b5eea;
            color: #fff;
            border: none;
            padding: 10px 22px;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.2s;
        }
        .produkt form button:hover {
            background: #5a3fc0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Produktet Skincare</h1>
        <nav>
            <a href="index.php">Kreu</a>
            <a href="produktet.php">Produktet</a>
            <a href="rreth_nesh.php">Rreth Nesh</a>
            <a href="kontakti.php">Kontakti</a>
            <a href="cart.php">Shporta</a>
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
        </nav>
    </header>
    <main>
        <section class="produktet">
            <h2>Zgjidh produktin tënd të preferuar</h2>
            <div class="produkt-lista">
                <?php foreach ($products as $product): ?>
                    <div class="produkt">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <span><?php echo htmlspecialchars($product['price']); ?> Euro</span>
                        <form method="post" action="produktet.php">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit">Shto në shportë</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Skincare Store. Të gjitha të drejtat e rezervuara.</p>
    </footer>
</body>