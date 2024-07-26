<?php

namespace App\Repositories;

use App\Models\Operador;

use Exception;


class RotasRepository{

    public function __construct()
    {
        //
        
    }
    public function dadosRotas($request) {
        if(!$request->has('operador')){
            throw new \Exception("Parametro do Operador nao encontrado");
        }
        // $query = Operador::where('id',$request->input('operador'))->with('taxa')->first();
        $query = Operador::find($request->input('operador'));
        $taxaComputacional = $query->taxa->taxa_computacional_km;
        $taxaGuinchoKm = $query->valor_km;
        $minimoKm =  $query->minimo_km;
        $minimoValor = $query->minimo_valor;
        if(!$query){
            throw new \Exception("Operador nao encontrado");
        }
        $base = $query->endereco_base;

        // if(!$request->has('origins')){
        //     throw new \Exception("Faltou escolher a origem!");
        // }
        if(!$request->has('destinations')){
            throw new \Exception("Faltou escolher a destino!");
        }

        $origem = urlencode($base);
        $destino = urlencode($request->input('destinations'));
        $apiKey = $query->chave_maps;
        // return $apiKey;
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origem}&destinations={$destino}&key={$apiKey}",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);
        $data->taxa_computacional_km = $taxaComputacional;
        $data->taxa_guicho_km =  $taxaGuinchoKm;
        $data->minimo_km =  $minimoKm;
        $data->minimo_valor =  $minimoValor;
        
        return $data;

    }
    public function rotas($request)
    {
        $dadosRotas = $this->dadosRotas($request);

        $jsonDados = [
            'origem' => $dadosRotas->origin_addresses[0],
            'destino' => $dadosRotas->destination_addresses[0],
            'lblkm' => $dadosRotas->rows[0]->elements[0]->distance->text,
            'kms' => $dadosRotas->rows[0]->elements[0]->distance->value/1000,
            'kms_ida_volta' => ($dadosRotas->rows[0]->elements[0]->distance->value/1000)*2,
            'taxa_computacional_km' => $dadosRotas->taxa_computacional_km,
            'taxa_guicho_km' => $dadosRotas->taxa_guicho_km,
            'minimo_km' => $dadosRotas->minimo_km,
            'minimo_valor' => $dadosRotas->minimo_valor,
        ];
        $valorGuincho = 0;
        if($jsonDados['kms_ida_volta']<=$jsonDados['minimo_km']){
            $valorGuincho = $jsonDados['minimo_valor'];
        }
        // $valorGuichokm = 
        $valorGuincho = $jsonDados['minimo_valor']+($jsonDados['kms_ida_volta']*$jsonDados['taxa_guicho_km']);
        $jsonDados['valorTaxaComputacional'] = $jsonDados['kms_ida_volta']*$jsonDados['taxa_computacional_km'];
        $jsonDados['valorGuincho'] = $valorGuincho;
        $jsonDados['valorTotal'] = $jsonDados['valorTaxaComputacional']+$jsonDados['valorGuincho'];
        return $jsonDados;
    }
}