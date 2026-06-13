<?php

namespace Database\Seeders;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Let's create some client users first so that some quotes can link to registered clients
        $client1 = User::create([
            'name' => 'Kofi Adzoa',
            'email' => 'kofi.adzoa@example.com',
            'phone' => '+228 90 12 34 56',
            'role' => 'client',
            'status' => 'active',
            'password' => bcrypt('password123'),
        ]);

        $client2 = User::create([
            'name' => 'Abla Mode',
            'email' => 'abla@creation.tg',
            'phone' => '+228 99 88 77 66',
            'role' => 'client',
            'status' => 'active',
            'password' => bcrypt('password123'),
        ]);

        $quotes = [
            [
                'client_name' => 'Hotel Sarakawa',
                'company' => 'Hôtel Sarakawa Lomé',
                'email' => 'contact@sarakawa.tg',
                'phone' => '+228 90 12 34 56',
                'project_type' => 'Couverture Galas & Fêtes',
                'budget' => '350k – 700k FCFA',
                'description' => 'Bonjour, nous aurions besoin d\'une couverture vidéo complète pour notre gala de fin d\'année en décembre 2026.',
                'status' => 'Nouveau',
                'user_id' => $client1->id, // Linked to registered client Kofi
            ],
            [
                'client_name' => 'NGO Espoir Togo',
                'company' => 'ONG Espoir Togo',
                'email' => 'contact@espoir-togo.org',
                'phone' => '+228 91 23 45 67',
                'project_type' => 'Film Institutionnel 3 min',
                'budget' => 'Sur devis',
                'description' => 'Dans le cadre de notre projet de sensibilisation, nous recherchons une agence pour réaliser un court documentaire institutionnel de 3 minutes.',
                'status' => 'Envoyé',
                'user_id' => null, // Anonymous submission
            ],
            [
                'client_name' => 'Le Belvédère',
                'company' => 'Le Belvédère Lomé',
                'email' => 'belvedere@togo.net',
                'phone' => '+228 92 34 56 78',
                'project_type' => 'Pack 4 Reels Promotion',
                'budget' => '150k – 350k FCFA',
                'description' => 'On veut booster nos réservations pour la terrasse cet été. On aimerait 4 Reels bien dynamiques axés sur nos cocktails.',
                'status' => 'Accepté',
                'user_id' => null,
            ],
            [
                'client_name' => 'Kofi Mensah',
                'company' => 'Cabinet Mensah',
                'email' => 'kofi.mensah@gmail.com',
                'phone' => '',
                'project_type' => 'Spot Publicitaire TV',
                'budget' => '> 700 000 FCFA',
                'description' => 'Nous souhaitons lancer une campagne publicitaire pour notre cabinet. Spot de 30 secondes pour TV nationale.',
                'status' => 'Refusé',
                'user_id' => null,
            ],
            [
                'client_name' => 'Abla Création',
                'company' => 'Abla Mode',
                'email' => 'abla@creation.tg',
                'phone' => '+228 99 88 77 66',
                'project_type' => 'Vidéo de Défilé',
                'budget' => '150k - 350k FCFA',
                'description' => 'Défilé de mode prévu le 12 juin à Lomé. Besoin d\'un aftermovie de 2 minutes.',
                'status' => 'Accepté',
                'user_id' => $client2->id, // Linked to registered client Abla
            ],
            [
                'client_name' => 'Ecobank Bénin',
                'company' => 'Ecobank Bénin',
                'email' => 'benin.marketing@ecobank.com',
                'phone' => '',
                'project_type' => '3 Vidéos Institutionnelles',
                'budget' => 'Sur devis',
                'description' => 'Nous souhaitons réaliser une série de 3 vidéos de témoignages clients au Bénin.',
                'status' => 'Envoyé',
                'user_id' => null,
            ]
        ];

        foreach ($quotes as $quote) {
            Quote::create($quote);
        }
    }
}
