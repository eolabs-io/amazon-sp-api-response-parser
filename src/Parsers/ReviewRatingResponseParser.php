<?php

namespace EolabsIo\AmazonSpApiResponseParser\Parsers;

use DOMDocument;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use EolabsIo\AmazonSpApiResponseParser\Support\HttpParser;

class ReviewRatingResponseParser extends HttpParser
{
    public function handle(DOMDocument $dom): Collection
    {
        return collect()
                ->merge($this->getRatings($dom))
                ->merge($this->getAverageStarsRating($dom));
    }

    public function getRatings(DOMDocument $dom): Collection
    {
        $tagValue = $dom->getElementById('acrCustomerReviewText')->nodeValue;
        $rating = Str::of($tagValue)
                    ->before('ratings')
                    ->replace(',', '')
                    ->trim();

        return collect(['ratings' => intval((string)$rating)]);
    }

    public function getAverageStarsRating(DOMDocument $dom): Collection
    {
        $tagTitleValue = $dom->getElementById('acrPopover')->getAttribute('title');
        $averageStarsRating = Str::of($tagTitleValue)
                                ->before('out of 5')
                                ->trim();

        return collect(['averageStarsRating' => floatval((string)$averageStarsRating)]);
    }
}
