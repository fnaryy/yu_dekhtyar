<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\FlipCard;
use App\Models\HeroSetting;

class HomeController extends Controller
{
    public function show()
    {
        $hero      = HeroSetting::current();
        $flipCards = FlipCard::active()->get();
        $cases     = CaseStudy::active()->get();

        // Shape that the front-end JS expects (case switching, render).
        // Done in PHP so Blade and JS use the same data structure.
        $casesForJs = $cases->map(fn (CaseStudy $c) => [
            'id'           => $c->slug,
            'brand'        => $c->brand,
            'category'     => $c->category,
            'problem'      => $c->problem,
            'solution'     => $c->solution,
            'solutionFull' => array_map(
                fn ($p) => is_array($p) ? ($p['text'] ?? '') : $p,
                $c->solution_paragraphs ?? []
            ),
            'platforms'    => array_map(
                fn ($p) => is_array($p) ? ($p['name'] ?? '') : $p,
                $c->platforms ?? []
            ),
            'audience'     => array_map(
                fn ($p) => is_array($p) ? ($p['line'] ?? '') : $p,
                $c->audience ?? []
            ),
            'authors' => [
                'total' => (int) $c->authors_total,
                'micro' => (int) $c->authors_micro,
                'mid'   => (int) $c->authors_mid,
                'top'   => (int) $c->authors_top,
            ],
            'client' => [
                'name'        => $c->client_name,
                'role'        => $c->client_role,
                'initials'    => $c->client_initials,
                'photo'       => $c->client_photo ? asset('storage/' . $c->client_photo) : null,
                'testimonial' => $c->testimonial,
            ],
            'video' => [
                'brand'     => $c->video_brand,
                'author'    => $c->video_author,
                'url'       => $c->video_url,
                'thumbnail' => $c->video_thumbnail
                    ? asset('storage/' . $c->video_thumbnail)
                    : $c->resolved_thumbnail,
                'views' => $c->video_views,
                'date'  => $c->video_date,
            ],
        ])->values();

        return view('site.home', [
            'hero'       => $hero,
            'flipCards'  => $flipCards,
            'cases'      => $cases,
            'casesForJs' => $casesForJs,
        ]);
    }
}
