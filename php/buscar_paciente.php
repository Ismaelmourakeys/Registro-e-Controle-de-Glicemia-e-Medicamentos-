<?php
include __DIR__ . '/conexao.php'; // mantém sua conexão original

$nome = $_GET['nome'] ?? '';

if (!$nome) {
    exit("Nome do paciente não informado.");
}

// Ajustando os nomes das colunas para o seu banco:
$stmt = $conexao->prepare("
    SELECT 
        p.ID_PC, 
        p.NOME_PC, 
        p.IDADE, 
        p.PESO, 
        p.ALTURA, 
        p.SEXO,
        m.medicamento AS medicamento, 
        m.dose_med AS dosagem, 
        m.tipo AS tipo
    FROM paciente p
    LEFT JOIN medicamento m ON p.ID_PC = m.paciente_ID_PC
    WHERE p.NOME_PC LIKE ?
");

if (!$stmt) {
    die("Erro na preparação da consulta: " . $conexao->error);
}

$like = "%$nome%";
$stmt->bind_param("s", $like);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>Nenhum paciente encontrado.</p>";
    exit;
}

echo "<table border='1' style='width:100%;border-collapse:collapse;'>";
echo "<tr>
        <th>Nome</th>
        <th>Idade</th>
        <th>Peso</th>
        <th>Altura</th>
        <th>Sexo</th>
        <th>Medicamento</th>
        <th>Dosagem</th>
        <th>Tipo</th>
      </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['NOME_PC']}</td>
        <td>{$row['IDADE']}</td>
        <td>{$row['PESO']}</td>
        <td>{$row['ALTURA']}</td>
        <td>{$row['SEXO']}</td>
        <td>{$row['medicamento']}</td>
        <td>{$row['dosagem']}</td>
        <td>{$row['tipo']}</td>
    </tr>";
}

echo "</table>";

$stmt->close();
$conexao->close();
?>
