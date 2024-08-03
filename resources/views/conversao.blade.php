<style>
    body {
        background-color: #f5f5f5;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
    }

    label {
        margin-bottom: 10px;
    }

    input, select {
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    button {
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #4CAF50; /* Green */
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #45a049;
    }

    h2 {
        margin-top: 20px;
    }

    ul {
        list-style: none;
        padding: 0;
    }

    li {
        margin-bottom: 10px;
    }
</style>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Conversor</title>
    <!-- Outras tags head, como CSS -->
</head>
<body>

<form action="{{ route('converter') }}" method="post">
    @csrf

    <h2>Exemplo de letras em romanos para serem usadas</h2>
    <ul>
        <li>I - Um</li>
        <li>V - Cinco</li>
        <li>X - Dez</li>
        <li>L - Cinquenta</li>
        <li>C - Cento</li>
        <li>D - Quatro</li>
        <li>M - Mil</li>
    </ul>
    <label for="numero">Número:</label>
    <input type="text" id="numero" name="numero" onkeyup="this.value = this.value.toUpperCase();">
    {{-- <select name="tipo" id="tipo">
        <option value="romano">Converter para Decimal</option>
        <option value="decimal">Converter para Romano</option>
    </select> --}}
    <button type="submit">Converter</button>
</form>

@if (isset($romano) && isset($decimal))
    <h2 style="margin-top: 20px;">Romano: {{ $romano }}</h2>
    <h2>Decimal: {{ $decimal }}</h2>
@endif

@if (isset($historico))
    <h2 style="margin-top: 20px;">Histórico:</h2>
    <ul>
        @foreach ($historico as $conversao)
            <li>{{ $conversao->entrada }} - {{ $conversao->saida }}</li>
        @endforeach
    </ul>
@endif


@if ($errors->any())
    <div class="alert alert-danger">
        <p>{{ $errors->first() }}</p>
    </div>
@endif


@if (session('exception'))
    <div class="alert alert-danger">
        <p>{{ session('exception')->getMessage() }}</p>
    </div>
@endif

{{-- 
<!-- Início do bloco de script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('converter') }}",
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                // Atualize a interface do usuário com base na resposta
                $('#resultado').html(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
</script> --}}
<!-- Fim do bloco de script -->

</body>
</html>
