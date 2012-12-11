$(document).ready(function(){

	$('.btn-action').click(function(){
		var id = $(this).attr('id');
		
		$('.box').each(function(){
			if( !$(this).hasClass('element-hidden') )
				$(this).addClass('element-hidden');
		});
		
		$('#box-'+id).removeClass('element-hidden');
	});
	
	$('#enviar').click(function(){
		var comentario = $('#text-comentario').val(),
			user = $('#text-user').val(),
			ponto = $('#text-ponto').val(),
			data = {
				action: 'set_comentario',
				comentario: comentario,
				user: user,
				ponto: ponto
			};
		$.post('../tools.php', data, function(ret){
			if(ret == 'ok'){
				alert('Comentário incluído com sucesso!');
				$('#text-comentario').val('');
				location.reload();
			} else {
				alert('Campo comentário é obrigatório!');
				$('#text-comentario').focus();
			}
		});
	});
	
	$('#imagem-list a').lightBox( {maxHeight: 700, maxWidth: 700} );
	
});