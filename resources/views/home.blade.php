<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie zwierzętami</title>
</head>
<body>
    <h1>Witaj w PetStore!</h1>
    
    <ul>
        <li><a href="{{ url('/pet/add') }}">➕ Dodaj zwierzę</a></li>
        <li><a href="{{ url('/pet/edit') }}">✏ Edytuj zwierzę</a></li>
        <li><a href="{{ url('/pet/delete') }}">🗑 Usuń zwierzę</a></li>
        <li><a href="{{ url('/pet/find') }}">🔍 Znajdź zwierzę</a></li>
    </ul>
</body>
</html>
