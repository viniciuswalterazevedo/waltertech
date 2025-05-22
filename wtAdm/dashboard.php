<?php
session_start();

// Definição de session a encargo de testes
// $_SESSION['id_usuario'] = "1";
// $_SESSION['nome'] = "Vinicius Walter";
// $_SESSION['email'] = "viniciuswalterazevedo1202@waltertech.com";

$id_usuario = $_SESSION['id_usuario'];
$nome = $_SESSION['nome'];
$email = $_SESSION['email'];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel de Controle | WalterTech</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }
    body {
      display: flex;
      background: #0089bf;
      background: linear-gradient(173deg, #0b0f17 0%, #0b0f17 100%);
    }
    .sidebar {
      width: 250px;
      background-color: #111826;
      color: white;
      padding: 20px 0;
      min-height: 100vh;
    }
    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 24px;
    }
    .sidebar ul {
      list-style: none;
    }
    .sidebar ul li {
      padding: 15px 25px;
      cursor: pointer;
      display: flex;
      align-items: center;
    }
    .sidebar ul li:hover,
    .sidebar ul li.active {
      background-color: #68000000;
    }
    .sidebar ul li i {
      margin-right: 15px;
    }
    .sidebar .user {
      margin-top: auto;
      padding: 20px 25px;
      display: flex;
      align-items: center;
      gap: 10px;
      background-color: #d32f2f00;
    }
    
    .sidebar .user img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
    }
    .main {
      flex: 1;
      padding: 30px;
    }
    .main-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 50px;
      color: #e3f2fd;
    }
    .main-header input {
      padding: 10px;
      width: 300px;
      border-radius: 20px;
      border: 1px solid #ccc;
      padding-left: 40px;
      background-image: url('https://cdn-icons-png.flaticon.com/512/622/622669.png');
      background-repeat: no-repeat;
      background-position: 10px center;
      background-size: 20px;
    }
    .cards {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .card {
      background-color: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      flex: 1;
      min-width: 250px;
      position: relative;
    }
    .card i {
      font-size: 24px;
      padding: 10px;
      border-radius: 10px;
      margin-bottom: 10px;
    }
    .card.red i { background-color: #fce4ec; color: #e91e63; }
    .card.blue i { background-color: #e3f2fd; color: #2196f3; }
    .card.green i { background-color: #e8f5e9; color: #4caf50; }
    .card.orange i { background-color: #fff3e0; color: #fb8c00; }
    .card h3 {
      font-size: 14px;
      color: gray;
      margin-bottom: 10px;
    }
    .card h2 {
      font-size: 24px;
      margin-bottom: 5px;
    }
    .card p {
      font-size: 14px;
    }
    .positive { color: green; }
    .negative { color: red; }
    .titulo{
      text-align: center;
    }
    a{
        text-decoration: none;
        color: #ffff;
    }
  </style>
</head>
<body>

    <?php
        if ($email == "") {

            echo "<script>
                Swal.fire({
                    title: 'Login não realizado!',
                    icon: 'error'
                }).then(() => {
                    window.location.href = '../index.html';
                });
            </script>";

        } else{
            include_once('conexao.php');
        }
    ?>
  
  <div class="sidebar">
    <div class="user">
              
      <div>
        <strong><?php echo $nome;?></strong>
        <p style="font-size: 12px;">Administrador</p>
      </div>
    </div>

    <ul>
    <a href="home.php"><li class="active"><i class="fas fa-home"></i>Home</li></a>
      <li><i class="fas fa-chart-line"></i>Análises</li>
      <li><i class="fas fa-shopping-cart"></i>Vendas</li>
      <li><i class="fas fa-users"></i>Clientes</li>
      <li><i class="fas fa-box"></i>Produtos</li>
    </ul>
  </div>

  <div class="main">
    <div class="main-header">
      <div class="titulo">
        <h1>Painel de Controle</h1>
        <p>Bem-vindo de volta, <?php echo $nome;?>!</p>
      </div>
    </div>
    <div class="cards">
      <div class="card blue">
        <i class="fas fa-shopping-bag"></i>
        <h3>Lucro Bruto</h3>
        <h2>
            <?php
                $sql = "SELECT SUM(valor) AS total_faturado FROM servico";
                $resultado = $conn->query($sql);
                $rowValor = $resultado->fetch_assoc();
                echo $rowValor['total_faturado'];
            ?>
        </h2>
      </div>
      <div class="card blue">
        <i class="fas fa-user"></i>
        <h3>Total de Clientes</h3>
        <h2>
            <?php
                $sql2 = "SELECT * FROM servico";
                $resultado = $conn->query($sql2);

                echo $resultado->num_rows;
            ?>
        </h2>
      </div>
      <div class="card green">
        <i class="fas fa-chart-line"></i>
        <h3>Meus Serviços</h3>
        <h2>
            <?php
                $sql3 = "SELECT * FROM servico WHERE id_usuario = '$id_usuario'";
                $resultado = $conn->query($sql3);

                echo $resultado->num_rows;
            ?>
        </h2>
      </div>
      <div class="card orange">
        <i class="fas fa-box-open"></i>
        <h3>Funcionários</h3>
        <h2>
            <?php
                $sql4 = "SELECT * FROM usuarios";
                $resultado = $conn->query($sql4);

                echo $resultado->num_rows;
            ?>
        </h2>
      </div>
    </div>
  </div>
</body>
</html>
