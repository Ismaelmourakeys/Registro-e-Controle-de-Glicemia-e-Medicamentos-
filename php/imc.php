<?php

    // Configurações do banco de dados
        $host = 'localhost';
        $db = 'diabetes'; // Nome do banco de dados
        $user = 'root';
        $pass = '';
        
        // Conexão com o banco de dados
        $conn = new mysqli($host, $user, $pass, $db);
        
        // Verifica a conexão
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }
        
		if (isset($_POST["nome_pc"]) && !empty($_POST["nome_pc"])) {
			$nomePaciente = $_POST["nome_pc"];

		// É crucial usar prepared statements para prevenir SQL injection
			$sql = "SELECT ID_PC, NOME_PC, PESO, ALTURA, PESO / (ALTURA * ALTURA) AS IMC FROM paciente WHERE NOME_PC = ?";
			$stmt = mysqli_prepare($conn, $sql);

			if ($stmt) {
			// "s" indica que o parâmetro é uma string
				mysqli_stmt_bind_param($stmt, "s", $nomePaciente);
				mysqli_stmt_execute($stmt);
				$resultado = mysqli_stmt_get_result($stmt);

				if ($resultado && mysqli_num_rows($resultado) > 0) {
					$linha = mysqli_fetch_assoc($resultado);
					echo "<h2>IMC de " . htmlspecialchars($linha['NOME_PC']) . "</h2>";
					//echo "ID: " . $linha['ID_PC'] . "<br>";
					echo "Nome: " . htmlspecialchars($linha['NOME_PC']) . "<br>";
					echo "Peso: " . $linha['PESO'] . " kg<br>";
					echo "Altura: " . $linha['ALTURA'] . " m<br>";
					echo "IMC: " . number_format($linha['IMC'], 2) . "<br>"; // Formata o IMC para 2 casas decimais
				} else {
					echo "Paciente '" . htmlspecialchars($nomePaciente) . "' não encontrado.";
					}

			mysqli_stmt_close($stmt);
			} else {
					echo "Erro na preparação da query: " . mysqli_error($conexao);
				}
		} else {
				echo "Nenhum nome de paciente foi fornecido.";
			}
			
        // Fecha a conexão com o banco de dados
        $conn->close();
        ?>
        

