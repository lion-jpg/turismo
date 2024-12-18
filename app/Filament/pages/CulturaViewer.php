<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Http;

class CulturaViewer extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-globe-americas';
    protected static ?string $navigationLabel = 'Culturas';
    protected static string $view = 'filament.pages.cultura-viewer';

    public $data = [];

    public function mount()
    {
        $apiUrl = 'https://backend-culturas.elalto.gob.bo/api/culturas?populate=*';

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
