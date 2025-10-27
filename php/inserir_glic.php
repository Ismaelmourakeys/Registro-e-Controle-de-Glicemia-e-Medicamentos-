<?php
include_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pacienteID = $_POST['paciente_ID_PC'] ?? '';
    $vlglic = $_POST['GLICEMIA'] ?? '';
    $data = $_POST['data'] ?? '';
    $hora = $_POST['hora'] ?? '';

    if (!$pacienteID || !$vlglic || !$data || !$hora) {
        echo "⚠️ Todos os campos são obrigatórios!";
        exit;
    }

    $stmt = $conexao->prepare("INSERT INTO controle_dt (GLICOSE, paciente_ID_PC, Date) VALUES (?, ?, CONCAT(?, ' ', ?))");
    $stmt->bind_param("diis", $vlglic, $pacienteID, $data, $hora);

    if ($stmt->execute()) {
        echo "✅ Glicemia registrada com sucesso!";
    } else {
        echo "❌ Erro ao tentar cadastrar registro: " . $stmt->error;
    }

    $stmt->close();
    $conexao->close();
} else {
    echo "⚠️ Requisição inválida!";
}
?>
