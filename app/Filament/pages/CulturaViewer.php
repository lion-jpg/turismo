<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Http;

class CulturaViewer extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-globe-americas';
    protected static ?string $navigationLabel = 'turismo Comunitario';
    protected static string $view = 'filament.pages.cultura-viewer';

    public $data = [];

    public function mount()
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->get('https://backend-culturas.elalto.gob.bo/api/culturas?populate=*');

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
