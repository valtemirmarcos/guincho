$(() => {
    $("#cpf").mask('000.000.000-00');
    $("#telefone").mask('(00) 00000-0000');
    initAutocomplete();
});
$(document).on('click',"#geolocalizacao",(evt)=>{
    console.log("clicou");
    evt.preventDefault();
    evt.stopPropagation();
    if (navigator.geolocation) {
        if ('Notification' in window) {
            Notification.requestPermission()
                .then(permission => {
                    if (permission === "granted") {
                        console.log("Permissão concedida!");
                        // Crie uma notificação aqui
                        new Notification('Acessar localizacao', {
                            body: 'notificação consedida',
                            icon: 'caminho/para/sua/imagem.png'
                        });
                    } else {
                        console.log('Permissão negada.');
                    }
                });
        } else {
            console.error('Seu navegador não suporta notificações.');
        }
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocalização não é suportada por este navegador.");
    }
    function showPosition(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        alert("Latitude: " + latitude + "<br>Longitude: " + longitude);
    
        // // Exibir mapa com localização
        // var mapUrl = "https://www.google.com/maps?q=" + latitude + "," + longitude + "&z=15&output=embed";
        // $('#map').html('<iframe src="' + mapUrl + '" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>');
    }
    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("Usuário negou a solicitação de Geolocalização.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("As informações de localização não estão disponíveis.");
                break;
            case error.TIMEOUT:
                alert("A solicitação para obter a localização demorou muito.");
                break;
            case error.UNKNOWN_ERROR:
                alert("Ocorreu um erro desconhecido.");
                break;
        }
    }
});

function initAutocomplete() {
    const autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('autocomplete'),
      { types: ['geocode'] }
    );
  
    autocomplete.addListener('place_changed',   
   () => {
      const place = autocomplete.getPlace();   
  
      // Faça algo com as informações do lugar, como exibir o endereço completo
      console.log(place);
    });
  }