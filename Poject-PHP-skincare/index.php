<?php
require_once 'config.php';
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=skincare_store', 'root', '');


$products = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);

// Handle cart operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['buy_all'])) {
        foreach ($products as $product) {
            $_SESSION['cart'][$product['id']] = 1; // Add one of each product
        }

        header("Location: cart.php");
        exit;
    }
}

// Lista e produkteve skincare (shembull statik)
$staticProducts = [
    [
        'id' => 1,
        'name' => 'Cleanser i butë',
        'description' => 'Pastrim i thellë për lëkurë të ndjeshme, pa irritime.',
        'price' => 1200,
        'image' => 'images/cleanser.jpg'
    ],
    [
        'id' => 2,
        'name' => 'Krem Hidratues',
        'description' => 'Hidratim i përditshëm për çdo lloj lëkure, pa yndyrë.',
        'price' => 1500,
        'image' => 'images/moisturizer.jpg'
    ],
    [
        'id' => 3,
        'name' => 'Krem Mbrojtës SPF 50',
        'description' => 'Mbrojtje maksimale nga dielli, teksturë e lehtë.',
        'price' => 1800,
        'image' => 'images/sunscreen.jpg'
    ]
];

// Shto në shportë
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1;
    } else {
        $_SESSION['cart'][$productId]++;
    }
    header("Location: product.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Skincare Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Skincare Store</h1>
        <nav>
            <a href="index.php">Faqja e Par</a>
            <a href="produktet.php">Produktet</a>
            <a href="rreth_nesh.php">Rreth Nesh</a>
            <a href="kontakti.php">Kontakti</a>
             <a href="cart.php">Shporta</a>
              <a href="login.php">Login</a>
               <a href="signup.php">Signup</a>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h2>Mirësevini në Skincare Store!</h2>
            <p>Zbuloni produktet më të mira për kujdesin e lëkurës tuaj. Shëndet dhe bukuri çdo ditë!</p>
        </section>

        <section class="produktet">
            <h2>Produktet më të shitura</h2>
            <div class="produkt-lista">
                <div class="produkt">
                    <img src="images/img1.jpg" alt="Cleanser">
                    <h3>Cleanser i butë</h3>
                    <p>Pastrim i thellë për lëkurë të ndjeshme, pa irritime.</p>
                    <span>12 Euro</span>
                    <form method="post" action="index.php">
        <input type="hidden" name="product_id" value="1">
        <button type="submit">Shto në shportë</button>
    </form>
                </div>
                <div class="produkt">
                    <img src="images/images.jpg" alt="Moisturizer">
                    <h3>Krem Hidratues</h3>
                    <p>Hidratim i përditshëm për çdo lloj lëkure, pa yndyrë.</p>
                    <span>15 Euro</span>
                    <form method="post" action="index.php">
        <input type="hidden" name="product_id" value="2">
        <button type="submit">Shto në shportë</button>
    </form>
                </div>
                <div class="produkt">
                    <img src="images/suncream.png" alt="Sunscreen">
                    <h3>Krem Mbrojtës SPF 50</h3>
                    <p>Mbrojtje maksimale nga dielli, teksturë e lehtë.</p>
                    <span>18 Euro</span>
                    <form method="post" action="index.php">
        <input type="hidden" name="product_id" value="3">
        <button type="submit">Shto në shportë</button>
    </form>
                </div>
                <div class="produkt">
                    <img src="images/serum.jpg" alt="Serum">
                    <h3>Serum me Vitaminë C</h3>
                    <p>Ndriçon lëkurën dhe redukton njollat e errëta.</p>
                    <span>20 Euro</span>
                    <button>Shto në shportë</button>
                </div>
                <div class="produkt">
                    <img src="images/eyecream.png" alt="Eye Cream">
                    <h3>Krem për sytë</h3>
                    <p>Redukton rrathët e zinj dhe fryrjet rreth syve.</p>
                    <span>17 Euro</span>
                    <button>Shto në shportë</button>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Skincare Store. Të gjitha të drejtat e rezervuara.</p>
    </footer>
</body>
</html>


