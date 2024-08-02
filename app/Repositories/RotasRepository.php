<?php

namespace App\Repositories;

use App\Models\Operador;
use App\Models\Servico;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

use Exception;


class RotasRepository{

    public function __construct()
    {
        //
        
    }
    public function dadosRotas($request) {
        if(!$request->has('slug')){
            throw new \Exception("Parametro do Operador nao encontrado");
        }
        // $query = Operador::where('id',$request->input('operador'))->with('taxa')->first();
        $query = Operador::where('slug',$request->input('slug'))->first();
        $taxaComputacional = $query->taxa->taxa_computacional_km;
        $taxaGuinchoKm = $query->valor_km;
        $minimoKm =  $query->minimo_km;
        $minimoValor = $query->minimo_valor;
        $idOperador = $query->id;
        $foneOperador = $query->fone;
        if(!$query){
            throw new \Exception("Operador nao encontrado");
        }
        $base = $query->endereco_base;

        if(!$request->has('destinations')){
            throw new \Exception("Faltou escolher a destino!");
        }
        if(!$request->has('cpf')){
            throw new \Exception("Faltou incluir o CPF");
        }
        $validaCpf = validarCPF($request->input('cpf'));
        if(!$validaCpf){
            throw new \Exception("CPF inválido!");
        }
        if(!$request->has('fone')){
            throw new \Exception("Faltou incluir o Telefone");
        }
        
        $validaFone = validarFone($request->input('fone'));
        if(!$validaFone){
            throw new \Exception("Telefone inválido!");
        }
        $origem = urlencode($base);
        $destino = urlencode($request->input('destinations'));
        $apiKey = $query->chave_maps;
        // $encryptedApiKey = Crypt::encryptString($apiKey);
        $decryptedApiKey = Crypt::decryptString($apiKey);


        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origem}&destinations={$destino}&key={$decryptedApiKey}",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_SSL_VERIFYHOST => false,
          CURLOPT_SSL_VERIFYPEER => false,
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);
        $data->taxa_computacional_km = $taxaComputacional;
        $data->taxa_guicho_km =  $taxaGuinchoKm;
        $data->minimo_km =  $minimoKm;
        $data->minimo_valor =  $minimoValor;
        $data->id_operador = $idOperador;
        $data->foneOperador = $foneOperador;
        return $data;

    }
    public function rotas($request)
    {

        $cotacao = $this->cotacaoServico($request);
        $valorTotal = $cotacao["valorTotal"];
        $foneOperador = $cotacao["foneOperador"];
        unset($cotacao["foneOperador"], $cotacao["valorTotal"]);
        $insert = Servico::insert($cotacao);
        if(!$insert){
            throw new \Exception("Dados do serviço não foram processados");
        }
        $cotacao["foneOperador"] = $foneOperador;
        $cotacao["valorTotal"] = $valorTotal;

        return $cotacao;
    }
    public function cotacaoServico($request)
    {
        $dadosRotas = $this->dadosRotas($request);

        $jsonDados = [
            'origem' => $dadosRotas->origin_addresses[0],
            'destino' => $dadosRotas->destination_addresses[0],
            'txt_km' => $dadosRotas->rows[0]->elements[0]->distance->text,
            'kms' => $dadosRotas->rows[0]->elements[0]->distance->value/1000,
            'kms_ida_volta' => ($dadosRotas->rows[0]->elements[0]->distance->value/1000)*2,
            'taxa_computacional_km' => $dadosRotas->taxa_computacional_km,
            'taxa_guicho_km' => $dadosRotas->taxa_guicho_km,
            'minimo_km' => $dadosRotas->minimo_km,
            'minimo_valor' => $dadosRotas->minimo_valor,
            'id_operador' => $dadosRotas->id_operador,
        ];
        $valorGuincho = 0;
        if($jsonDados['kms_ida_volta']<=$jsonDados['minimo_km']){
            $valorGuincho = $jsonDados['minimo_valor'];
        }
        // $valorGuichokm = 
        $valorGuincho = $jsonDados['minimo_valor']+($jsonDados['kms_ida_volta']*$jsonDados['taxa_guicho_km']);
        $jsonDados['valorTaxaComputacional'] = $jsonDados['kms_ida_volta']*$jsonDados['taxa_computacional_km'];
        $jsonDados['valorGuincho'] = $valorGuincho;
        $jsonDados['cpf'] = $request->input('cpf');
        $jsonDados['fone'] = gravaFone($request->input('fone'));
        $jsonDados['created_at'] = horarioBrasilia();
        $jsonDados['updated_at'] = horarioBrasilia();
        $jsonDados['valorTotal'] = $jsonDados['valorTaxaComputacional']+$jsonDados['valorGuincho'];
        $jsonDados['foneOperador'] = $dadosRotas->foneOperador;

        return $jsonDados;
    }
    public function criptografia($request)
    {
        
        $dados = [];
        if($request->has('informacaoE')){
            $dados['encrigrafado'] = Crypt::encryptString($request->input('informacaoE'));
        }
        if($request->has('informacaoS')){
            $dados['descrigrafado'] = Crypt::decryptString($request->input('informacaoS'));
        }
        return $dados;
    }
    public function buscarDadosUsuario($request)
    {
        if(!$request->has('slug')){
            throw new \Exception("Parametro do Operador nao encontrado");
        }
        // $query = Operador::where('id',$request->input('operador'))->with('taxa')->first();
        $query = Operador::where('slug',$request->input('slug'))->first();
        return $query;
    }
    public function buscarEnderecoCoordenada($request)
    {
        if(!$request->has('latitude')){
            throw new \Exception("Latitude nao encontrada");
        }
        if(!$request->has('longitude')){
            throw new \Exception("Longitude nao encontrada");
        }

        $dadosGuincheiro = $this->buscarDadosUsuario($request);
        $dadosBusca = [
            'apiKey' => Crypt::decryptString($dadosGuincheiro->chave_maps),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude')
        ];
        $api = $this->apiBuscarCoordenada($dadosBusca);

        if(!isset($api->results[0]->formatted_address)){
            throw new \Exception("Endereço não encontrado!");
        }
        return $api->results[0]->formatted_address;
    }
    public function apiBuscarCoordenada($dadosApi)
    {
        $latlong = $dadosApi["latitude"].",".$dadosApi["longitude"];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latlong}&key={$dadosApi['apiKey']}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }
    public function autocomplete($request)
    {
        $dadosGuincheiro = $this->buscarDadosUsuario($request);

        $key = Crypt::decryptString($dadosGuincheiro->chave_maps);
        $response = Http::get('https://maps.googleapis.com/maps/api/js', [
            'key' => $key,
            'libraries' => 'places',
        ]);
    
        return $response->body();
    }
}