<?php
session_start();
require_once 'config.php';

// Sigurohu që veç admini të ketë akses
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Fshij përdorues nëse kërkohet
if(isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    if($id !== $_SESSION['user_id']) { // mos lejo fshirjen e vetes
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
    header('Location: admin_dashboard.php');
    exit();
}

// Merr listën e përdoruesve
$stmt = $conn->query("SELECT id, email, role, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang='sq'>
<head>
    <meta charset='UTF-8'>
    <title>Admin Dashboard</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'>
</head>
<body>
<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
  <div class='container-fluid'>
    <a class='navbar-brand' href='#'>Admin Dashboard</a>
    <div class='d-flex'>
      <a class='btn btn-outline-light' href='logout.php'>Dil</a>
    </div>
  </div>
</nav>

<div class='container mt-4'>
    <h3 class='mb-3'>Përdoruesit</h3>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Roli</th>
                <th>Krijuar më</th>
                <th>Veprime</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= $u['role'] ?></td>
                <td><?= $u['created_at'] ?></td>
                <td>
                    <?php if($u['id'] !== $_SESSION['user_id']): ?>
                    <a class='btn btn-sm btn-danger' onclick="return confirm('Je i sigurt?')" href='?delete=<?= $u['id'] ?>'>Fshij</a>
                    <?php else: ?>
                    -
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
