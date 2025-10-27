<?php
include "conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paciente_nome = $_POST['paciente_nome'] ?? '';
    $medicamento = $_POST['medicamento'] ?? '';
    $dosagem = $_POST['dosagem'] ?? '';
    $tipo = $_POST['tipo'] ?? '';

    if ($paciente_nome && $medicamento && $dosagem && $tipo) {
        // Localiza o paciente pelo nome (ajustado para o campo NOME_PC)
        $busca = $conexao->prepare("SELECT ID_PC FROM paciente WHERE NOME_PC = ?");
        $busca->bind_param("s", $paciente_nome);
        $busca->execute();
        $resultado = $busca->get_result();

        if ($resultado->num_rows > 0) {
            $paciente = $resultado->fetch_assoc();
            $paciente_id = $paciente['ID_PC'];

            // Inserção ajustada para os nomes do seu banco: 
            // ID_MED, medicamento, dose_med, tipo, paciente_ID_PC
            $stmt = $conexao->prepare("
                INSERT INTO medicamento (medicamento, dose_med, tipo, paciente_ID_PC)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param("sdsi", $medicamento, $dosagem, $tipo, $paciente_id);

            if ($stmt->execute()) {
                echo "✅ Medicamento cadastrado com sucesso!";
            } else {
                echo "❌ Erro ao cadastrar medicamento: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "⚠️ Paciente não encontrado.";
        }

        $busca->close();
    } else {
        echo "⚠️ Preencha todos os campos.";
    }
}

$conexao->close();
?>
