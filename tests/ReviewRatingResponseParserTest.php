<?php

namespace EolabsIo\AmazonSpApiClient\Tests;

use EolabsIo\AmazonSpApiResponseParser\Tests\TestCase;
use EolabsIo\AmazonSpApiResponseParser\Support\Facades\ReviewRatingResponseParser;

class ReviewRatingResponseParserTest extends TestCase
{

    /** @test */
    public function it_can_parse_review_rating_response()
    {
        $file = __DIR__ . '/Stubs/Responses/fetchAmazonReview.html';
        $getReviewResponse = file_get_contents($file);
        // $allReviewsLink = '/Premium-derived-only-Non-GMO-Coconuts/product-reviews/B00XM0Y9SE/ref=cm_cr_dp_d_show_all_btm?ie=UTF8&reviewerType=all_reviews';

        $response = ReviewRatingResponseParser::fromString($getReviewResponse);

        $this->assertEquals(11976, $response['ratings']);
        $this->assertEquals(4.7, $response['averageStarsRating']);
    }
}
