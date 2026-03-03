<?php
session_start();
require_once 'config.php';

// Kontrollo nëse përdoruesi është admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("Akses i ndaluar!");
}

// Merr ID e produktit
if (!isset($_GET['id'])) {
    die("Produkti nuk u gjet.");
}
$product_id = (int)$_GET['id'];

// Përditëso produktin nëse është bërë submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image=? WHERE id=?");
    $stmt->execute([$name, $description, $price, $image, $product_id]);
    echo "Produkti u përditësua me sukses!";
}

// Merr të dhënat aktuale të produktit
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$product) {
    die("Produkti nuk ekziston.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edito Produktin</title>
</head>
<body>
    <h1>Edito Produktin</h1>
    <form method="post">
        Emri: <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>"><br>
        Përshkrimi: <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea><br>
        Çmimi: <input type="text" name="price" value="<?= htmlspecialchars($product['price']) ?>"><br>
        Foto (path): <input type="text" name="image" value="<?= htmlspecialchars($product['image']) ?>"><br>
        <button type="submit">Ruaj Ndryshimet</button>
    </form>
    <a href="admin_products.php">Kthehu te lista</a>
</body>
</html>