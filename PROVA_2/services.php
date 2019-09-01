<?php

if(!empty($_GET['servico'])){
	
	$servico = $_GET['servico'];
	
	//Primeiro conectar ao banco
	//servidor, login, senha, banco
	$conexao = mysqli_connect("localhost","root","","filmes_youtube");
	
	if(!$conexao){
		echo "Erro ao conectar no banco!";
	}else{

		//Listagem
		if($servico == "listagem"){

			$sql = "SELECT * FROM tb_filmes;";
			$query = mysqli_query($conexao, $sql);
			$videos = [];
		
			while($dados = mysqli_fetch_array($query)){
				array_push($videos, ["id"=>utf8_encode($dados ['id']),
					"nome"=>utf8_encode($dados ['nome']),
					"id_Youtube"=>utf8_encode($dados ['id_youtube']),
					"comentario"=>utf8_encode($dados ['comentario'])
				]);
			}

			echo json_encode($videos);
		}
		
		//Inserir
		if($servico == "inserir" && !empty($_POST['nome']) && !empty($_POST['id_Youtube'])){
			$nome= $_POST['nome'];
			$id_Youtube= $_POST['id_Youtube'];

			$sql = "INSERT INTO `tb_filmes` (`nome`, `id_Youtube`) VALUES('".$nome."', '".$id_Youtube."');";
	
			$query = mysqli_query($conexao,$sql);

			if($query){
				echo 1;
			}else{
				echo 0;
			}
	
		}

		//Deletar
		if($servico == "deletar" && !empty($_GET['id'])){

			$id = $_GET['id'];
			
			$sql = "DELETE FROM tb_filmes WHERE id=".$id.";";
			
			$query = mysqli_query($conexao,$sql);

			if($query){
				echo 1;
			}else{
				echo 0;
			}
		}

		//Comentar
		if($servico == "comentar" && !empty($_GET['id'])){

			$id = $_GET['id'];
			$comentario = $_POST['comentario'];

			$sql = "UPDATE tb_filmes SET comentario = '".$comentario."' WHERE id=".$id.";";
			
			$query = mysqli_query($conexao,$sql);
			
			if($query){
				echo 1;
			}else{
				echo 0;
			}
		}
	}
	
}else{
	
	echo "Esse script não pode ser acessado diretamente";
	
}
?>