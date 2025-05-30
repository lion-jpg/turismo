<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\PdfService;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client; 

class ApiController extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function fetchImages()
    {
        $apiUrl = 'https://backend-culturas.elalto.gob.bo/api/imagens?populate=*';

        try {
            $response = Http::withOptions([
                'verify' => false, // Desactiva la verificación SSL
            ])->get($apiUrl);

            if ($response->failed()) {
                // return response()->json(['error' => 'Error al acceder a la API'], 500);
                return view('error');
            }

            $data = $response->json();

            return view('images', ['data' => $data]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function generatePdf($userId)
    {
        $apiUrl = 'https://backend-culturas.elalto.gob.bo/api/imagens?populate=*';
        
        try {
            $response = Http::withOptions([
                'verify' => false, // Desactiva la verificación SSL
            ])->get($apiUrl);

            if ($response->failed()) {
                return response()->json(['error' => 'Error al acceder a la API'], 500);
            }

            $data = $response->json();

        // Encuentra el usuario basado en el ID
            $userData = collect($data['data'])->firstWhere('id', $userId);
            
          
            // || !isset($userData['attributes']))
            if (!$userData ) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
            // dd($userData);
            // Aquí extraemos el nombre del usuario de los datos
           $nombre = $userData['attributes']['nombre'] ?? 'usuario'; // Reemplaza 'nombre' con la clave correcta si es diferente
           
           // Genera el contenido del PDF

            $pdfContent = $this->pdfService->generateUserPdf( $userData['attributes'],$userId);

            return Response::make($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                // 'Content-Disposition' => 'attachment; filename="nombre_'. $userId . '.pdf"',
                'Content-Disposition' => 'attachment; filename="'.$nombre .'.pdf"',
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // agregar datos con el metodo post
    public function post(Request $request)
    {
        $client = new Client(['verify' => false]);
    
        // Obtén los datos del formulario excepto el archivo
        $data = $request->except('foto_guia');
        $file = $request->file('foto_guia');
    
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
                    'Authorization' => 'Bearer ' . '7b648e5e4c3af96a7f47d7168fdf7d158981888cea87a30fe952ebee679f87abfec93aff1327e3950bc489fc853f09012c7627cdd46429947b42f43c47d9d26a7039a5ed028c3cb40ae088810b9f2ee321632d4c37c783daf3b2739881ebad6deeec567427b183b4c39661deca9c1f551e27b934ffc7bde71f67c36a269e536a',
                    'Accept'        => 'application/json',
                ],
            ]);
    
            $uploadedFile = json_decode($response->getBody()->getContents(), true);
    
            // Verificar si se subió correctamente el archivo y obtener su ID
            if (isset($uploadedFile[0]['id'])) {
                // Añadir el ID del archivo subido a los datos de la relación 'foto_guia'
                $data['foto_guia'] = $uploadedFile[0]['id'];  // Cambiado para usar el ID del archivo
            } else {
                return response()->json(['error' => 'Error al subir la imagen'], 500);
            }
    
            // Envía los datos a la API de Strapi, incluyendo el ID de la imagen
            $response = $client->post('https://backend-culturas.elalto.gob.bo/api/imagens', [
                'json' => [
                    'data' => $data,  // Strapi espera que los datos estén dentro de "data"
                    'foto_guia' => [
                        'id' => $uploadedFile[0]['id'],  // Asocia el archivo subido con la entidad
                    ]
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . '7b648e5e4c3af96a7f47d7168fdf7d158981888cea87a30fe952ebee679f87abfec93aff1327e3950bc489fc853f09012c7627cdd46429947b42f43c47d9d26a7039a5ed028c3cb40ae088810b9f2ee321632d4c37c783daf3b2739881ebad6deeec567427b183b4c39661deca9c1f551e27b934ffc7bde71f67c36a269e536a',
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
        'nombre' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'telefono' => 'required|integer',
        'descripcion' => 'required|string|max:255',
        // 'genero' => 'required|in:masculino,femenino,otro',
    ]);

    // Si hay un archivo, maneja la carga del archivo
    $file = $request->file('foto_guia');
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
                $validatedData['foto_guia'] = $uploadedFile[0]['id'];
            } else {
                return redirect()->back()->with('error', 'Error al subir la imagen');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Envía los datos a la API de Strapi para actualizar la entidad
    try {
        $response = $client->put("https://backend-culturas.elalto.gob.bo/api/imagens/$id", [
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
            return redirect()->back()->with('error', 'Error al actualizar los datos');
        }

        return redirect('admin/image-viewer')->with('success', 'Datos actualizados correctamente');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}


}