<?php

namespace EolabsIo\AmazonSpApiClient\Tests;

use EolabsIo\AmazonSpApiResponseParser\Tests\TestCase;
use EolabsIo\AmazonSpApiResponseParser\Support\Facades\GetReportResponseParser;

class GetReportResponseParserTest extends TestCase
{

    /** @test */
    public function it_can_parse_review_rating_response()
    {
        // $file = __DIR__ . '/Stubs/Responses/fetchGetReport.tsv';
        $file = __DIR__ . '/Stubs/Responses/fetchGetReport2.txt';

        $response = file_get_contents($file);

        $response = GetReportResponseParser::fromTabDelimitedString($response);

        $this->assertEquals('100-3590565-0113041', $response[0]['amazon-order-id']);
        $this->assertEquals('ZHQgSDB3K', $response[0]['shipment-id']);
        $this->assertEquals('101-4340462-1457012', $response[1]['amazon-order-id']);
        $this->assertEquals('ZvqslpgZK', $response[1]['shipment-id']);
    }
}
