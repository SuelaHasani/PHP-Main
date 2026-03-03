<?php
session_start();
require_once 'config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();



    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        if ($user['role'] === 'admin') {
            header('Location: admin_dashboard.php');
        } else {
            header('Location: index.php');
        }
        exit();
    } else {
        $message = 'Email ose fjalëkalim i pasaktë';
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Hyrje - Skincare Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f7fafc;
        }
        .login-container {
            max-width: 370px;
            margin: 70px auto;
            background: #fff;
            padding: 32px 28px;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(253,160,133,0.10);
            text-align: center;
        }
        .login-container h2 {
            color: #fda085;
            margin-bottom: 18px;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0 18px 0;
            border: 1px solid #f6d365;
            border-radius: 7px;
            font-size: 1rem;
        }
        .login-container button {
            background: linear-gradient(90deg, #f6d365 0%, #fda085 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 30px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .login-container button:hover {
            background: linear-gradient(90deg, #fda085 0%, #f6d365 100%);
        }
        .login-container p {
            margin-top: 18px;
            color: #888;
            font-size: 0.97rem;
        }
        .login-container a {
            color: #fda085;
            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Hyr në Skincare Store</h2>
        <form method='POST'>
            <input type="text" name="email" placeholder="Përdoruesi" required>
            <input type="password" name="password" placeholder="Fjalëkalimi" required>
            <button type='submit' class='btn btn-primary w-100'>Hyr</button>
        </form>
        <p>Nuk ke llogari? <a href="signup.php">Regjistrohu</a></p>
    </div>
</body>
</html>

