<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Http;

class ArquitecturaViewer extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Arquitectura';
    protected static string $view = 'filament.pages.arquitectura-viewer';

    public $data = [];

    public function mount()
    {
        $apiUrl = 'https://backend-culturas.elalto.gob.bo/api/arquitecturas?populate=*';

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
