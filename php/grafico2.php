<?php
$conn = new mysqli("localhost", "root", "", "diabetes");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT DATA, GLICEMIA FROM controle_dt ORDER BY data_registro ASC";
$result = $conn->query($sql);

$labels = [];
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['DATA'];
        $data[] = $row['GLICEMIA'];
    }
}

$conn->close();
?>
