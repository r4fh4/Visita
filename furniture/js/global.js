$(document).ready(function(){
	
	$('#info').click(function(){
		var html = '<div class="div_transparent">';
		html += '<div class="div_conteudo">';
		html += '<h3>Visita Santos</h3>';
		html += '<p class="title">Esta ferramenta foi desenvolvida para o tema de Mobilidade Urbana por Meio de TI, TCC de Bacharel de Ciências da Computação na Universidade Santa Cecília.</p>';
		html += '<br /><br />';
		
		html += '<p><b>Membros do Grupo</b></p>';
		html += '<ul>';
		html += "<li>Rafhael Silva</li>";
		html += "<li>Victor Huber</li>";
		html += "<li>Juliano Menezes</li>";
		html += "<li>Orientador: Everton Souza</li>";
		html += "</ul>";
		
		html += '<br /><br />';
		html += '<center><input type="button" class="btn-fechar" value="" onclick="$(\'.div_transparent\').remove()"></center>';
		html += '</div>';
		html += '</div>';
		
		$('body').append(html);
	});
	
});