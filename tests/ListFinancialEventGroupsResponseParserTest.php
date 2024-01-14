<?php

namespace EolabsIo\AmazonSpApiClient\Tests;

use EolabsIo\AmazonSpApiResponseParser\Parsers\ListFinancialEventGroupsResponseParser;
use EolabsIo\AmazonSpApiResponseParser\Support\Facades\AmazonSpApiResponseParser;
use EolabsIo\AmazonSpApiResponseParser\Tests\TestCase;

class ListFinancialEventGroupsResponseParserTest extends TestCase
{

    /** @test */
    public function it_can_parse_order_list_response()
    {
        $file = __DIR__ . '/Stubs/Responses/fetchListFinancialEventGroups.json';
        $jsonString = file_get_contents($file);

        $response = AmazonSpApiResponseParser::fromString($jsonString);

        $this->assertEquals($response->get('NextToken'), "2YgYW55IGNhcm5hbCBwbGVhcEXAMPLE");

        $this->assertEquals($response['FinancialEventGroupList'][0]['FinancialEventGroupId'], "22YgYW55IGNhcm5hbCBwbGVhEXAMPLE");
        $this->assertEquals($response['FinancialEventGroupList'][0]['ProcessingStatus'], "Closed");
    }

}
