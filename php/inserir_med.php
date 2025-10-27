<?php

// camada de conexão
include_once("conexao.php");

$nome = $_POST['MEDICAMENTO'];
$dosagem = $_POST['DOSAGEM'];
$tipo = $_POST['TIPO'];

/* Variáveis dos registros */
$sql = "INSERT INTO medicamento(medicamento, dose_med, tipo) VALUES ('$nome','$dosagem','$tipo')"; 
//mysqli_query($conexao, $sql) or die("Erro ao tentar cadastrar registro");

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
