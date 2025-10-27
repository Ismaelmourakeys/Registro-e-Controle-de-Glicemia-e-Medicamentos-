<?php

// camada de conexão
include_once("conexao.php");

$nome = $_POST['PACIENTE'];
$idade = $_POST['IDADE'];
$peso = $_POST['PESO'];
$altura = $_POST['ALTURA'];
$sexo = $_POST['SEXO'];

/* Variáveis dos registros */
$sql = "INSERT INTO paciente(NOME_PC,IDADE,PESO,ALTURA,SEXO) VALUES ('$nome','$idade','$peso','$altura','$sexo')";
//mysqli_query($conexao, $sql ) or die("Erro ao tentar cadastrar registro");

//echo "teste de registro";

//header('Location:../index2.html');

//aqui conexão com o banco
if(mysqli_query($conexao, $sql)) {
    mysqli_close($conexao);
	header('Location:../index.html');
} else {
    mysqli_close($conexao);
    $mensagem = '<p>Erro ao tentar cadastrar registro!</p>';
}

?>
