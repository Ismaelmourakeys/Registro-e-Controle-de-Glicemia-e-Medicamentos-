<?php 
/* Dom iniciando com php 
		delimitadores*/
		
		echo'Conexão com registro'."<br>";
		echo date('d/m/Y');
		echo"<hr>";
		
		echo " <h2 align='center'> <a href='../index.html'> Logar na tela principal </a> </h2>";
				
		
		echo'definindo variaveis'."<br>";
		
		//servidor
		$servidor = "localhost";
		$usuario = "root";
		$senha = "";
		$banco = "diabetes";
		
		//camada de conexão
		$conexao = mysqli_connect($servidor, $usuario, $senha, $banco)
		or die ("Não foi possível conectar ao servidor MySQL");
?>

