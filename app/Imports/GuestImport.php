<?php

namespace App\Imports;

use App\Models\Guest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class GuestImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {

        $adultos = (int) ($row['adultos'] ?? 0);
        $ninos = (int) ($row['ninos'] ?? 0);
        return new Guest([
            'guest_name'       => $row['texto_invitacion'],
            'max_guests' => $adultos + $ninos,
            'confirmed_guests' => 0,
            'confirmed_at'     => null,
        ]);
    }

    public function rules(): array
    {
        return [
            'invitado'         => ['required', 'string'],
            'adultos'          => ['required', 'integer', 'min:0'],
            'ninos'            => ['nullable', 'integer', 'min:0'],
            'texto_invitacion' => ['required', 'string'],
            'confirmados'      => ['nullable', 'integer', 'min:0'],
        ];
    }
}
