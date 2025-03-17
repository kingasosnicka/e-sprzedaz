<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuń zwierzę</title>
</head>
<body>
    <h1>Usuń zwierzątko</h1>

    @if(isset($success))
        <p style="color: green;">✅ {{ $success }}</p>
    @elseif(isset($error))
        <p style="color: red;">❌ {{ $error }}</p>
    @endif

    <form action="{{ url('/pet/delete') }}" method="POST">
        @csrf
        <label for="id">ID zwierzęcia do usunięcia:</label>
        <input type="text" id="id" name="id" required>

        <button type="submit">Usuń</button>
    </form>

    <p><a href="{{ url('/') }}">⬅ Powrót do strony głównej</a></p>
</body>
</html>
