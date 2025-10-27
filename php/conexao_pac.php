<?php
//DEFINIÇÕES PADRÃO
    define('HOST' , "localhost");
    define('USUARIO' , "root");
    define('SENHA' , "");
    define('DB' , "diabetes"); 

//TESTE DE CONEXÃO
$conexao = mysqli_connect(HOST , USUARIO , SENHA , DB ) or die ("Erro de conexão com o Banco de Dados!");
?>