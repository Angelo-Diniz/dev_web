<?php
		
	//Primeiro conectar ao banco
	$conexao = mysqli_connect("localhost","root","","der");
	
	if(!$conexao){
		echo "Erro ao conectar no banco!";
	}else{

		$sql = "SELECT * FROM tb_produto order by votos desc;";
		$query = mysqli_query($conexao,$sql);
		
		$receitas = [];

		while($dados = mysqli_fetch_array($query)){
            array_push($receitas, ["id"=> utf8_encode($dados ['id']),
				"nome"=> utf8_encode($dados ['nome']), 
				"url"=>utf8_encode($dados['url']),
				"receita"=>utf8_encode($dados['receita']),
				"votos"=>utf8_encode($dados['votos'])
            ]);
		}
		echo json_encode($receitas);
	
}
?>