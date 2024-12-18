<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client; 
use GuzzleHttp\Exception\RequestException;

class CulturaController extends Controller
{
    public function v_cultura()
    {
        $apiUrl = 'https://backend-culturas.elalto.gob.bo/api/culturas?populate=*';

        try {
            $response = Http::withOptions([
                 'verify' => false, // Desactiva la verificación SSL
            ])->get($apiUrl);

            if ($response->failed()) {
                return response()->json(['error' => 'Error al acceder a la API'], 500);
            }

            $data = $response->json();
            
            return view('cultura', ['data' => $data]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
            
        }
    }
    // // agregar datos con el metodo post
    public function post(Request $request)
    {
        $client = new Client(['verify' => false]);
    
        // Obtén los datos del formulario excepto el archivo
        $data = $request->except('foto_cult');
        $file = $request->file('foto_cult');
    
        // Verificar si el archivo existe
        if (!$file) {
            return response()->json(['error' => 'No se ha enviado ningún archivo'], 400);
        }
     
        try {
            // Subir el archivo a /upload y obtener su ID
            $response = $client->post('https://backend-culturas.elalto.gob.bo/api/upload', [
                'multipart' => [
                    [
                        'name'     => 'files',  // Cambiado a 'files'
                        'contents' => fopen($file->getRealPath(), 'r'),
                        'filename' => $file->getClientOriginalName(),
                    ],
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . 'YOUR_TOKEN_HERE',
                    'Accept'        => 'application/json',
                ],
            ]);
    
            $uploadedFile = json_decode($response->getBody()->getContents(), true);
    
            // Verificar si se subió correctamente el archivo y obtener su ID
            if (isset($uploadedFile[0]['id'])) {
                // Añadir el ID del archivo subido a los datos de la relación 'foto_guia'
                $data['foto_cult'] = $uploadedFile[0]['id'];  // Cambiado para usar el ID del archivo
            } else {
                return response()->json(['error' => 'Error al subir la imagen'], 500);
            }
    
            // Envía los datos a la API de Strapi, incluyendo el ID de la imagen
            $response = $client->post('https://backend-culturas.elalto.gob.bo/api/culturas', [
                'json' => [
                    'data' => $data,  // Strapi espera que los datos estén dentro de "data"
                    'foto_cult' => [
                        'id' => $uploadedFile[0]['id'],  // Asocia el archivo subido con la entidad
                    ]
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . 'YOUR_TOKEN_HERE',
                    'Accept'        => 'application/json',
                ],
            ]);
    
            // Verificar si la respuesta de Strapi fue exitosa
            // dd($data);
        if ($response->getStatusCode() >= 400) {
            return redirect()->back()->with('error', 'Error al enviar los datos a la API');
        }

            return redirect()->back()->with('success', 'Datos enviados correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function update(Request $request, $id)
{
    $client = new Client(['verify' => false]);

    // Valida los datos del formulario
    $validatedData = $request->validate([
        'titulo' => 'required|string|max:255',
        'descrip' => 'required|string|max:255',
        'ubicacion' => 'required|string|max:255',
        
    ]);

    // Si hay un archivo, maneja la carga del archivo
    $file = $request->file('foto_cult');
    if ($file) {
        try {
            // Subir el archivo a /upload y obtener su ID
            $response = $client->post('https://backend-culturas.elalto.gob.bo/api/upload', [
                'multipart' => [
                    [
                        'name'     => 'files',
                        'contents' => fopen($file->getRealPath(), 'r'),
                        'filename' => $file->getClientOriginalName(),
                    ],
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . '7b648e5e4c3af96a7f47d7168fdf7d158981888cea87a30fe952ebee679f87abfec93aff1327e3950bc489fc853f09012c7627cdd46429947b42f43c47d9d26a7039a5ed028c3cb40ae088810b9f2ee321632d4c37c783daf3b2739881ebad6deeec567427b183b4c39661deca9c1f551e27b934ffc7bde71f67c36a269e536a',
                    'Accept'        => 'application/json',
                ],
            ]);

            $uploadedFile = json_decode($response->getBody()->getContents(), true);

            // Verifica si se subió correctamente el archivo y obtener su ID
            if (isset($uploadedFile[0]['id'])) {
                $validatedData['foto_cult'] = $uploadedFile[0]['id'];
            } else {
                return redirect()->back()->with('error', 'Error al subir la imagen');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Envía los datos a la API de Strapi para actualizar la entidad
    try {
        $response = $client->put("https://backend-culturas.elalto.gob.bo/api/culturas/$id", [
            'json' => [
                'data' => $validatedData,
            ],
            'headers' => [
                'Authorization' => 'Bearer ' .  '7b648e5e4c3af96a7f47d7168fdf7d158981888cea87a30fe952ebee679f87abfec93aff1327e3950bc489fc853f09012c7627cdd46429947b42f43c47d9d26a7039a5ed028c3cb40ae088810b9f2ee321632d4c37c783daf3b2739881ebad6deeec567427b183b4c39661deca9c1f551e27b934ffc7bde71f67c36a269e536a',
                'Accept'        => 'application/json',
            ],
        ]);

        // Verificar si la respuesta de Strapi fue exitosa
        if ($response->getStatusCode() >= 400) {
            dd($response->getBody()->getContents()); // Para depurar
            return redirect()->back()->with('error', 'Error al actualizar los datos');
        }

        return redirect('admin/culturas')->with('success', 'Datos actualizados correctamente');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}
    
}
