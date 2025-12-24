<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nivel 1
        $municipality = Office::create([
            'code' => 'MUNI',
            'name' => 'Municipalidad',
            'acronym' => 'MUNI',
            'parent_office_id' => null,
            'level' => 1,
            'manager' => 'Alcalde',
            'status' => true,
        ]);

        // Nivel 2
        $general = Office::create([
            'code' => 'OG',
            'name' => 'Oficina General',
            'acronym' => 'OG',
            'parent_office_id' => $municipality->id,
            'level' => 2,
            'manager' => 'Director General',
            'status' => true,
        ]);

        // Nivel 3
        Office::create([
            'code' => 'LEG',
            'name' => 'Oficina Legal',
            'acronym' => 'LEGAL',
            'parent_office_id' => $general->id,
            'level' => 3,
            'manager' => 'Jefe Legal',
            'status' => true,
        ]);

        Office::create([
            'code' => 'CONT',
            'name' => 'Oficina de Contabilidad',
            'acronym' => 'CONT',
            'parent_office_id' => $general->id,
            'level' => 3,
            'manager' => 'Jefe Contable',
            'status' => true,
        ]);

        Office::create([
            'code' => 'ARCH',
            'name' => 'Archivo Central',
            'acronym' => 'ARCH',
            'parent_office_id' => $general->id,
            'level' => 3,
            'manager' => 'Encargado de Archivo',
            'status' => true,
        ]);
    }
}
