<?php

namespace EolabsIo\AmazonSpApiResponseParser\Tests;

use EolabsIo\AmazonSpApiResponseParser\Tests\TestCase;
use EolabsIo\AmazonSpApiResponseParser\Support\Facades\AmazonSpApiResponseParser;

class ErrorResponseParserTest extends TestCase
{

    /** @test */
    public function it_can_parse_error_response()
    {
        $file = __DIR__ . '/Stubs/Responses/ErrorResponse.json';
        $jsonString = file_get_contents($file);

        $response = AmazonSpApiResponseParser::fromString($jsonString);

        $this->assertEquals($response['errors'][0]['message'], "Access to requested resource is denied.");
        $this->assertEquals($response['errors'][0]['code'], "Unauthorized");
        $this->assertEquals($response['errors'][0]['details'], "Access token is missing in the request header.");
    }

}
