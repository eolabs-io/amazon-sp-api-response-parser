<?php

namespace EolabsIo\AmazonSpApiClient\Tests;

use EolabsIo\AmazonSpApiResponseParser\Tests\TestCase;
use EolabsIo\AmazonSpApiResponseParser\Support\Facades\ReviewResponseParser;

class ReviewResponseParserTest extends TestCase
{

    /** @test */
    public function it_can_parse_review_response()
    {
        $file = __DIR__ . '/Stubs/Responses/fetchAmazonProductReviewPage.html';
        $getReviewResponse = file_get_contents($file);

        $response = ReviewResponseParser::fromString($getReviewResponse);
        $firstReview = $response['reviews'][0];
        $secondReview = $response['reviews'][1];
        $forthReview = $response['reviews'][4];

        $this->assertCount(10, $response['reviews']);
        $this->assertEquals('R2J4Q876AFF4ID', $firstReview['reviewId']);
        $this->assertEquals(5.0, $firstReview['starRating']);
        $this->assertEquals('This actually works -My first review of anything in over 15 years,', $firstReview['title']);
        $this->assertEquals('June 17, 2019', $firstReview['date']);
        $this->assertTrue($firstReview['verifiedPurchase']);
        $this->assertFalse($firstReview['earlyReviewerRewards']);

        $this->assertEquals('Jeannie', $secondReview['profileName']);
        $this->assertEquals($this->forthReviewBody(), $forthReview['body']);

        $this->assertEquals(4.3, $response['averageStarsRating']);
        $this->assertEquals(437, $response['numberOfReviews']);
        $this->assertEquals(923, $response['numberOfRatings']);

        $this->assertFalse($response['hasCaptcha']);
    }

    /** @test */
    public function it_can_parse_review_with_image_response()
    {
        $file = __DIR__ . '/Stubs/Responses/fetchAmazonProductPageReviewWithImage.html';
        $getReviewResponse = file_get_contents($file);

        $response = ReviewResponseParser::fromString($getReviewResponse);
        $expectedImage = 'https://images-na.ssl-images-amazon.com/images/I/716poX6awhL._SY88.jpg';

        $this->assertCount(7, $response['reviews']);
        $this->assertCount(3, $response['reviews'][3]['images']);
        $this->assertTrue($response['reviews'][3]['vineVoice']);
        $this->assertFalse($response['reviews'][2]['vineVoice']);
        $this->assertContains($expectedImage, $response['reviews'][3]['images']);
        $this->assertEquals(17, $response['numberOfReviews']);
        $this->assertEquals(23, $response['numberOfRatings']);

        $this->assertFalse($response['hasCaptcha']);
    }

    /** @test */
    public function it_can_parse_review_with_early_reviewer_rewards()
    {
        $file = __DIR__ . '/Stubs/Responses/fetchAmazonProductPageReviewWithEarlyReviewerRewards.html';
        $getReviewResponse = file_get_contents($file);

        $response = ReviewResponseParser::fromString($getReviewResponse);

        $this->assertCount(10, $response['reviews']);
        $this->assertTrue($response['reviews'][1]['verifiedPurchase']);
        $this->assertFalse($response['reviews'][1]['earlyReviewerRewards']);
        $this->assertTrue($response['reviews'][2]['verifiedPurchase']);
        $this->assertTrue($response['reviews'][2]['earlyReviewerRewards']);
        $this->assertEquals(17, $response['numberOfReviews']);
        $this->assertEquals(23, $response['numberOfRatings']);

        $this->assertFalse($response['hasCaptcha']);
    }

    /** @test */
    public function it_can_parse_review_with_bug()
    {
        $file = __DIR__ . '/Stubs/Responses/fetchAmazonProductReviewPageBug.html';
        $getReviewResponse = file_get_contents($file);

        $response = ReviewResponseParser::fromString($getReviewResponse);

        $this->assertCount(9, $response['reviews']);
        $this->assertTrue($response['reviews'][1]['verifiedPurchase']);
        $this->assertFalse($response['reviews'][1]['earlyReviewerRewards']);
        $this->assertTrue($response['reviews'][4]['verifiedPurchase']);
        $this->assertTrue($response['reviews'][4]['earlyReviewerRewards']);
        $this->assertEquals('United States', $response['reviews'][4]['location']);


        $this->assertEquals('Chris', $response['reviews'][8]['profileName']);
        $this->assertEquals(1, $response['reviews'][8]['starRating']);
        $this->assertEquals('Was inactive probiotic', $response['reviews'][8]['title']);
        $this->assertEquals('Australia', $response['reviews'][8]['location']);

        $this->assertEquals(79, $response['numberOfReviews']);
        $this->assertEquals(244, $response['numberOfRatings']);

        $this->assertFalse($response['hasCaptcha']);
    }

    /** @test */
    public function it_can_detect_captcha()
    {
        $file = __DIR__ . '/Stubs/Responses/fetchAmazonProductReviewWithCaptcha.html';
        $getReviewResponse = file_get_contents($file);

        $response = ReviewResponseParser::fromString($getReviewResponse);

        $this->assertTrue($response['hasCaptcha']);
    }

    public function forthReviewBody(): string
    {
        return "This stuff basically cured my anxiety when taken overtime. Gut health has shown to be highly related to brain health-- having healthy gut bacteria sends signals to your brain to relax. Research shows this also having healthy gut bacteria actually repairs the blood brain barrier, which becomes damaged overtime due to relentless stress and anxiety.This stuff works almost too well. After 4 months taking this daily and feeling much better than when I started, the effects are still profound. I find that this can make you feel a tad bit off, almost too calm and clear, it's slightly off putting when surrounded by nominally stressed individuals haha. But if when you're deeply suffering from anxiety, I urge you to please try this.";
    }
}
