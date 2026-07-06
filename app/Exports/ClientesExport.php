<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientesExport implements FromCollection, WithHeadings
{

    public $city;

    public function __construct($city)
    {
        $this->city = $city->id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cliente::where('ciudad_id', $this->city)->get()
            ->map(function($cliente){
                return [
                    $cliente->nombre,
                    $cliente->email,
                    $cliente->telefono,
                    $cliente->activo == 1 ? 'Activo' : 'Inactivo',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Email',
            'Telefono',
            'Activo',
        ];
    }
}
