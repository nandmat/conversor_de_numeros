<!doctype html>
<html lang="pt-BR" data-bs-theme="white" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Conversor de Números</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary h-100">
    <main class="w-50 m-auto form-container">

        <div class="card my-1 py-2 border border-2 rounded-0" style="background-color: #DED6CC;">
            <div class="header-card d-flex justify-content-start mx-3 mt-2 text-cneter">
                <div class="header-card">
                    <span class="h3 fw-normal"><img src="{{ asset('images/logo.png') }}" alt=""
                            class=" w-50"></span>
                    <h3 class="brown-color">Conversor de Números</h3>
                </div>
            </div>
        </div>

        <div class="card border border-2 rounded-0">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('erro'))
                    <div class="alert alert-danger">
                        {{ session('erro') }}
                    </div>
                @endif

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row text-center" id="central">
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <label for="inputPassword6" class="col-form-label">Número Decimal</label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="number" id="decimal_number" class="form-control">
                                    </div>
                                    <div class="col-auto">
                                        <button id="buttonDecimalNumber"
                                            class="btn btn-theme my-3 py-2">Verificar</button>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <label for="inputPassword6" class="col-form-label">Número Romano</label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="text" id="roman_numeral" class="form-control">
                                    </div>
                                    <div class="col-auto">
                                        <button id="buttonRomanNumeral"
                                            class="btn btn-theme my-3 py-2">Verificar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body d-flex justify-content-center align-items-center"
                                    style="height: 200px;">
                                    <div class="spinner-grow text-warning d-none" id="spinner" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <div id="result" class="mt-4 text-center d-none">
                                        teste
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/home.js') }}?v{{ now() }}"></script>
</body>

</html>
