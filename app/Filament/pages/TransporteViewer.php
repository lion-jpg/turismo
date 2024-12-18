<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Http;

class TransporteViewer extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Transporte';
    protected static string $view = 'filament.pages.transporte-viewer';

    public $data = [];

    public function mount()
    {
        $apiUrl = 'https://backend-culturas.elalto.gob.bo/api/transportes?populate=*';

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
