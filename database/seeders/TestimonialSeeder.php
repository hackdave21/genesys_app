<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Jean Dupont',
                'company_role' => 'Directeur Marketing - Ecobank Togo',
                'content' => 'GENESYS House a transcendé nos attentes. Le spot publicitaire pour notre gala de fin d\'année a eu un impact retentissant auprès de nos partenaires.',
                'status' => 'published',
            ],
            [
                'client_name' => 'Marie-Claire A.',
                'company_role' => 'Fondatrice - Abla Création',
                'content' => 'L\'aftermovie de notre défilé de mode à Lomé est tout simplement sublime. L\'équipe a su capturer l\'essence créative de nos collections.',
                'status' => 'published',
            ],
            [
                'client_name' => 'Marc Alipoe',
                'company_role' => 'Gérant - Le Belvédère',
                'content' => 'Grâce aux 4 Reels dynamiques produits par GENESYS, notre taux de réservation de table a augmenté de 35%. Une arme redoutable pour notre communication.',
                'status' => 'published',
            ],
            [
                'client_name' => 'Kofi Mensah',
                'company_role' => 'Directeur - Cabinet Mensah',
                'content' => 'Une équipe réactive, professionnelle et à l\'écoute. Notre spot TV national a été livré dans les temps avec une qualité irréprochable.',
                'status' => 'draft', // Draft testimonial for testing
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
