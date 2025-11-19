<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Movimiento;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Categorías de ingreso
        $ingresos = [
            'Sueldo',
            'Freelance',
            'Venta de artículos',
            'Reembolso',
        ];

        // Categorías de gasto
        $gastos = [
            'Alquiler',
            'Comida',
            'Transporte',
            'Internet y servicios',
        ];

        foreach ($ingresos as $nombre) {
            Categoria::create([
                'nombre' => $nombre,
                'tipo' => 'ingreso',
            ]);
        }

        foreach ($gastos as $nombre) {
            Categoria::create([
                'nombre' => $nombre,
                'tipo' => 'gasto',
            ]);
        }

        $movimientos = [
            // Enero - Mes mixto, ligero predominio de gastos
            ['Sueldo', 4000, '2025-01-01'],
            ['Freelance', 300, '2025-01-05'],
            ['Venta de artículos', 150, '2025-01-10'],
            ['Alquiler', -1200, '2025-01-02'],
            ['Comida', -400, '2025-01-04'],
            ['Transporte', -120, '2025-01-06'],
            ['Internet y servicios', -210, '2025-01-08'],
            ['Comida', -200, '2025-01-15'],
            ['Freelance', 500, '2025-01-20'],
            ['Venta de artículos', 100, '2025-01-22'],

            // Febrero - Mes con bastantes ingresos y menos gastos
            ['Sueldo', 4000, '2025-02-01'],
            ['Freelance', 1000, '2025-02-03'],
            ['Venta de artículos', 450, '2025-02-07'],
            ['Reembolso', 200, '2025-02-10'],
            ['Alquiler', -1200, '2025-02-02'],
            ['Comida', -250, '2025-02-05'],
            ['Transporte', -90, '2025-02-06'],
            ['Internet y servicios', -180, '2025-02-08'],
            ['Comida', -300, '2025-02-18'],
            ['Freelance', 700, '2025-02-20'],

            // Marzo - Mes fuerte en ingresos (subidón)
            ['Sueldo', 4000, '2025-03-01'],
            ['Freelance', 1200, '2025-03-02'],
            ['Venta de artículos', 500, '2025-03-05'],
            ['Reembolso', 300, '2025-03-06'],
            ['Freelance', 900, '2025-03-08'],
            ['Venta de artículos', 350, '2025-03-09'],
            ['Sueldo', 4000, '2025-03-15'],
            ['Freelance', 1100, '2025-03-16'],
            ['Reembolso', 200, '2025-03-20'],

            // Abril - Mes fuerte en gastos (bajada)
            ['Alquiler', -1300, '2025-04-01'],
            ['Comida', -500, '2025-04-02'],
            ['Transporte', -150, '2025-04-03'],
            ['Internet y servicios', -250, '2025-04-04'],
            ['Comida', -400, '2025-04-05'],
            ['Alquiler', -1200, '2025-04-10'],
            ['Transporte', -100, '2025-04-12'],
            ['Comida', -350, '2025-04-15'],
            ['Internet y servicios', -220, '2025-04-18'],
            ['Alquiler', -1200, '2025-04-20'],

            // Mayo - Mes mixto pero con predominio de gastos
            ['Sueldo', 4000, '2025-05-01'],
            ['Freelance', 600, '2025-05-03'],
            ['Venta de artículos', 200, '2025-05-06'],
            ['Reembolso', 150, '2025-05-07'],
            ['Alquiler', -1200, '2025-05-02'],
            ['Comida', -450, '2025-05-04'],
            ['Transporte', -120, '2025-05-05'],
            ['Internet y servicios', -210, '2025-05-09'],
            ['Comida', -280, '2025-05-12'],
            ['Freelance', 700, '2025-05-15'],
            ['Venta de artículos', 300, '2025-05-16'],

            // Junio - Otro mes fuerte en ingresos (subidón)
            ['Sueldo', 4200, '2025-06-01'],
            ['Freelance', 1300, '2025-06-02'],
            ['Venta de artículos', 450, '2025-06-04'],
            ['Reembolso', 250, '2025-06-05'],
            ['Freelance', 1100, '2025-06-08'],
            ['Venta de artículos', 300, '2025-06-09'],
            ['Sueldo', 4000, '2025-06-10'],
            ['Freelance', 900, '2025-06-12'],
            ['Reembolso', 150, '2025-06-15'],

            // Julio - Mes mixto con subidas y bajadas
            ['Sueldo', 4000, '2025-07-01'],
            ['Freelance', 850, '2025-07-02'],
            ['Venta de artículos', 350, '2025-07-04'],
            ['Reembolso', 120, '2025-07-05'],
            ['Alquiler', -1200, '2025-07-03'],
            ['Comida', -350, '2025-07-06'],
            ['Transporte', -120, '2025-07-07'],
            ['Internet y servicios', -230, '2025-07-08'],
            ['Comida', -190, '2025-07-12'],
            ['Freelance', 700, '2025-07-14'],
            ['Venta de artículos', 300, '2025-07-15'],

            // Agosto - Mes mixto con predominio de gastos
            ['Sueldo', 4000, '2025-08-01'],
            ['Freelance', 900, '2025-08-03'],
            ['Venta de artículos', 320, '2025-08-05'],
            ['Reembolso', 110, '2025-08-07'],
            ['Alquiler', -1200, '2025-08-02'],
            ['Comida', -400, '2025-08-04'],
            ['Transporte', -130, '2025-08-06'],
            ['Internet y servicios', -220, '2025-08-08'],
            ['Comida', -210, '2025-08-12'],
            ['Freelance', 670, '2025-08-13'],
            ['Venta de artículos', 260, '2025-08-14'],
        ];



        foreach ($movimientos as [$categoriaNombre, $monto, $fecha]) {
            $categoria = Categoria::where('nombre', $categoriaNombre)->first();

            Movimiento::create([
                'fecha' => Carbon::parse($fecha),
                'monto' => abs($monto),
                'categoria_id' => $categoria->id,
                'descripcion' => 'Auto generado para pruebas',
            ]);
        }
    }
}
