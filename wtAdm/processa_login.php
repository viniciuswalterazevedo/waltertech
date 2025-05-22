<?php
session_start(); //iniciando a session
include 'conexao.php'; // Arquivo com a conexão ao banco

$email = $_POST['email']; //recebendo os dados
$senha = $_POST['senha'];

// Consulta segura com prepared statement
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();

    // Verifica a senha (se estiver usando hash, troque por password_verify)
    if ($senha === $usuario['senha']) {
        
        // Login bem-sucedido, redirecionando e armazenando a session
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['email'] = $usuario['email'];

        header("Location: painel.php");
        exit();
    } else {
        echo "Senha incorreta.";
    }
} else {
    echo "Usuário não encontrado.";
}


?>
