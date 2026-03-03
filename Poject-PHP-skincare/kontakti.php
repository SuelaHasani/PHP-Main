<?php
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Kontakti</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background: #f7f7fa;
            font-family: Arial, sans-serif;
        }
        main {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 30px 40px;
        }
        h2 {
            text-align: center;
            color: #3a3a5a;
        }
        form label {
            font-weight: bold;
            color: #444;
        }
        form input[type="text"],
        form input[type="email"],
        form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 4px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            background: #fafaff;
            transition: border 0.2s;
        }
        form input:focus,
        form textarea:focus {
            border: 1.5px solid #7b5eea;
            outline: none;
        }
        button[type="submit"] {
            background: #7b5eea;
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
            display: block;
            width: 100%;
        }
        button[type="submit"]:hover {
            background: #5a3fc0;
        }
        .success-message {
            background: #e6ffe6;
            color: #2d7a2d;
            border: 1px solid #b2e6b2;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Na Kontaktoni</h1>
        <nav>
            <a href="index.php">Faqja e Parë</a>
            <a href="produkte.php">Produktet</a>
            <a href="rreth_nesh.php">Rreth Nesh</a>
            <a href="kontakti.php">Kontakti</a>
        </nav>
    </header>
    <main>
        <h2>Formulari i Kontaktit</h2>
        <?php if ($success): ?>
            <div class="success-message">Mesazhi u dërgua me sukses!</div>
        <?php endif; ?>
        <form method="post" action="kontakti.php">
            <label for="name">Emri juaj:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email-i:</label>
            <input type="email" id="email" name="email" required>
            <label for="message">Mesazhi:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
            <button type="submit">Dërgo</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2025 Skincare Store. Të gjitha të drejtat e rezervuara.</p>
    </footer>
</body>
</html>