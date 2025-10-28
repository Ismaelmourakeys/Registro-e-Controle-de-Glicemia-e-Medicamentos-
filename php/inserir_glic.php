<?php
include_once("conexao.php");

$paciente = $_POST['paciente_ID_PC'] ?? '';
$vlglic = $_POST['GLICEMIA'] ?? '';
$data = $_POST['data'] ?? '';
$hora = $_POST['hora'] ?? '';

if (!$paciente || !$vlglic || !$data || !$hora) {
    echo "❌ Dados incompletos!";
    exit;
}

$stmt = $conexao->prepare("INSERT INTO controle_dt (PACIENTE_ID_PC, GLICOSE, DATA, HORA) VALUES (?, ?, ?, ?)");
$stmt->bind_param("idss", $paciente, $vlglic, $data, $hora);

if ($stmt->execute()) {
    echo "✅ Registro salvo com sucesso!";
} else {
    echo "❌ Erro ao salvar registro: " . $stmt->error;
}

$stmt->close();
$conexao->close();
?>
