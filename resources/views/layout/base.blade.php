<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{asset('css/guincho.css')}}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" defer></script>

    <title>@yield('title')</title>
    @yield('css')
</head>
<body>
    
    <!-- Topo -->
    <header class="bg-primary text-white p-3">
        <div class="container">
            <h1 class="mb-0 text-center">Bnp Guinchos</h1>
        </div>
    </header>

    <div class="container-fluid vh-100 d-flex flex-column">
        <div class="row">

            <!-- Conteúdo -->
            <nav class="col-md-9 ms-sm-auto col-lg-10 px-md-4 text-center mt-3 mb-2">
                <img src="{{asset('images/guinchobnp.png')}}" class="text-center" style="width:200px"/>
            </nav>
        </div>
        <div class="row">

            <!-- Conteúdo -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('conteudo')
            </main>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="bg-secondary text-white text-center p-3 mt-4">
        <div class="container">
            <p class="mb-0">© {{date('Y')}} Todos os direitos reservados.</p>
        </div>
    </footer>

    @yield('js')
</body>
</html>