<?php

// camada de conexão
include_once("conexao.php");

$NOME_PC= $_POST['NOME_PC'];
$IDADE = $_POST['IDADE'];
$PESO = $_POST['PESO'];
$ALTURA = $_POST['ALTURA'];
$SEXO = $_POST['SEXO'];

/* Variáveis dos registros */
$sql = "INSERT INTO 'paciente' VALUES ";
$sql .= " ('$NOME_PC', '$IDADE', '$PESO','$ALTURA', '$SEXO')";

echo "teste";
//header('Location:../index2.html');

 
aqui conexão com o banco
if(mysqli_query($conexao, $sql)) {
    mysqli_close($conexao);
	header('Location:../index2.html');
    $mensagem = '<p>Registro efetuado com sucesso!</p>';
} else {
    mysqli_close($conexao);
    $mensagem = '<p>Erro ao tentar cadastrar registro!</p>';
}
?>
