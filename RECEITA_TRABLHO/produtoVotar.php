<?php

if(empty($_POST['id'])){
	echo "Esse script nao pode ser acessado diretamente!";
}else{
	
	$id_produto = $_POST['id'];
		
	//Primeiro conectar ao banco
	$conexao = mysqli_connect("localhost","root","","der");
	
	if(!$conexao){
		echo "Erro ao conectar no banco!";
	}else{
        $sql = "UPDATE tb_produto SET votos = votos + 1 WHERE id=".$id_produto.";";
        
		$query = mysqli_query($conexao,$sql);
		
		$produto = [];

		while($dados = mysqli_fetch_array($query)){
            array_push($produto, ["id"=> utf8_encode($dados ['id']),
				"nome"=> utf8_encode($dados ['nome']), 
				"url"=>utf8_encode($dados['url']),
				"receita"=>utf8_encode($dados['receita']),
				"votos"=>utf8_encode($dados['votos'])
            ]);
		}
		echo json_encode($produto);
	}
}
?>