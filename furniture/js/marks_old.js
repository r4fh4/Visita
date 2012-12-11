$(document).ready(function(){
	initialize();
	$('.btn-voltar').click(function(){
		history.back(-1);
	});
});

function div_hide(){
	$('div.conteudo').html('');
	$('div.transparent').hide();
}

function set_ponto( onibus, lat, lng ) {
	$('#lat').val( lat );
	$('#lng').val( lng );
	$('#onibus').val( onibus );
	$('#form-post').submit();
}

function select_ponto(lat, lng){
	var data = {
		action : 'get_pontos',
		lat : lat,
		lng : lng,
		ponto : $('#destino').val()
	};
	$.getJSON('../tools.php', data, function( ret ) {
		var rotas = ret['rotas'],
			count = 0,
			html = '<div id="div_escolha">';
		html += '<p class="title"><b>Ponto Origem</b>: ' + ret['endereco'] + '</p>';
		html += '<br />';
		html += '<p class="title"><b>Seu Destino</b>: ' + $('#ponto').val() + '</p>';
		html += '<br /><br />';
		
		for(key in rotas) {
		  count++;
		}
		
		if( count > 0 ) {
			html += '<p class="success">Ônibus Encontrado(s)</p>';
			html += '<ul>';
			for(var i in rotas){
				html += "<li>";
				html += "<p class='bus'>" + rotas[i] + "</p>";
				html += "<p class='choose' onclick='set_ponto(" + i + ", " + lat + ", " + lng + ")'>Escolher</p>";
				html += "<br class='clean' />";
				html += "</li>";
			}
			html += "</ul>";
		} else {
			html += '<p class="error">Nenhum ônibus encontrado para seu destino!</p>';
		}
		
		html += '<br /><br />';
		html += '<center><input type="button" class="btn-fechar" value="" onclick="div_hide()"></center>';
		html += '</div>';
		
		$('div.conteudo').html(html);
		
	});
	$('div.transparent').show();
}

var directionDisplay;
var map;
function initialize() {
	directionsDisplay = new google.maps.DirectionsRenderer();
	var myLatlng = new google.maps.LatLng(-23.960842, -46.331835);
	var myOptions = {
		zoom: 15,
		center: myLatlng,
		mapTypeControl: true,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map(document.getElementById("mapa"), myOptions);
	$.getJSON('../tools.php', { action: 'get_all' }, function( ret ) {
		for(var i in ret) {
			var posicao = new google.maps.LatLng(ret[i]['latitude'], ret[i]['longitude']);
			var marker = new google.maps.Marker({
				position: posicao, 
				map: map,
				icon:"http://www.lcmconsulting.com.br/visita/furniture/images/icon_bus.png",
				clickable: true
			});
			  
			google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
					select_ponto(ret[i]['latitude'], ret[i]['longitude']);
				}
			})(marker, i));
		}
	});
	directionsDisplay.setMap(map);
	directionsDisplay.setPanel(document.getElementById("directionsPanel"));
}