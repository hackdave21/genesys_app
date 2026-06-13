<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = [
            [
                'title' => 'Spot publicitaire - Ecobank Togo',
                'category' => 'Publicité',
                'description' => 'Spot promotionnel pour le lancement de la nouvelle application mobile Ecobank.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'embed_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?w=600&auto=format&fit=crop',
                'status' => 'visible',
                'is_featured' => true,
            ],
            [
                'title' => 'Aftermovie Mariage - Kokou & Afi',
                'category' => 'Événement',
                'description' => 'Un film émotionnel retraçant le plus beau jour de Kokou et Afi à Lomé.',
                'video_url' => 'https://vimeo.com/76979871',
                'embed_url' => 'https://player.vimeo.com/video/76979871',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=600&auto=format&fit=crop',
                'status' => 'visible',
                'is_featured' => false,
            ],
            [
                'title' => 'Reels Promotionnels - Le Belvédère Terrasse',
                'category' => 'Reels',
                'description' => 'Série de micro-vidéos dynamiques optimisées pour Instagram Reels et TikTok.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'embed_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&auto=format&fit=crop',
                'status' => 'visible',
                'is_featured' => true,
            ],
            [
                'title' => 'Documentaire Institutionnel - GIZ Togo',
                'category' => 'Corporate',
                'description' => 'Présentation des projets de développement durable et d\'insertion des jeunes au Togo.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'embed_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=600&auto=format&fit=crop',
                'status' => 'visible',
                'is_featured' => false,
            ],
            [
                'title' => 'Aftermovie Togo Fashion Show',
                'category' => 'Événement',
                'description' => 'Vidéo récapitulative des coulisses et du défilé de la Fashion Week de Lomé.',
                'video_url' => 'https://vimeo.com/76979871',
                'embed_url' => 'https://player.vimeo.com/video/76979871',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=600&auto=format&fit=crop',
                'status' => 'archive', // Archived video for testing
                'is_featured' => false,
            ]
        ];

        foreach ($videos as $video) {
            Video::create($video);
        }
    }
}
