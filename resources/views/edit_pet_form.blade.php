<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj zwierzę</title>
</head>
<body>
    <h1>Edytuj zwierzątko</h1>

    @if(isset($success))
        <p style="color: green;">✅ {{ $success }}</p>
    @elseif(isset($error))
        <p style="color: red;">❌ {{ $error }}</p>
    @endif

    <form action="{{ url('/pet/edit') }}" method="POST">
        @csrf
        <label for="id">ID zwierzęcia do edycji:</label>
        <input type="text" id="id" name="id" required></br></br>

        <label for="name">Nowa nazwa:</label>
        <input type="text" id="name" name="name"></br></br>

        <label for="tags">Nowe tagi (opcjonalnie):</label>
        <select id="tags" name="tags[]" multiple>
        <option value="kot">Kot</option>
            <option value="pies">Pies</option>
            <option value="papuga">Papuga</option>
            <option value="mały">Mały</option>
            <option value="duży">Duży</option>
            <option value="duży">Czarny</option>
            <option value="duży">Biały</option>
        </select></br></br>

        <label for="status">Nowy status (opcjonalnie):</label>
        <input type="text" id="status" name="status" value="{{ $pet['status'] ?? '' }}"></br></br>

        <label for="photos">Nowe zdjęcia (oddzielone średnikiem) (opcjonalnie):</label>
        <input type="text" id="photos" name="photos" value="{{ isset($pet['photoUrls']) ? implode('; ', $pet['photoUrls']) : '' }}"></br></br>

        <button type="submit">Edytuj</button>
    </form>

    <p><a href="{{ url('/') }}">⬅ Powrót do strony głównej</a></p>

    @if(!empty($pet))
        <h2>Edytuj zwierzatko</h2>
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
</body>
</html>