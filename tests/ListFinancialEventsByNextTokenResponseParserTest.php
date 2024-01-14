<?php

namespace EolabsIo\AmazonSpApiClient\Tests;

use EolabsIo\AmazonSpApiResponseParser\Parsers\ListFinancialEventsByNextTokenResponseParser;
use EolabsIo\AmazonSpApiResponseParser\Support\Facades\AmazonSpApiResponseParser;
use EolabsIo\AmazonSpApiResponseParser\Tests\TestCase;

class ListFinancialEventsByNextTokenResponseParserTest extends TestCase
{
    /** @test */
    public function it_can_parse_list_financial_events_by_next_token_response()
    {
        $file = __DIR__ . '/Stubs/Responses/fetchListFinancialEventsToken2.json';
        $jsonString = file_get_contents($file);

        $response = AmazonSpApiResponseParser::fromString($jsonString);

        $this->assertEquals($response['FinancialEvents']['SellerDealPaymentEventList'][0]['PostedDate'], "2016-11-21T16:18:15.000Z");
        $this->assertNull($response->get('NextToken'));
    }
}
