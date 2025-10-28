<?php
include_once("./php/conexao.php");

// Busca os pacientes
$sql = "SELECT ID_PC, NOME_PC FROM paciente ORDER BY NOME_PC ASC";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Registrar Glicemia</title>
<style>
body { 
    font-family: Arial; 
    background:#f8f8f8; 
    padding:20px; 
    text-align:center; 
}
.form-container { 
    background:white; 
    width:500px; 
    margin:auto; 
    padding:20px; 
    border-radius:8px; 
    box-shadow:0 3px 8px rgba(0,0,0,0.2);
}
.form-container h2 { background:#0288d1; color:white; padding:15px; border-radius:8px 8px 0 0; margin:-20px -20px 20px -20px;}
.form-group { margin:15px 0; text-align:left; }
.form-group label { display:block; margin-bottom:5px; font-weight:bold; }
.form-group input, .form-group select { width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; }
.btn-registrar { background:#2e7d32; color:white; padding:10px 20px; border:none; border-radius:5px; cursor:pointer; font-weight:bold; margin-top:10px; }
.btn-registrar:hover { background:#1b5e20; }
.resultado { margin-top:15px; font-weight:bold; color:#333; }
.btn-voltar { display:inline-block; margin-top:20px; text-decoration:none; color:#0288d1; font-weight:bold; }
.btn-voltar:hover { text-decoration:underline; }
</style>
</head>
<body>

<div class="form-container">
<h2>Registrar Glicemia</h2>

<div class="form-group">
<label for="pacienteSelect">Selecione o Paciente:</label>
<select id="pacienteSelect">
  <?php
  if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
          echo '<option value="'.$row['ID_PC'].'">'.htmlspecialchars($row['NOME_PC']).'</option>';
      }
  } else {
      echo '<option value="">Nenhum paciente cadastrado</option>';
  }
  ?>
</select>
</div>

<div class="form-group">
<label for="valorGlicemia">Valor Glicemia (mg/dL):</label>
<input type="number" id="valorGlicemia" placeholder="Digite o valor" required>
</div>

<div class="form-group">
<label for="dataMedicao">Data:</label>
<input type="date" id="dataMedicao" required>
</div>

<div class="form-group">
<label for="horaMedicao">Hora:</label>
<input type="time" id="horaMedicao" required>
</div>

<button class="btn-registrar" onclick="registrarGlicemia()">Registrar</button>
<div id="resultado" class="resultado"></div>
</div>

<a class="btn-voltar" href="index.php">Voltar a tela de controle</a>

<script>
function registrarGlicemia() {
    const pacienteID = document.getElementById("pacienteSelect").value;
    const valor = document.getElementById("valorGlicemia").value;
    const data = document.getElementById("dataMedicao").value;
    const hora = document.getElementById("horaMedicao").value;

    if (!pacienteID || !valor || !data || !hora) {
        document.getElementById("resultado").innerText = "⚠️ Preencha todos os campos!";
        document.getElementById("resultado").style.color="red";
        return;
    }

    fetch("./php/inserir_glic.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `paciente_ID_PC=${pacienteID}&GLICEMIA=${valor}&data=${data}&hora=${hora}`
    })
    .then(r => r.text())
    .then(msg => {
        document.getElementById("resultado").innerText = msg;
        document.getElementById("resultado").style.color = msg.includes("✅") ? "green" : "red";
    })
    .catch(err => {
        console.error(err);
        document.getElementById("resultado").innerText = "❌ Erro ao registrar glicemia!";
        document.getElementById("resultado").style.color="red";
    });
}
</script>

</body>
</html>
