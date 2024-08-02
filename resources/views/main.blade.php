@extends('layout/base')

@section('title', 'Bnp Guincho')

@section('css')
@endsection

@section('conteudo')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Simulador</h1>
    </div>
    <div class="content">
        <p class="mb-3">Faça sua simulação sem compromisso e já entre em contato com nossa central de atendimento</p>
        <form>
            <div class="row">
                <div class="col-9">
                    <div class="form-floating mb-3">
                        <input type="text" name="autocomplete" id="autocomplete" class="form-control" placeholder=" ">
                        <label for="autocomplete" class="form-label">Localização Atual</label>
                    </div>
                </div>
                <div class="col-3 mt-md-2">
                    <button type="button" id="geolocalizacao" class="btn btn-primary me-2">
                        <i class="bi bi-geo-alt-fill"></i> Localizar
                    </button>
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="telefone" id="telefone" class="form-control" placeholder=" ">
                <label for="telefone" class="form-label">Telefone</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="cpf" id="cpf" class="form-control" placeholder=" ">
                <label for="cpf" class="form-label">CPF</label>
            </div>
            <div class="text-center">
                <button type="button" id="bt-simular" class="btn btn-success mt-5 text-center p-3 fs-2 me-3">
                    <i class="bi bi-arrow-repeat"></i> Simular
                </button>
                <button type="button" id="bt-contactar" class="btn btn-primary mt-5 text-center p-3 fs-2">
                    <i class="bi bi-whatsapp"></i> Contactar Central
                </button>
            </div>

        </form>
    </div>
@endsection
@section('js')
    <script>
        var slug = "{{$slug}}";
        var urlApp = "{{$url}}";
        // console.log(slug);
    </script>
    <script src="/api/localizacao/autocomplete?slug={{$slug}}"></script>

    <script src="{{asset('js/main.js')}}"></script>
@endsection