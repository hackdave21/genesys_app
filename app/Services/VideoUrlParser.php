<?php

namespace App\Services;

class VideoUrlParser
{
    /**
     * Parse a video URL and return the compatible embed URL.
     * Supports YouTube and Vimeo. Returns null if unsupported or invalid.
     */
    public static function parse(string $url): ?string
    {
        $url = trim($url);

        // YouTube Regex
        $youtubePattern = '%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i';
        if (preg_match($youtubePattern, $url, $match)) {
            return 'https://www.youtube.com/embed/' . $match[1];
        }

        // Vimeo Regex
        $vimeoPattern = '%(?:vimeo\.com/|player\.vimeo\.com/video/)([0-9]+)%i';
        if (preg_match($vimeoPattern, $url, $match)) {
            return 'https://player.vimeo.com/video/' . $match[1];
        }

        return null;
    }
}
