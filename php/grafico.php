<?php
include_once("conexao.php");

$nome = $_GET['nome'] ?? '';

if (!$nome) {
    echo json_encode(['labels' => [], 'data' => []]);
    exit;
}

$sql = "
SELECT g.DATA_MEDICAO, g.GLICEMIA
FROM glicemia g
INNER JOIN paciente p ON g.paciente_ID_PC = p.ID_PC
WHERE p.NOME_PC LIKE ?
ORDER BY g.DATA_MEDICAO ASC
";

$stmt = $conexao->prepare($sql);
$busca = "%$nome%";
$stmt->bind_param("s", $busca);
$stmt->execute();
$result = $stmt->get_result();

$labels = [];
$data = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['DATA_MEDICAO'];
    $data[] = $row['GLICEMIA'];
}

echo json_encode(['labels' => $labels, 'data' => $data]);

$stmt->close();
$conexao->close();
?>
