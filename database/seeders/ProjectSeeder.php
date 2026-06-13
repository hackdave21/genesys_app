<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch clients if any
        $clientKofi = User::where('email', 'kofi.adzoa@example.com')->first();
        $clientAbla = User::where('email', 'abla@creation.tg')->first();

        // Fetch quotes if any
        $quoteSarakawa = Quote::where('client_name', 'Hotel Sarakawa')->first();
        $quoteBelvedere = Quote::where('client_name', 'Le Belvédère')->first();
        $quoteAbla = Quote::where('client_name', 'Abla Création')->first();

        $projects = [
            [
                'title' => 'Spot Ecobank Togo',
                'quote_id' => null,
                'client_id' => $clientKofi ? $clientKofi->id : null,
                'progress' => 20,
                'step' => 'Scripting',
                'priority' => 'Urgent',
                'team' => ['TA', 'AK'],
                'deadline' => '2026-07-10',
            ],
            [
                'title' => 'Reels Le Belvédère',
                'quote_id' => $quoteBelvedere ? $quoteBelvedere->id : null,
                'client_id' => null,
                'progress' => 10,
                'step' => 'Scripting',
                'priority' => 'Moyen',
                'team' => ['TA'],
                'deadline' => '2026-07-20',
            ],
            [
                'title' => 'Mariage Kokou & Afi',
                'quote_id' => null,
                'client_id' => null,
                'progress' => 50,
                'step' => 'Tournage',
                'priority' => 'Urgent',
                'team' => ['KD', 'EY'],
                'deadline' => '2026-06-25',
            ],
            [
                'title' => 'Spot Hôtel Sarakawa',
                'quote_id' => $quoteSarakawa ? $quoteSarakawa->id : null,
                'client_id' => $clientKofi ? $clientKofi->id : null,
                'progress' => 40,
                'step' => 'Tournage',
                'priority' => 'Bas',
                'team' => ['TA', 'KD'],
                'deadline' => '2026-06-28',
            ],
            [
                'title' => 'Motion GIZ Togo',
                'quote_id' => null,
                'client_id' => null,
                'progress' => 80,
                'step' => 'Montage',
                'priority' => 'Urgent',
                'team' => ['AK'],
                'deadline' => '2026-06-15',
            ],
            [
                'title' => 'Aftermovie Togo Fashion',
                'quote_id' => $quoteAbla ? $quoteAbla->id : null,
                'client_id' => $clientAbla ? $clientAbla->id : null,
                'progress' => 70,
                'step' => 'Montage',
                'priority' => 'Moyen',
                'team' => ['AK', 'EY'],
                'deadline' => '2026-06-18',
            ],
            [
                'title' => 'Reels Teranga Burger',
                'quote_id' => null,
                'client_id' => null,
                'progress' => 100,
                'step' => 'Terminé',
                'priority' => 'Moyen',
                'team' => ['TA'],
                'deadline' => '2026-05-28',
            ],
            [
                'title' => 'Spot Moov Africa',
                'quote_id' => null,
                'client_id' => null,
                'progress' => 100,
                'step' => 'Terminé',
                'priority' => 'Urgent',
                'team' => ['TA', 'AK'],
                'deadline' => '2026-05-30',
            ]
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
