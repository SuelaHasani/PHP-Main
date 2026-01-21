<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
    include_once('config.php');
    $sql = "SELECT * FROM users";
    $getUsers = $conn-prepare($sql);
    $getUsers->execute();
    $users=$getUsers->fetchAll();
?>

<br><br>

<table>
    <thead>
        <th>ID</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Email</th>
    </thead>
    <tbody>
        <?php
            foreach($users as $user){
        ?>

           <tr>
             <td><?= $user['id'] ?></td>
             <td><?= $user['name'] ?></td>
             <td><?= $user['surname'] ?></td>
             <td><?= $user['email'] ?></td>
             <td><? "<a href='delete.php?id=$user[id]'> Delete</a>| <a href='edit.php?id=$user[id]'> Update </a>"?></td>
           </tr>
           <?php
           }
           ?>
    </tbody>
</table>
<a href="add.php">Add user</a>

</body>
</html>