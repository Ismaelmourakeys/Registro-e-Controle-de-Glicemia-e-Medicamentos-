<?php
include 'conexao.php';

$msg = "";

if (isset($_POST['salvarGlicemia'])) {
    $valor = $_POST['valor'] ?? '';
    $data  = $_POST['data'] ?? '';
    $hora  = $_POST['hora'] ?? '';

    if ($valor && $data && $hora) {
        $sql = "INSERT INTO glicemia (valor, data_medicao, hora_medicao) 
                VALUES ('$valor', '$data', '$hora')";
        $msg = mysqli_query($con, $sql) ?
            "✅ Glicemia registrada: $valor mg/dL em $data às $hora" :
            "❌ Erro: ".mysqli_error($con);
    } else {
        $msg = "⚠️ Preencha todos os campos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Registrar Glicemia</title>
<style>
body{font-family:Arial;background:#f8f8f8;padding:20px;text-align:center}
.form-container{background:#fff;width:400px;margin:auto;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,.2);padding:20px}
h2{background:#0288d1;color:#fff;margin:-20px -20px 20px -20px;padding:15px;border-radius:8px 8px 0 0}
label{display:block;text-align:left;margin-top:10px}
input{width:100%;padding:8px;margin-top:4px}
button{margin-top:15px;width:100%;padding:10px;background:#2e7d32;color:#fff;border:none;border-radius:6px;cursor:pointer;font-weight:bold}
button:hover{background:#1b5e20}
.msg{margin-top:15px;font-weight:bold;color:#333}
a{display:inline-block;margin-top:15px;color:purple;text-decoration:none;font-weight:bold}
</style>
</head>
<body>

<a href="index.php">⬅ Voltar para Controle</a>

<div class="form-container">
<h2>Registrar Glicemia</h2>
<form method="POST">
    <label>Valor Glicemia:<input type="number" step="0.1" name="valor"></label>
    <label>Data da Medição:<input type="date" name="data"></label>
    <label>Hora da Medição:<input type="time" name="hora"></label>
    <button type="submit" name="salvarGlicemia">Registrar</button>
</form>
<div class="msg"><?php echo $msg; ?></div>
</div>

</body>
</html>
