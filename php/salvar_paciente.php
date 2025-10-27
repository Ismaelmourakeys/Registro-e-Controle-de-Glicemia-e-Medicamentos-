<?php
include "conexao.php"; // mantém seu include original

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome   = $_POST['nome']   ?? '';
    $idade  = $_POST['idade']  ?? '';
    $peso   = $_POST['peso']   ?? '';
    $altura = $_POST['altura'] ?? '';
    $sexo   = $_POST['sexo']   ?? '';

    if ($nome && $idade && $peso && $altura && $sexo) {
        // Os nomes das colunas foram ajustados para o seu banco:
        // ID_PC, NOME_PC, IDADE, PESO, ALTURA, SEXO, NATF, controle_dt_ID_DT
        $stmt = $conexao->prepare("
            INSERT INTO paciente (NOME_PC, IDADE, PESO, ALTURA, SEXO, NATF, controle_dt_ID_DT)
            VALUES (?, ?, ?, ?, ?, 0, 9)
        ");
        $stmt->bind_param("sidss", $nome, $idade, $peso, $altura, $sexo);

        if ($stmt->execute()) {
            echo "✅ Paciente cadastrado com sucesso!";
        } else {
            echo "❌ Erro ao cadastrar paciente: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "⚠️ Preencha todos os campos.";
    }
}

$conexao->close();
?>
