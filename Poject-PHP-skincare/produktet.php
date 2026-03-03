<?php
require_once 'config.php';
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=skincare_store', 'root', '');

$products = [];
try {
    $products = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $products = [
        [
            'id' => 1,
            'name' => 'Cleanser i butë',
            'description' => 'Pastrim i thellë për lëkurë të ndjeshme, pa irritime.',
            'price' => 1200,
        ],
        [
            'id' => 2,
            'name' => 'Krem Hidratues',
            'description' => 'Hidratim i përditshëm për çdo lloj lëkure, pa yndyrë.',
            'price' => 1500,
        ],
        [
            'id' => 3,
            'name' => 'Krem Mbrojtës SPF 50',
            'description' => 'Mbrojtje maksimale nga dielli, teksturë e lehtë.',
            'price' => 1800,
        ]
    ];
}

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
</head>
<body>
    <header>
        <h1>Produktet Skincare</h1>
        <nav>
            <a href="index.php">Kreu</a>
            <a href="produktet.php">Produktet</a>
            <a href="rreth_nesh.php">Rreth Nesh</a>
            <a href="kontakti.php">Kontakti</a>
        </nav>
    </header>
    <main>
        <section class="produktet">
            <h2>Zgjidh produktin tënd të preferuar</h2>
            <div class="produkt-lista">
                <div class="produkt">
                    <img src="images/serum.jpg" alt="Serum me Vitaminë C">
                    <h3>Serum me Vitaminë C</h3>
                    <p>Ndriçon lëkurën dhe redukton njollat e errëta.</p>
                    <span>20 Euro</span>
                    <form method="post" action="index.php">
                        <input type="hidden" name="product_id" value="1">
                        <button type="submit">Shto në shportë</button>
                    </form>
                </div>
                <div class="produkt">
                    <img src="images/images.jpg" alt="Krem Hidratues">
                    <h3>Krem Hidratues</h3>
                    <p>Hidratim i përditshëm për çdo lloj lëkure, pa yndyrë.</p>
                    <span>15 Euro</span>
                    <form method="post" action="index.php">
                        <input type="hidden" name="product_id" value="2">
                        <button type="submit">Shto në shportë</button>
                    </form>
                </div>
                <div class="produkt">
                    <img src="images/img1.jpg" alt="Cleanser i butë">
                    <h3>Cleanser i butë</h3>
                    <p>Pastrim i thellë për lëkurë të ndjeshme, pa irritime.</p>
                    <span>12 Euro</span>
                    <form method="post" action="index.php">
                        <input type="hidden" name="product_id" value="3">
                        <button type="submit">Shto në shportë</button>
                    </form>
                </div>
                <div class="produkt">
                    <img src="images/eyecream.png" alt="Krem për sytë">
                    <h3>Krem për sytë</h3>
                    <p>Redukton rrathët e zinj dhe fryrjet rreth syve.</p>
                    <span>17 Euro</span>
                    <form method="post" action="index.php">
                        <input type="hidden" name="product_id" value="4">
                        <button type="submit">Shto në shportë</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Skincare Store. Të gjitha të drejtat e rezervuara.</p>
    </footer>
</body>
</html>