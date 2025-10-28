<?php
include_once("./conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $paciente_ID_PC = $_POST["paciente_ID_PC"] ?? "";
    $glicemia = $_POST["GLICEMIA"] ?? "";
    $data = $_POST["data"] ?? "";
    $hora = $_POST["hora"] ?? "";

    if ($paciente_ID_PC && $glicemia && $data && $hora) {
        $stmt = $conexao->prepare("INSERT INTO glicemia (paciente_ID_PC, GLICEMIA, DATA, HORA) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("idss", $paciente_ID_PC, $glicemia, $data, $hora);

        if ($stmt->execute()) {
            echo "✅ Glicemia registrada com sucesso!";
        } else {
            echo "❌ Erro ao registrar: " . $conexao->error;
        }

        $stmt->close();
    } else {
        echo "⚠️ Dados incompletos!";
    }
} else {
    echo "Método inválido!";
}
?>
