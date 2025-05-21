<?php

session_start();

if($nome = $_SESSION['nome'] == ""){
    header("Location: ../index.html");
}

?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>WalterTech - Ordem de Serviço</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --primary: #00ffe1;
      --dark-bg: #0b0f17;
      --card-bg: #111826;
      --text: #e4e4e4;
      --accent: #05d8b0;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Arial', sans-serif;
      background-color: var(--dark-bg);
      color: var(--text);
      display: flex;
      justify-content: center;
      padding: 2rem;
    }

    .container {
        background: var(--card-bg);
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0, 255, 225, 0.1);
        width: 100%;
        max-width: 700px;
        margin-top: 100px; /* <-- adicione essa linha */
    }


    h2 {
      color: var(--primary);
      text-align: center;
      margin-bottom: 1.5rem;
    }

    label {
      display: block;
      margin-top: 1rem;
      margin-bottom: 0.3rem;
      color: var(--accent);
    }

    input, select, textarea {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid var(--primary);
      background: #0f1117;
      color: var(--text);
    }

    canvas {
      border: 2px dashed var(--accent);
      border-radius: 8px;
      background: #fff;
      margin-top: 0.5rem;
      touch-action: none;
    }

    button {
      width: 100%;
      padding: 12px;
      background: var(--primary);
      color: #000;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      margin-top: 1.5rem;
      cursor: pointer;
    }

    .termos {
      margin-top: 1.5rem;
      font-size: 0.85rem;
      color: #ccc;
    }

        /* =================== NAVBAR =================== */
header {
  width: 100%;
  padding: 20px 40px;
  background: var(--dark-bg);
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: fixed;
  top: 0;
  z-index: 999;
  border-bottom: 1px solid #1a1f2b;
  margin-bottom: 20px;
}

.logo {
  font-size: 1.8rem;
  font-weight: 800;
  color: var(--primary);
}

.nav {
  display: flex;
  gap: 25px;
}

.nav a {
  color: var(--text);
  font-size: 1.3rem;
  text-decoration: none;
  transition: color 0.3s;
}

.nav a:hover {
  color: var(--primary);
}

.mobile-menu {
  display: none;
  font-size: 1.8rem;
  color: var(--text);
  cursor: pointer;
}

/* Responsivo */
@media (max-width: 768px) {
  .nav {
    position: absolute;
    top: 70px;
    right: 20px;
    background: #111826;
    flex-direction: column;
    width: 180px;
    display: none;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0, 255, 225, 0.1);
  }

  .nav.active {
    display: flex;
  }

  .nav a {
    margin: 10px 0;
    text-align: left;
  }

  .mobile-menu {
    display: block;
  }
}
  </style>
</head>
<body>

    <header>
    <div class="logo">OS - WalterTech</div>
    <nav class="nav">
      <a href="logout.php" title="Home"><i class="fa-solid fa-house"></i></a>
    </nav>
    <div class="mobile-menu" onclick="toggleMenu()">
      <i class="fas fa-bars"></i>
    </div>
  </header>


  <div class="container">
    <h2>Ordem de Serviço - WalterTech</h2>
    <label>Nome do Cliente</label>
    <input type="text" id="nome" required>

    <label>Telefone</label>
    <input type="text" id="telefone" required>

    <label>Email</label>
    <input type="email" id="email" required>

    <label>Endereço</label>
    <input type="text" id="endereco" required>

    <label>Serviço Realizado</label>
    <select id="servico">
      <option value="Formatação">Formatação</option>
      <option value="Limpeza Interna">Limpeza Interna</option>
      <option value="Instalação de Software">Instalação de Software</option>
      <option value="Manutenção Geral">Manutenção Geral</option>
      <option value="Outros">Outros</option>
    </select>

    <label>Descrição</label>
    <textarea id="descricao" rows="2"></textarea>

    <label>Prazo</label>
    <input type="text" id="prazo">

    <label>Valor</label>
    <input type="text" id="valor">

    <label>Assinatura do Cliente</label>
    <canvas id="assinatura" width="300" height="100"></canvas>
    <button type="button" onclick="limparAssinatura()">Limpar Assinatura</button>

    <div class="termos">
      Ao autorizar a presente ordem de serviço, o cliente declara estar ciente e de acordo com as condições aqui estabelecidas. A WalterTech se compromete a realizar os serviços de assistência técnica conforme solicitado, sendo estes relacionados à formatação, montagem, manutenção preventiva de desktops e manutenção de sites. O cliente reconhece que a empresa não se responsabiliza por danos anteriores ao recebimento do equipamento, falhas ocultas ou pela perda de dados decorrente de procedimentos como formatação, substituição de peças ou correções de falhas de sistema. Os serviços prestados possuem garantia de 90 dias, limitada exclusivamente à mão de obra executada, não se estendendo a falhas ocasionadas por mau uso, quedas, acesso posterior por terceiros, infecção por vírus ou instalação indevida de softwares. O valor do serviço será previamente acordado com o cliente, sendo que eventuais peças ou componentes necessários serão cobrados à parte, com consentimento do mesmo. O pagamento deverá ser realizado na entrega do equipamento, salvo acordo prévio. O prazo para realização do serviço poderá ser alterado conforme a complexidade do problema ou disponibilidade de peças, sendo o cliente informado em caso de alteração. Equipamentos concluídos e não retirados no prazo de 30 dias estarão sujeitos a cobrança de taxa de armazenamento, podendo, após este período, ser considerados abandonados. A WalterTech garante que todas as informações contidas nos equipamentos serão tratadas com confidencialidade, acessadas apenas quando necessário para execução do serviço. Ao assinar esta ordem de serviço, o cliente confirma ter lido, compreendido e aceitado todos os termos aqui descritos.
    </div>

    <button onclick="gerarPDF()">Gerar PDF</button>
  </div>

  <script>
    function toggleMenu() {
      document.querySelector(".nav").classList.toggle("active");
    }
  </script>


  <script>
    const canvas = document.getElementById("assinatura");
    const ctx = canvas.getContext("2d");
    let desenhando = false;

    // Suporte a toque
    canvas.addEventListener("touchstart", function(e) {
      e.preventDefault();
      desenhando = true;
      const touch = e.touches[0];
      const rect = canvas.getBoundingClientRect();
      ctx.beginPath();
      ctx.moveTo(touch.clientX - rect.left, touch.clientY - rect.top);
    });

    canvas.addEventListener("touchmove", function(e) {
      e.preventDefault();
      if (!desenhando) return;
      const touch = e.touches[0];
      const rect = canvas.getBoundingClientRect();
      ctx.lineTo(touch.clientX - rect.left, touch.clientY - rect.top);
      ctx.stroke();
    });

    canvas.addEventListener("touchend", () => desenhando = false);
    canvas.addEventListener("mousedown", (e) => {
      desenhando = true;
      ctx.beginPath();
      ctx.moveTo(e.offsetX, e.offsetY);
    });

    canvas.addEventListener("mousemove", (e) => {
      if (!desenhando) return;
      ctx.lineTo(e.offsetX, e.offsetY);
      ctx.stroke();
    });

    canvas.addEventListener("mouseup", () => desenhando = false);
    canvas.addEventListener("mouseleave", () => desenhando = false);

    function limparAssinatura() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    async function gerarPDF() {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      const nome = document.getElementById("nome").value;
      const telefone = document.getElementById("telefone").value;
      const email = document.getElementById("email").value;
      const endereco = document.getElementById("endereco").value;
      const servico = document.getElementById("servico").value;
      const descricao = document.getElementById("descricao").value;
      const prazo = document.getElementById("prazo").value;
      const valor = document.getElementById("valor").value;
      const assinaturaImg = canvas.toDataURL("image/png");

      doc.setFont("helvetica", "bold");
      doc.setFontSize(18);
      doc.text("WalterTech - Ordem de Serviço", 105, 20, null, null, "center");

      doc.setFont("helvetica", "normal");
      doc.setFontSize(12);
      let y = 40;

      doc.text(`Cliente: ${nome}`, 20, y); y += 10;
      doc.text(`Telefone: ${telefone}`, 20, y); y += 10;
      doc.text(`Email: ${email}`, 20, y); y += 10;
      doc.text(`Endereço: ${endereco}`, 20, y); y += 10;
      doc.text(`Serviço Realizado: ${servico}`, 20, y); y += 10;
      doc.text("Descrição:", 20, y); y += 10;
      doc.text(doc.splitTextToSize(descricao, 170), 25, y); y += 20;
      doc.text(`Prazo: ${prazo}`, 20, y); y += 10;
      doc.text(`Valor: R$ ${valor}`, 20, y); y += 20;

      doc.setFont("helvetica", "italic");
      doc.text("Termos:", 20, y); y += 10;
      doc.setFont("helvetica", "normal");
      doc.text(doc.splitTextToSize("Ao assinar esta Ordem de Serviço, o cliente concorda com os termos de execução, prazos e valores acordados. A WalterTech não se responsabiliza por danos decorrentes de mau uso posterior ao serviço.", 170), 25, y); y += 30;

      doc.text("Assinatura do Cliente:", 20, y); y += 10;
      doc.addImage(assinaturaImg, "PNG", 20, y, 100, 40);

      doc.save(`OS_${nome}.pdf`);
    }
  </script>
</body>
</html>