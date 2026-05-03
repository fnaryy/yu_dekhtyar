<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CaseStudy extends Model
{
    /**
     * Eloquent's plural for "Case" is "cases" — fortunate, but the class name
     * `Case` is a PHP reserved keyword, so the model is `CaseStudy` and we pin
     * the table name explicitly.
     */
    protected $table = 'cases';

    protected $guarded = [];

    protected $casts = [
        'solution_paragraphs' => 'array',
        'platforms'           => 'array',
        'audience'            => 'array',
        'is_active'           => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Resolve the YouTube thumbnail URL from the video URL when no override is set.
     * Returns null when the URL is not a recognised YouTube link.
     */
    public function getResolvedThumbnailAttribute(): ?string
    {
        if ($this->video_thumbnail) {
            return $this->video_thumbnail;
        }

        $id = $this->extractYouTubeId($this->video_url);
        return $id ? "https://img.youtube.com/vi/{$id}/maxresdefault.jpg" : null;
    }

    private function extractYouTubeId(?string $url): ?string
    {
        if (!$url) return null;

        // youtu.be/<id>
        if (preg_match('~youtu\.be/([A-Za-z0-9_-]{11})~', $url, $m)) return $m[1];

        // youtube.com/watch?v=<id> or youtube.com/embed/<id> or youtube.com/shorts/<id>
        if (preg_match('~youtube\.com/(?:watch\?v=|embed/|shorts/)([A-Za-z0-9_-]{11})~', $url, $m)) return $m[1];

        return null;
    }

    /**
     * Slug is auto-generated from brand if not provided.
     */
    protected static function booted(): void
    {
        static::saving(function (self $case) {
            if (empty($case->slug)) {
                $case->slug = Str::slug($case->brand);
            }
        });
    }
}
