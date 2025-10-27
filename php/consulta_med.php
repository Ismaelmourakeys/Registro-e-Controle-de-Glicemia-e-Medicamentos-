<?php
	
	// Criando tabela e cabeçalho de dados:
	echo "<table border=2 bordercolor='#B0E0E6' align='center' >";
	echo "<tr>";
	echo "<th>Medicamento</th>";
	echo "<th>Dosagem</th>";
	echo "<th>Tipo</th>";
	echo "</tr>";
	
	// Conectando ao banco de dados:
	//$conexao = mysqli_connect('localhost','root','','diabetes') or die('Erro ao conectar ao servidor');
	include_once("conexao.php");
	
	

	//realiza a intrução sql
	$sql = "select `medicamento`,`dose_med`,`tipo` from `medicamento`";

	$resultado = mysqli_query($conexao,$sql) or die("Erro ao retornar dados");
	

	// Obtendo os dados por meio de um loop while
	while ($reg = mysqli_fetch_array($resultado))
	{
		$medicamento = $reg['medicamento'];
		$dosagem = $reg['dose_med'];
		$tipo = $reg['tipo'];
		
		echo "<tr>";
		echo "<td align='center'>".$medicamento."</td>";
		echo "<td align='center'>".$dosagem."</td>";
		echo "<td align='center'>".$tipo."</td>";
		echo "</tr>"; 	
	}
	
	mysqli_close($conexao);
	echo "</table>";
?>