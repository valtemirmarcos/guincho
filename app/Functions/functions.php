<?php 
use Carbon\Carbon;

if( !function_exists('formatoGravarData') ){
    function formatoGravarData($data)
    {
        if($data != null){
            return substr( $data,0,4 )."-".substr($data,4,2)."-".substr($data,6,2);
        } else {
            return null;
        }
    }    
}
if( !function_exists('formatoGravarDataHora') ){
    function formatoGravarDataHora($data)
    {
        if($data != null){
            $ar_data = explode(" ",$data);
            $ar_ajustaData = explode("/",$ar_data[0]);
            $ndata = $ar_ajustaData[2]."-".$ar_ajustaData[1]."-".$ar_ajustaData[0];
            return $ndata." ".$ar_data[1];
        } else {
            return null;
        }
    }    
}
if( !function_exists('formatarCnpj') ){
    function formatarCnpj($cnpj) {
        // Remover caracteres não numéricos
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // Verificar se o CNPJ possui 14 dígitos
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Formatar o CNPJ adicionando os caracteres
        return substr($cnpj, 0, 2) . '.' .
            substr($cnpj, 2, 3) . '.' .
            substr($cnpj, 5, 3) . '/' .
            substr($cnpj, 8, 4) . '-' .
            substr($cnpj, 12, 2);
    }
   
}
if( !function_exists('validarCnpj') ){

    function validarCnpj($cnpj) {
        // Remover caracteres não numéricos
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // Verificar se o CNPJ possui 14 dígitos
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verificar se todos os dígitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Calcular os dígitos verificadores
        $digitos = substr($cnpj, 0, 12);
        $digito1 = calcularDigitoVerificador($digitos, 5);
        $digito2 = calcularDigitoVerificador($digitos . $digito1, 6);

        // Verificar se os dígitos verificadores calculados são iguais aos informados no CNPJ
        if ($cnpj != $digitos . $digito1 . $digito2) {
            return false;
        }

        return true;
    }



   
}
if( !function_exists('calcularDigitoVerificador') ){
    function calcularDigitoVerificador($digitos, $tamanho) {
        $soma = 0;
        $posicao = $tamanho - 7;

        for ($i = $tamanho; $i >= 2; $i--) {
            $soma += $digitos[$tamanho - $i] * $posicao;
            $posicao--;
            if ($posicao < 2) {
                $posicao = 9;
            }
        }

        $resultado = $soma % 11;
        $digito = ($resultado < 2) ? 0 : 11 - $resultado;

        return $digito;
    }
}
if( !function_exists('formatarCPF') ){
    function formatarCPF($cpf) {
        // Remove caracteres indesejados
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        
        // Verifica se o CPF possui 11 dígitos
        if (strlen($cpf) != 11) {
            return $cpf; // Retorna o CPF original se não tiver 11 dígitos
        }
        
        // Formata o CPF no formato xxx.xxx.xxx-xx
        $cpfFormatado = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
        
        return $cpfFormatado;
    }
}
if( !function_exists('removerNaoNumerico') ){
    function removerNaoNumerico($string) {
        $string = preg_replace('/[^0-9]/', '', $string);
        return $string;
    }
}
if( !function_exists('gerarUUID')){
    function gerarUUID() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0C2f ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0x2Aff ), mt_rand( 0, 0xffD3 ), mt_rand( 0, 0xff4B )
        );
    }
}

if( !function_exists('validarCPF')){
    function validarCPF($cpf) {
        // Verifica se o número foi informado
        if(empty($cpf)) {
            // return "O CPF é obrigatório";
            return 0;
        }
    
        // Elimina possível máscara
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
        
        // Verifica se o número de dígitos informados é igual a 11
        if (strlen($cpf) != 11) {
            // return "O CPF deve conter 11 dígitos";
            return 0;
        }
        // Verifica se nenhuma das sequências inválidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' || 
            $cpf == '11111111111' || 
            $cpf == '22222222222' || 
            $cpf == '33333333333' || 
            $cpf == '44444444444' || 
            $cpf == '55555555555' || 
            $cpf == '66666666666' || 
            $cpf == '77777777777' || 
            $cpf == '88888888888' || 
            $cpf == '99999999999') {
            // return "CPF inválido";
            return 0;
        // Calcula os dígitos verificadores para verificar se o
        // CPF é válido
        } else {   
            
            for ($t = 9; $t < 11; $t++) {
                
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    // return "CPF inválido";
                    return 0;
                }
            }
    
            return 1;
        }
    }

}
if( !function_exists('validarFone')){
    function validarFone($telefone) {
        // Remover espaços, hífens e parênteses do número
        $telefone = preg_replace('/\s+|-|\(|\)/', '', $telefone);

        // Expressão regular para validar números de celular
        // Exemplo para o Brasil: códigos de país 55 e números de celular começando com 9 após o DDD
        $padraoBrasil = "/^\+?55\d{2}9\d{8}$/";

        // Verifica se o número de telefone corresponde a algum padrão
        if (preg_match($padraoBrasil, $telefone)) {
            return true;
        } else {
            return false;
        }
    }
}