<?php
	
	// Criando tabela e cabeçalho de dados:
	echo "<table border=2 align='center'>";
	echo "<tr>";
	echo "<th>Medicamento</th>";
	echo "<th>Dosagem</th>";
	echo "<th>Tipo</th>";
	echo "</tr>";
	
	// Conectando ao banco de dados:
	//$conexao = mysqli_connect('localhost','root','','diabetes') or die('Erro ao conectar ao servidor');
	include_once("conexao.php");
	
	

	//realiza a intrução sql
	$sql = "select `MEDICAMENTO`,`DOSAGEM`,`TIPO` from `medicamento`";

	$resultado = mysqli_query($conexao,$sql) or die("Erro ao retornar dados");
	

	// Obtendo os dados por meio de um loop while
	while ($reg = mysqli_fetch_array($resultado))
	{
		$medicamento = $reg['MEDICAMENTO'];
		$dosagem = $reg['DOSAGEM'];
		$tipo = $reg['TIPO'];
		
		echo "<tr>";
		echo "<td>".$medicamento."</td>";
		echo "<td>".$dosagem."</td>";
		echo "<td>".$tipo."</td>";
		echo "</tr>";
	}
	
	mysqli_close($conexao);
	echo "</table>";
?>