<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Znajdź zwierzę</title>
</head>
<body>
    <h1>Znajdź zwierzątko</h1>

    @if(isset($success))
        <p style="color: green;">✅ {{ $success }}</p>
    @elseif(isset($error))
        <p style="color: red;">❌ {{ $error }}</p>
    @endif

    <form action="{{ url('/pet/find') }}" method="POST">
        @csrf
        <label for="id">ID zwierzęcia:</label>
        <input type="text" id="id" name="id" required>

        <button type="submit">Szukaj</button>
    </form>

    @if(isset($pet))
        <h2>Znalezione zwierzę</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nazwa</th>
                    <th>Gatunek</th>
                    <th>Tagi</th>
                    <th>Zdjęcia</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $pet['id'] }}</td>
                    <td>{{ $pet['name'] }}</td>
                    <td>{{ $pet['category']['name'] ?? 'Brak danych' }}</td>
                    <td>
                        {{ isset($pet['tags']) ? implode(', ', array_column($pet['tags'], 'name')) : 'Brak tagów' }}
                    </td>
                    <td>
                        @if(isset($pet['photoUrls']) && count($pet['photoUrls']) > 0)
                            @foreach($pet['photoUrls'] as $photo)
                                <img src="{{ $photo }}" alt="Zdjęcie zwierzęcia" width="50">
                            @endforeach
                        @else
                            Brak zdjęć
                        @endif
                    </td>
                    <td>{{ $pet['status'] ?? 'Brak statusu' }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    <p><a href="{{ url('/') }}">⬅ Powrót do strony głównej</a></p>
</body>
</html>
