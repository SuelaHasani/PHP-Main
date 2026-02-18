<?
session_start();

include_once('db.php');

if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)) {
        echo "Please fill in all fields";
    }else{
        $sql ="SELECT id, titulli, autori, viti, sasia FROM biblioteka WHERE useranme=:username";

        $selectBooks = $conn->prepare($sql);
        $selectBooks->bindParam(":username", $username);
        $selectBooks->execute();
        $data = $selectBooks->fetch();

        if ($data == false) {
				echo "The user does not exist";
			}else{
                if(password_verify($password, $data['password'])) {
                    $SESSION['id'] = $data['id'];
                    $SESSION['titulli'] = $data['titulli'];
                    $SESSION['autori'] = $data['autori'];
                    $SESSION['viti'] = $data['viti'];
                    $SESSION['sasia'] = $data['sasia'];

                    header('Location :dashboard.php')
                }
                else{
                    echo "The password is not valid";
                }
            }
    }
}
?>