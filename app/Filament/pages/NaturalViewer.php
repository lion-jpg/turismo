<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Http;

class NaturalViewer extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Turismo Natural';
    protected static string $view = 'filament.pages.natural-viewer';

    public $data = [];

    public function mount()
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->get('https://backend-culturas.elalto.gob.bo/api/transportes?populate=*');

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
