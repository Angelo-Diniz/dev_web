// JavaScript Document

$(document).ready(function(){

	atualizar_listagem();

	//INSERIR
	$('#btnEnviar').click(function(){
		
		var nome = $('#nomeFilme').val();
		var id_Youtube = $('#idYoutube').val();
		
		if(nome == "" || id_Youtube.length > 11){
			alert("Você deve preencher o nome do video e o id do yotube de 11 caracteres");
			
		}else{
			
			$.ajax({
				  method: "POST",
				  url: "services.php?servico=inserir",
					data: { 
						nome: nome, 
						id_Youtube: id_Youtube
					 }
				})
				.done(function( retorno ) {

					if(retorno =="1"){
						atualizar_listagem();
						
						$('#nomeFilme').val("");
						$('#idYoutube').val("");
						alert("Video Inserido com sucesso! Aproveite : ) ");

					}else{
						alert("Erro ao inserir dados no sistema");
					}				

				});	
		}
				
	});
	
	//DELETAR
	$(document).on('click','.btDelete',function(){
		
		var id = $(this).attr("data-id");
		var card = $(this).closest(".card_Video"); 
		
		var x;
		var r=confirm("Confirmar exclusão do video ? ");

		if (r==true)
		{
			$.ajax({
				method: "POST",
				url: "services.php?servico=deletar&id="+id,
			  })
			  .done(function( retorno ) {
  
				  if(retorno =="1"){
					  card.fadeOut(500, function(){
						  card.remove();
					  });
				  }else{
					  alert("Erro ao apagar dados no sistema");
				  }				
  
			  });		
		}
		else
		{
			alert("Operação Cancelada");
		}
		
		
			
				
	});
	
	$(document).on('click','.btComentar',function(){
		var id = $(this).attr("data-id");
		var comentario = $("#comentario"+id+"").val();
		
		if(comentario){
			$.ajax({
				  method: "POST",
				  url: "services.php?servico=comentar&id="+id,
				  data : {
					  comentario : comentario
				  }
				})
				.done(function( retorno ) {

					if(retorno =="1"){
						alert("Comentario inserido!");
						atualizar_listagem();

					}else{
						alert("Erro ao escrever comentario no sistema");
					}
				});
			
		}else{
			alert("Você não escreveu nenhum comentario :_(!");
		}
		
				
	});
	
});


var atualizar_listagem = function(){

	//LISTAGEM
	$.ajax({
	  method: "POST",
	  url: "services.php?servico=listagem",
	})
	.done(function( retorno ) {

		if(retorno =="[]"){
			$("#conteudoVideos").html("Video não encontrado!");
		}else{

		//Limpa o que tem em conteúdo						
		$("#conteudoVideos").html("");

		//Loop para processar o JSON
		$.each(JSON.parse(retorno), function (key, item) {
			$("#conteudoVideos").append(template_Youtube(item['id'],item['nome'],item['id_Youtube'],item['comentario']));	
		});
		}
	});	
	
}

var template_Youtube = function(id,nome,id_Youtube,comentario){

	return '' +
		'<div class="card_Video form-group col-md-6 col-sm-12"> ' + 
			'<div id="videoPlay" class="embed-responsive embed-responsive-16by9">'+
				'<button id="btDelete" class="btDelete btn btn-danger" data-id="'+id+'">X</button>'+
				'<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'+id_Youtube+'" allowfullscreen></iframe>'+
			'</div>'+
			'<label for="nomeDoFilme" id="nomeDoFilme">'+nome+'</label>'+
			'<textarea class="form-control" rows="5" id="comentario'+id+'" placeholder="COMENTARIO">'+comentario+'</textarea>'+
			'<button type="button" data-id="'+id+'" class="btComentar btn btn-primary">enviar</button>'+
		'</div>';
}