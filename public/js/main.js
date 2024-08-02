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
                        // new Notification('Acessar localizacao', {
                        //     body: 'notificação consedida',
                        //     icon: 'caminho/para/sua/imagem.png'
                        // });
                    } else {
                        console.error('Permissão negada.');
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
        gerarEndereco(latitude, longitude);
        // alert("Latitude: " + latitude + "<br>Longitude: " + longitude);
    
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
$(document).on('click',"#bt-simular",(evt) =>{
    console.log("clicou");
    evt.preventDefault();
    evt.stopPropagation();
    var jsonEntrada = {
        "slug":slug,
        "cpf":$("#cpf").val(),
        "destinations":$("#autocomplete").val(),
        "fone":$("#telefone").val()
    }
    $.ajax({
        url: urlApp + '/api/localizacao/cotacao',
        type: 'post',
        dataType: "json",
        data:JSON.stringify(jsonEntrada),
        contentType: "application/json; charset=iso-8859-1",
        success: function (result) {
            if(result.status!='success'){
                alert(result.message);
                console.log(result);
                return false;
            }
            var resposta = result.data;
            var descricao='<h4 class="text-center"><b>Resultado da Simulação</b></h4>';
                descricao += '<p class="ms-2"><span>Distância Percorrida: <b>'+formataMoeda(resposta.kms_ida_volta,2)+' kms</b></span></p>';
                descricao += '<p class="ms-2"><span>Custo frete: <b>R$ '+formataMoeda(resposta.valorTotal,2)+'</b></span></p>';
            $("#descricao").html(descricao);
            console.log(result.data);

        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
        
    });
});
$(document).on('click',"#bt-contactar",(evt) =>{
    console.log("clicou");
    evt.preventDefault();
    evt.stopPropagation();
    var jsonEntrada = {
        "slug":slug,
        "cpf":$("#cpf").val(),
        "destinations":$("#autocomplete").val(),
        "fone":$("#telefone").val()
    }
    console.log(jsonEntrada);
    $.ajax({
        url: urlApp + '/api/localizacao/rotas',
        type: 'post',
        dataType: "json",
        data:JSON.stringify(jsonEntrada),
        contentType: "application/json; charset=iso-8859-1",
        success: function (result) {
            if(result.status!='success'){
                alert(result.message);
                console.log(result);
                return false;
            }
            var resposta = result.data;
            var phoneNumber = "55" + resposta.foneOperador; // Número no formato internacional, sem espaços ou sinais
    
            var mensagem = "Olá, fiz uma simulação";
            mensagem += " Local da retirada: " + resposta.destino + "";
            mensagem += " Distância: *" + formataMoeda(resposta.kms_ida_volta, 2) + " kms*";
            mensagem += " no valor de: *R$ " + formataMoeda(resposta.valorTotal, 2) + "*";
    
            var message = encodeURIComponent(mensagem);

            var whatsappUrl = 'https://wa.me/' + phoneNumber + '?text=' + message;
            window.location.href = whatsappUrl; // Abre na mesma aba
            console.log(result.data);

        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
        
    });

});
function gerarEndereco(latitude, longitude){
    var jsonDados = {
        'slug':slug,
        'latitude':latitude,
        'longitude':longitude
    }
    $.ajax({
        url: urlApp + '/api/localizacao/buscarEnderecoCoordenada',
        type: 'post',
        dataType: "json",
        data:JSON.stringify(jsonDados),
        contentType: "application/json; charset=iso-8859-1",
        success: function (result) {
            if(result.status!='success'){
                alert("Endereço nao localizado")
                return false;
            }
            $("#autocomplete").val(result.data);
            console.log(result.data);

        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
        
    });
    console.log(urlApp);
}
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
function formataMoeda(valor, casasDecimais) {
    valor = valor==null ? 0:valor;
        return parseFloat(valor).toLocaleString('pt-BR', { maximumFractionDigits: casasDecimais, minimumFractionDigits: casasDecimais });
}