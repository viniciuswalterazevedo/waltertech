<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if($usuario == "Vinicius Walter" and $senha == "12022007"){
        header("Location: os.php");
        $_SESSION['nome'] = "Vinicius";
    } else{
        header("Location: ../index.html");
    }
}
?>
