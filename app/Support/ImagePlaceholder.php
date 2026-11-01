<?php

namespace App\Support;

use Illuminate\Http\Response;

/** Dummy picture returned when an uploaded image is recorded in the database but missing from storage. */
class ImagePlaceholder
{
    public const IMAGE_EXT = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];

    public static function isImageName(?string $name): bool
    {
        return in_array(strtolower(pathinfo((string) $name, PATHINFO_EXTENSION)), self::IMAGE_EXT, true);
    }

    public static function notFound(string $message = 'Image not found', int $size = 400): Response
    {
        $m = e($message);
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="{$size}" height="{$size}" viewBox="0 0 400 400" role="img" aria-label="{$m}">
  <rect width="400" height="400" fill="#f1f3f9"/>
  <rect x="8" y="8" width="384" height="384" fill="none" stroke="#c5cbe0" stroke-width="3" stroke-dasharray="10 8" rx="14"/>
  <g fill="none" stroke="#8a93ab" stroke-width="10" stroke-linecap="round" stroke-linejoin="round">
    <rect x="130" y="120" width="140" height="110" rx="14"/>
    <circle cx="170" cy="157" r="12"/>
    <path d="M136 220l44-44 30 30 20-20 40 40"/>
    <path d="M110 110l180 150" stroke="#ef4444"/>
  </g>
  <text x="200" y="295" text-anchor="middle" font-family="Segoe UI,Arial,sans-serif" font-size="28" font-weight="700" fill="#4b5470">{$m}</text>
  <text x="200" y="328" text-anchor="middle" font-family="Segoe UI,Arial,sans-serif" font-size="17" fill="#6a7389">The file is missing from the server.</text>
</svg>
SVG;

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'no-store',
            'X-Content-Type-Options' => 'nosniff',
            'Content-Security-Policy' => "default-src 'none'; style-src 'unsafe-inline'",
        ]);
    }
}
