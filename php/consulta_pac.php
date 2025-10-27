<?php
// consulta_pac.php
// Mostra todos os pacientes e permite clicar no nome para ver medicamentos

// Inclui apenas as constantes da conexão
include_once __DIR__ . '/conexao.php';

// Cria uma nova conexão local, independente de conexões anteriores
$conexao_local = mysqli_connect(HOST, USUARIO, SENHA, DB) or die('Erro ao conectar ao servidor.');

// Faz a consulta
$sql = "SELECT ID_PC, NOME_PC, IDADE, PESO, ALTURA, SEXO FROM paciente ORDER BY NOME_PC";
$resultado = mysqli_query($conexao_local, $sql);

echo "<table border='2' bordercolor='#B0E0E6' align='center' style='width:100%;border-collapse:collapse;'>";
echo "<tr>
        <th>Nome</th>
        <th>Idade</th>
        <th>Peso</th>
        <th>Altura</th>
        <th>Sexo</th>
      </tr>";

if ($resultado && mysqli_num_rows($resultado) > 0) {
    while ($reg = mysqli_fetch_assoc($resultado)) {
        $id = $reg['ID_PC'];
        $paciente = htmlspecialchars($reg['NOME_PC']);
        $idade = htmlspecialchars($reg['IDADE']);
        $peso = htmlspecialchars($reg['PESO']);
        $altura = htmlspecialchars($reg['ALTURA']);
        $sexo = htmlspecialchars($reg['SEXO']);

        // Linha clicável
        echo "<tr style='cursor:pointer' onclick=\"buscarMedicamentos($id)\">";
        echo "<td align='center'>{$paciente}</td>";
        echo "<td align='center'>{$idade}</td>";
        echo "<td align='center'>{$peso}</td>";
        echo "<td align='center'>{$altura}</td>";
        echo "<td align='center'>{$sexo}</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5' align='center'>Nenhum paciente cadastrado.</td></tr>";
}

echo "</table>";

// Fecha apenas a conexão local
mysqli_close($conexao_local);
?>
