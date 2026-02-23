<?
session_start();

include_once('db.php');

if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)) {
        echo "Please fill in all fields";
    }else{
        $sql ="SELECT id, emri, username, email, password, is_admin FROM biblioteka WHERE username=:username";

        $selectBooks = $conn->prepare($sql);
        $selectBooks->bindParam(":username", $username);
        $selectBooks->execute();
        $data = $selectBooks->fetch();

        if ($data == false) {
				echo "The user does not exist";
			}else{
                if(password_verify($password, $data['password'])) {
                    $_SESSION['id'] = $data['id'];
                    $_SESSION['emri'] = $data['emri'];
                    $_SESSION['username'] = $data['username'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['is_admin'] = $data['is_admin'];

                    header('Location :dashboard.php');
                }
                else{
                    echo "The password is not valid";
                }
            }
    }
}
?>