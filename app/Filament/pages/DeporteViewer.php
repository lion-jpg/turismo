<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Http;

class DeporteViewer extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $navigationLabel = 'Deportes';
    protected static string $view = 'filament.pages.deporte-viewer';
    
    public $data = [];

    public function mount()
    {
        $apiUrl = 'https://backend-culturas.elalto.gob.bo/api/deportes?populate=*';

        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->get($apiUrl);

            if ($response->successful()) {
                $this->data = $response->json();
            }
        } catch (\Exception $e) {
            // Manejar el error si es necesario
        }
    }
}
