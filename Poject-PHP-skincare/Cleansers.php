<?php

require_once 'config.php';
session_start();

// Merr produktet nga databaza ose statikisht
$allProducts = [];
try {
    $allProducts = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    $productsById = [];
    foreach ($allProducts as $p) {
        $productsById[$p['id']] = $p;
    }
} catch (Exception $e) {
    // Produkte statike nëse nuk ka databazë
    $productsById = [
        1 => [
            'id' => 1,
            'name' => 'Xhel Pastrues',
            'description' => 'Pastron butësisht lëkurën dhe largon papastërtitë.',
            'price' => 1200,
        ],
        2 => [
            'id' => 2,
            'name' => 'Krem Hidratues Ditor',
            'description' => 'Hidratim i lehtë për lëkurë të freskët gjatë gjithë ditës.',
            'price' => 1500,
        ],
        3 => [
            'id' => 3,
            'name' => 'Spray Mbrojtës SPF 50',
            'description' => 'Mbrojtje efektive nga rrezet e diellit, pa yndyrë.',
            'price' => 1800,
        ]
    ];
}

// Hiq produkt nga shporta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
    $removeId = (int)$_POST['remove_id'];
    unset($_SESSION['cart'][$removeId]);
    header("Location: cart.php");
    exit;
}

// Llogarit totalin dhe përgatit produktet në shportë
$total = 0;
$cartItems = [];
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $qty) {
        if (isset($productsById[$id])) {
            $product = $productsById[$id];
            $product['qty'] = $qty;
            $product['subtotal'] = $qty * $product['price'];
            $cartItems[] = $product;
            $total += $product['subtotal'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shporta - Skincare Store</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f7fafc;
            color: #222;
        }
        header {
            background: linear-gradient(90deg, #f6d365 0%, #fda085 100%);
            color: #fff;
            padding: 18px 0 12px 0;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        header h1 {
            margin: 0;
            font-size: 2.2rem;
            letter-spacing: 2px;
            color: #fff;
        }
        nav {
            margin-top: 10px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 18px;
            font-weight: 500;
            font-size: 1.08rem;
            transition: color 0.2s;
            padding: 6px 10px;
            border-radius: 6px;
        }
        nav a:hover, nav a.active {
            background: #fffbe7;
            color: #fda085;
        }
        .page-header {
            background: #fffbe7;
            color: #fda085;
            padding: 1.2rem 0;
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
            border-radius: 0 0 24px 24px;
            box-shadow: 0 2px 8px rgba(253,160,133,0.08);
        }
        .cart-table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(253,160,133,0.08);
        }
        .cart-table th, .cart-table td {
            padding: 14px 10px;
            border-bottom: 1px solid #f6d365;
            text-align: center;
        }
        .cart-table th {
            background: #fffbe7;
            color: #fda085;
        }
        .cart-table img {
            width: 60px;
            border-radius: 50%;
        }
        .cart-actions form {
            display: inline;
        }
        .cart-total {
            text-align: right;
            margin: 30px 8%;
            font-size: 1.2rem;
            color: #fda085;
        }
        .empty-cart {
            text-align: center;
            margin: 60px 0;
            color: #888;
            font-size: 1.1rem;
        }
        .empty-cart h2 {
            color: #fda085;
            margin-bottom: 10px;
        }
        .empty-cart a {
            color: #fda085;
            font-weight: bold;
            text-decoration: none;
            border: 1px solid #fda085;
            padding: 8px 18px;
            border-radius: 6px;
            background: #fffbe7;
            display: inline-block;
            margin-top: 12px;
            transition: background 0.2s, color 0.2s;
        }
        .empty-cart a:hover {
            background: #fda085;
            color: #fff;
        }
        @media (max-width: 900px) {
            .cart-table {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Skincare Store</h1>
        <nav>
            <a href="index.php">Kreu</a>
            <a href="produktet.php">Produktet</a>
            <a href="kids.php">Fëmijë</a>
            <a href="login.php">Hyrje / Regjistrim</a>
            <a href="kontakti.php">Kontakti</a>
        </nav>
    </header>

    <div class="page-header">
        Shporta e Produkteve
    </div>

    <?php if (empty($cartItems)): ?>
        <div class="empty-cart">
            <h2>Shporta është bosh</h2>
            <p>Ju nuk keni shtuar ende asnjë produkt në shportë.</p>
            <a href="produktet.php">Shfleto produktet</a>
        </div>
    <?php else: ?>
        <table class="cart-table">
            <tr>
                <th>Foto</th>
                <th>Emri i Produktit</th>
                <th>Çmimi</th>
                <th>Sasia</th>
                <th>Nëntotali</th>
                <th>Veprim</th>
            </tr>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><img src="images.jpg" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['price']); ?> Lekë</td>
                    <td><?php echo htmlspecialchars($item['qty']); ?></td>
                    <td><?php echo htmlspecialchars($item['subtotal']); ?> Lekë</td>
                    <td class="cart-actions">
                        <form method="post">
                            <input type="hidden" name="remove_id" value="<?php echo $item['id']; ?>">
                            <button type="submit">Hiq</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="cart-total">
            Totali: <strong><?php echo $total; ?> Lekë</strong>
        </div>
    <?php endif; ?>