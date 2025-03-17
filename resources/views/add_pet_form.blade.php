<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj zwierzątko</title>
</head>
<body>
    <h1>Dodaj nowe zwierzątko do asortymentu</h1>

    @if(isset($success))
        <p style="color: green;">✅ {{ $success }}</p>
    @elseif(isset($error))
        <p style="color: red;">❌ {{ $error }}</p>
    @endif


    <form action="/pet/add" method="POST">
        @csrf
        <label for="name">Nazwa zwierzątka:</label>
        <input type="text" id="name" name="name" required></br></br>

        <label for="tags">Tagi:</label>
        <select id="tags" name="tags[]" multiple>
            <option value="kot">Kot</option>
            <option value="pies">Pies</option>
            <option value="papuga">Papuga</option>
            <option value="mały">Mały</option>
            <option value="duży">Duży</option>
            <option value="duży">Czarny</option>
            <option value="duży">Biały</option>
        </select></br></br>

        <label for="status">Status:</label>
        <input type="text" id="status" name="status"></br></br>

        <label for="photos">Obrazki (oddzielone średnikiem):</label>
        <input type="text" id="photo" name="photos" required></br></br>

        <button type="submit">Dodaj zwierzątko</button>
    </form>

    <p><a href="{{ url('/') }}">⬅ Powrót do strony głównej</a></p>


    @if(!empty($pets))
        <h2>Lista dodanych zwierzątek</h2>
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
                @foreach($pets as $pet)
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
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>