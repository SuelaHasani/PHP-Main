<?php
session_start();

// Produktet skincare për fëmijë (shembull)
$products = [
    [
        'id' => 201,
        'name' => 'Xhel Pastrues Kids',
        'description' => 'Pastron butësisht lëkurën e ndjeshme të fëmijëve.',
        'price' => 890,
        'image' => 'images.jpg'
    ],
    [
        'id' => 202,
        'name' => 'Krem Hidratues Kids',
        'description' => 'Hidratim i përditshëm për lëkurën delikate të fëmijëve.',
        'price' => 950,
        'image' => 'images.jpg'
    ],
    [
        'id' => 203,
        'name' => 'Spray Mbrojtës SPF 50 Kids',
        'description' => 'Mbrojtje nga dielli për lëkurën e fëmijëve, pa irritime.',
        'price' => 1100,
        'image' => 'images.jpg'
    ]
];

// Shto ose hiq nga shporta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity']++;
        } else {
            foreach ($products as $product) {
                if ($product['id'] == $product_id) {
                    $_SESSION['cart'][$product_id] = [
                        'name'     => $product['name'],
                        'price'    => $product['price'],
                        'image'    => $product['image'],
                        'quantity' => 1
                    ];
                    break;
                }
            }
        }
    }
    if (isset($_POST['remove_from_cart'])) {
        $product_id = $_POST['product_id'];
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    }
}

// Llogarit totali i shportës
$cart_total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_total += $item['price'] * $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skincare për Fëmijë</title>
    <style>
        header {
            background: linear-gradient(90deg, #f6d365 0%, #fda085 100%);
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            margin: 0;
            font-size: 2rem;
            letter-spacing: 1px;
        }
        header nav a {
            color: #fff;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.2s;
        }
        header nav a:hover {
            color: #fda085;
        }
        .page-header {
            background-color: #fffbe7;
            color: #fda085;
            padding: 1rem 0;
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7fafc;
            color: #222;
        }
        .container {
            padding: 2rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .product-card {
            background: #fff;
            border: 2px solid #fda085;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(253,160,133,0.10);
            overflow: hidden;
            width: 300px;
            transition: transform 0.3s;
        }
        .product-card:hover {
            transform: scale(1.03);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .product-card-content {
            padding: 15px;
        }
        .product-card h2 {
            margin: 0 0 10px 0;
            font-size: 1.2rem;
            color: #fda085;
        }
        .product-card p {
            margin: 0 0 10px 0;
            color: #555;
            font-size: 0.95rem;
        }
        .product-card .price {
            color: #f6d365;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
        .product-card button {
            background: linear-gradient(90deg, #f6d365 0%, #fda085 100%);
            color: white;
            border: none;
            padding: 8px 15px;
            margin-right: 5px;
            margin-bottom: 5px;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .product-card button:hover {
            background: linear-gradient(90deg, #fda085 0%, #f6d365 100%);
        }
        .product-card button.remove-btn {
            background: #eee;
            color: #fda085;
        }
        .product-card button.remove-btn:hover {
            background: #f6d365;
            color: #fff;
        }
        .cart {
            position: fixed;
            top: 120px;
            right: 20px;
            background: #fffbe7;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(253,160,133,0.10);
            width: 220px;
        }
        .cart h3 {
            margin-top: 0;
            border-bottom: 1px solid #fda085;
            padding-bottom: 10px;
            color: #fda085;
        }
        .cart-total {
            font-weight: bold;
            font-size: 1.1rem;
            color: #fda085;
        }
        .cart a {
            display: inline-block;
            margin-top: 10px;
            color: #fda085;
            text-decoration: none;
            font-weight: bold;
        }
        .cart a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Skincare Store</h1>
        <nav>
            <a href="index.php">Kreu</a>
            <a href="produktet.php">Produktet</a>
            <a href="rreth_nesh.php">Rreth Nesh</a>
            <a href="kontakti.php">Kontakti</a>
        </nav>
        <nav>
            <a href="login.php">Hyrje / Regjistrim</a>
        </nav>
    </header>

    <div class="page-header">
        Skincare për Fëmijë
    </div>
    
    <div class="container">
        <?php foreach ($products as $product): ?>
        <div class="product-card">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            <div class="product-card-content">
                <h2><?= htmlspecialchars($product['name']) ?></h2>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <p class="price"><?= htmlspecialchars($product['price']) ?> Lekë</p>
                <form method="post" style="display: inline;">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit" name="add_to_cart">Shto në Shportë</button>
                </form>
                <form method="post" style="display: inline;">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit" name="remove_from_cart" class="remove-btn">Hiq nga Shporta</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="cart">
        <h3>Shporta Juaj</h3>
        <p class="cart-total">Totali: <?= htmlspecialchars($cart_total) ?> Lekë</p>
        <a href="cart.php">Shiko Shportën</a>
    </div>
</body>
</html>