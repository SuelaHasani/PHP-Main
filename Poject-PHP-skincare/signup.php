<?php
require_once 'config.php';
session_start();

$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $error = "Të gjitha fushat janë të detyrueshme!";
    } elseif($password !== $confirm) {
        $message = "Fjalëkalimet nuk përputhen!";
    } else {
        // Kontrollo nëse username ekziston
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "Ky username ekziston!";
        } else {
            // Krijo përdoruesin
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
            if($stmt->execute([$username, $email, $hashedPassword])) {
                $message = "Regjistrimi u krye me sukses! Mund të bëni login.";
            } else {
                $message = "Diçka shkoi keq. Provo sërish.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Regjistrohu - Skincare Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f7fafc;
        }
        .register-container {
            max-width: 400px;
            margin: 70px auto;
            background: #fff;
            padding: 32px 28px;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(253,160,133,0.10);
            text-align: center;
        }
        .register-container h2 {
            color: #fda085;
            margin-bottom: 18px;
        }
        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0 18px 0;
            border: 1px solid #f6d365;
            border-radius: 7px;
            font-size: 1rem;
        }
        .register-container button {
            background: linear-gradient(90deg, #f6d365 0%, #fda085 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 30px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .register-container button:hover {
            background: linear-gradient(90deg, #fda085 0%, #f6d365 100%);
        }
        .register-container p {
            margin-top: 18px;
            color: #888;
            font-size: 0.97rem;
        }
        .register-container a {
            color: #fda085;
            text-decoration: none;
        }
        .register-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Krijo llogari në Skincare Store</h2>
        <?php if($message): ?>
            <div class='alert alert-info'><?= $message ?></div>
        <?php endif; ?>
        <?php if($error): ?>
            <div class='alert alert-danger'><?= $error ?></div>
        <?php endif; ?>
        <form method='POST'>
            <input type="text" name="username" placeholder="Përdoruesi" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Fjalëkalimi" required minlength='6'>
            <input type="password" name="confirm" placeholder="Përsërit fjalëkalimin" required minlength='6'>
            <button type="submit">Regjistrohu</button>
        </form>
        <p>Ke llogari? <a href="login.php">Hyr këtu</a></p>
    </div>
</body>
</html>
