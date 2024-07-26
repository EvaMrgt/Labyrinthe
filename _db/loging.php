<?php
session_start();
require_once 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];
    $sql = "SELECT ID, password FROM user WHERE pseudo = :pseudo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_ID'] = $user['ID'];
        header("Location: ../mousecatcher.php");
        exit();
    }else {
        echo "Nom d'utilisateur et/ou mot de passe incorrect. <a href='../lobby.php'> Retour à l'acceuil</a>";
    }
}
?>