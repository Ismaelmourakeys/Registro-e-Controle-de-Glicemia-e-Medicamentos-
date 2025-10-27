<?php
// buscar_medicamento.php
include_once __DIR__ . '/conexao.php';

// valida id
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "<p>Paciente inválido.</p>";
    exit;
}

// Garante conexão (fallback)
if (!isset($conexao) || !(@mysqli_ping($conexao))) {
    if (defined('HOST') && defined('USUARIO') && defined('SENHA') && defined('DB')) {
        $conexao = mysqli_connect(HOST, USUARIO, SENHA, DB) or die('Erro ao conectar (fallback).');
    } else {
        die('Conexão indisponível.');
    }
}

// Buscar medicamentos do paciente
$stmt = $conexao->prepare("SELECT medicamento, dose_med, tipo FROM medicamento WHERE paciente_ID_PC = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "<p>❌ Nenhum medicamento encontrado para este paciente.</p>";
    $stmt->close();
    exit;
}

echo "<table style='width:100%;border-collapse:collapse;' border='1'>";
echo "<tr><th>Medicamento</th><th>Dose</th><th>Tipo</th></tr>";
while ($row = $res->fetch_assoc()) {
    $med = htmlspecialchars($row['medicamento']);
    $dose = htmlspecialchars($row['dose_med']);
    $tipo = htmlspecialchars($row['tipo']);
    echo "<tr><td>{$med}</td><td>{$dose}</td><td>{$tipo}</td></tr>";
}
echo "</table>";

$stmt->close();
// não fechamos $conexao aqui (evita conflitos)
?>
