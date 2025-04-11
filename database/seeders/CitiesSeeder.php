<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $cities = [
            ['name' => 'Agadir'],
            ['name' => 'Al Hoceima'],
            ['name' => 'Azrou'],
            ['name' => 'Beni Mellal'],
            ['name' => 'Berkane'],
            ['name' => 'Berrechid'],
            ['name' => 'Boujdour'],
            ['name' => 'Casablanca'],
            ['name' => 'Chefchaouen'],
            ['name' => 'Dakhla'],
            ['name' => 'El Jadida'],
            ['name' => 'Errachidia'],
            ['name' => 'Essaouira'],
            ['name' => 'Fes'],
            ['name' => 'Guelmim'],
            ['name' => 'Ifrane'],
            ['name' => 'Kénitra'],
            ['name' => 'Khémisset'],
            ['name' => 'Khénifra'],
            ['name' => 'Khouribga'],
            ['name' => 'Laayoune'],
            ['name' => 'Larache'],
            ['name' => 'Marrakech'],
            ['name' => 'Meknes'],
            ['name' => 'Mohammedia'],
            ['name' => 'Nador'],
            ['name' => 'Ouarzazate'],
            ['name' => 'Oujda'],
            ['name' => 'Rabat'],
            ['name' => 'Safi'],
            ['name' => 'Salé'],
            ['name' => 'Settat'],
            ['name' => 'Sidi Ifni'],
            ['name' => 'Tanger'],
            ['name' => 'Taza'],
            ['name' => 'Tétouan'],
            ['name' => 'Zagora'],
        ];

        DB::table('cities')->insert($cities);
        
    }
}
