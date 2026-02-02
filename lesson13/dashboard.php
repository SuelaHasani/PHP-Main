<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <style>
        table {
            border: 1px solid black;
        }
        tr,td,th{
            border: 1px solid black;   
        }
        table,tr,td {
            border-collapse: collapse;
        }
        td{
            padding: 10px;
        }

    </style>
    <body>
</head>

    
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