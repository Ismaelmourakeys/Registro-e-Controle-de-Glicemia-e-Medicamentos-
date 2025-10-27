<?php
include_once("conexao.php");

$pacienteID = $_GET['paciente_ID_PC'] ?? 0;
if(!$pacienteID){
    echo json_encode(['labels'=>[], 'data'=>[]]);
    exit;
}

$sql = "SELECT Date, GLICOSE FROM controle_dt WHERE paciente_ID_PC=? ORDER BY Date ASC";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $pacienteID);
$stmt->execute();
$result = $stmt->get_result();

$labels = [];
$data = [];

while($row = $result->fetch_assoc()){
    $labels[] = $row['Date'];
    $data[] = $row['GLICOSE'];
}

$stmt->close();
$conexao->close();

echo json_encode(['labels'=>$labels,'data'=>$data]);
?>
