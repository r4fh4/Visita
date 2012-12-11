$(document).ready(function(){
	initialize();
	$('.btn-voltar').click(function(){
		history.back(-1);
	});
});

function show_ponto( lat, lng ) {

	var data = {
		action: 'get_endereco',
		lat: lat,
		lng: lng
	};
	
	$.getJSON('tools.php', data, function( ret ) {
		alert(ret);
	});
	
}

var directionDisplay;
var map;
function initialize() {
	directionsDisplay = new google.maps.DirectionsRenderer();
	var myLatlng = new google.maps.LatLng( $('#lat').val() , $('#lng').val() );
	var myOptions = {
		zoom: 14,
		center: myLatlng,
		mapTypeControl: true,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map(document.getElementById("mapa"), myOptions);
	var data = {
		action : 'get_rota',
		lat : $('#lat').val(),
		lng : $('#lng').val(),
		destino : $('#destino').val(),
		onibus: $('#onibus').val()
	};
	$.getJSON('tools.php', data, function( ret ) {
		if(ret) {
			for(var i in ret) {
				var icone = ret[i]['latitude'] == $('#lat').val() && ret[i]['longitude'] == $('#lng').val() 
							? "http://www.lcmconsulting.com.br/visita/furniture/images/flag_start.png"
							: ( ret[i]['end'] == 1 ? "http://www.lcmconsulting.com.br/visita/furniture/images/flag_end.png" : "http://www.lcmconsulting.com.br/visita/furniture/images/flag_rote.png" );
							
				var posicao = new google.maps.LatLng(ret[i]['latitude'], ret[i]['longitude']);
				
				var marker = new google.maps.Marker({
					position: posicao, 
					map: map,
					icon: icone,
					clickable: true
				});
				
				google.maps.event.addListener(marker, 'click', (function(marker, i) {
					return function() {
						show_ponto(ret[i]['latitude'], ret[i]['longitude']);
					}
				})(marker, i));
			}
		}
	});
	
	var data = {
		action : 'get_coords_ponto',
		destino : $('#destino').val()
	};
	$.getJSON('tools.php', data, function( ret ) {
		if(ret) {			
			var posicao = new google.maps.LatLng(ret[0]['latitude'], ret[0]['longitude']);
			
			var marker = new google.maps.Marker({
				position: posicao, 
				map: map,
				icon: "http://www.lcmconsulting.com.br/visita/furniture/images/flag_destino.png",
				clickable: true
			});
			
		}
	});
	directionsDisplay.setMap(map);
	directionsDisplay.setPanel(document.getElementById("directionsPanel"));
}