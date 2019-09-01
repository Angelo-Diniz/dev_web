<?php
	
$receita = $_POST['receita'];
$nome = $_POST['nome'];
$url = $_POST['url'];

//Primeiro conectar ao banco
$conexao = mysqli_connect("localhost","root","","der");

if(!$conexao){
    echo "Erro ao conectar no banco!";
}else{
    $sql = "INSERT INTO tb_produto(id, nome, url, receita, votos) VALUES (NULL,'".$nome."','".$url."','".$receita."',0)";

    $query = mysqli_query($conexao,$sql);
    $produto = [];
    
    echo $query;
	}

?>