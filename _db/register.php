<?php
require_once 'dbconnect.php';
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $pseudo = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $mail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)){
        echo "Invalid email format";
        exit();
    }
    $password = password_hash ($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (pseudo, mail, password) VALUES (:pseudo, :mail, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':password', $password);
    if ($stmt -> execute()){
        echo "User created. <a href='../lobby.php'> Retour à l'acceuil. </a>";
    }else {
        echo "Erreur lors de l'inscription : " . $stmt->errorInfo()[2];
    }
}
?>