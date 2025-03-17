<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PetController extends Controller
{

 ///////DODAWANIE ZWIERZACZKA

    //wyswietlanie formularza dodawania 
    public function create() {
        return view('add_pet_form', ['pets' => []]);
    }

    //obsługa formularza dodawania
    public function store(Request $request) {
        Log::info('dane dane0');

        $request->validate([
            'name' => 'required|string|max:255',
            'tags' => 'nullable|array',
            'photos' => 'required|string',
            'status' => 'nullable|string'
            
        ]);
        Log::info('validated');

        $tagsFormatted = [];
            if($request->tags !== NULL){
                foreach ($request->tags as $index => $tag) {
                    $tagsFormatted[] = ["id" => $index + 1, "name" => $tag];
                }    

            }


        $photos = array_map('trim', explode(';', $request->photos));
        
        $data = [
            "id" => rand(1, 10000), 
            "category" => ["id" => 1, "name" => "Zwierze"],
            "name" => $request->name,
            "photoUrls" => $photos,
            "tags" => $tagsFormatted,
            "status" => $request->status ?? 'available'
        ];


        $apiUrl = 'https://petstore.swagger.io/v2/pet';
        $response = Http::post($apiUrl, $data);
        $responseData = $response->json() ?? [];
       
        if ($response->successful()) {
            return view('add_pet_form', [
                'success' => 'Zwierzątko zostało wysłane do API Petstore!',
                'pets' => [$responseData]
            ]);
        } else {
            return view('add_pet_form', [
                'error' => 'Błąd podczas wysyłania danych do API.',
                'pets' => []
            ]);
        }    
    }


 /////EDYCJA ZWIERZACZKA

    //wyswietlanie formularza edycji
    public function edit() {
        return view('edit_pet_form', ['pets' => []]);
    }

    //obsługa formularza edytującego
    public function update(Request $request) {
        $request->validate([
            'id' => 'required|numeric',
            'name' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'photos' => 'nullable|string',
            'status' => 'nullable|string'
        ]);
    
        $id = $request->id;
        $response = Http::get("https://petstore.swagger.io/v2/pet/{$id}");
    
        if (!$response->successful()) {
            return back()->with('error', 'Nie znaleziono zwierzęcia.');
        }
    
        $petData = $response->json();
    
        // Aktualizacja tylko edytowanych pól
        if ($request->filled('name')) {
            $petData['name'] = $request->name;
        }

        if ($request->filled('status')) {
            $petData['status'] = $request->status;
        }

        if ($request->filled('tags')) {
            $tagsFormatted = [];

            foreach ($request->tags as $index => $tag) {
                $tagsFormatted[] = ["id" => $index + 1, "name" => $tag];
            }

            $petData['tags'] = $tagsFormatted;
        }

        if ($request->filled('photos')) {
            $photos = array_map('trim', explode(';', $request->photos));
            $petData['photoUrls'] = $photos;
        }
    
        $apiUrl = "https://petstore.swagger.io/v2/pet";
        $updateResponse = Http::put($apiUrl, $petData);
        $updatePetData = $updateResponse->json() ?? [];
    
        if ($updateResponse->successful()) {
            return view('edit_pet_form', [
                'success' => 'Zwierzątko zostało wysłane do API Petstore!',
                'pet' => $updatePetData
            ]);
        } else {
            return view('edit_pet_form', [
                'error' => 'Błąd podczas wysyłania danych do API.',
                'pet' => []
            ]);
        }  
    }

 //////USUWANE ZWIERZACZKA

    //formularz usuwania zwierzaka po ID
    public function delete() {
        return view('delete_pet_form');
    }
    
    //obsługa formularza usuwającego
    public function destroy(Request $request) {
        $request->validate([
            'id' => 'required|numeric'
        ]);
    
        $id = $request->id;
        $apiUrl = "https://petstore.swagger.io/v2/pet/{$id}";
        $response = Http::delete($apiUrl);
    
        if ($response->successful()) {
            return view('delete_pet_form', [
                'success' => "Zwierzątko o ID {$id} zostało usunięte."
            ]);
        } else {
            return view('delete_pet_form', [
                'error' => "Nie udało się usunąć zwierzątka o ID {$id}."
            ]);
        }
    }

 //////WYSZUKIWARKA zwirzaka

    //wyświetlanie formularza wyszukiwania zwierzaka po ID
    public function find() {
        return view('find_pet_form', ['pets' => []]);
    }
    
    //obsługa formularza usuwania
    public function search(Request $request) {
        $request->validate([
            'id' => 'nullable|numeric',
        ]);
    
        $id = $request->id;
        $response = Http::get("https://petstore.swagger.io/v2/pet/{$id}");
        
        if ($response->successful()) {
            return view('find_pet_form', [
                'success' => "Znaleziono zwierzę o ID {$id}.",
                'pet' => $response->json()
            ]);
        } else {
            return view('find_pet_form', [
                'error' => "Nie znaleziono zwierzęcia o ID {$id}.",
                'pet' => null
            ]);
        }
    }
}
