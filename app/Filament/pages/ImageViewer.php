<?php


namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Http;

class ImageViewer extends Page
{
    //direccion a link guia
    protected static string $view = 'filament.pages.image-viewer';
    protected static ?string $navigationLabel = 'Guias Registrados'; // Cambia el nombre que aparecerá en la navegación
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    
    public $data = [];
    
    public function mount()
    {   
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->get('https://backend-culturas.elalto.gob.bo/api/imagens?populate=*');

            if ($response->successful()) {
                $this->data = $response->json();
            }
        } catch (\Exception $e) {
            $this->data = ['data' => []];
        }
    }

    protected function getViewData(): array
    {
        return [
            'data' => $this->data,
        ];
    }
}