<?php

namespace EolabsIo\AmazonSpApiClient\Tests;

use EolabsIo\AmazonSpApiResponseParser\Parsers\ListFinancialEventsResponseParser;
use EolabsIo\AmazonSpApiResponseParser\Support\Facades\AmazonSpApiResponseParser;
use EolabsIo\AmazonSpApiResponseParser\Tests\TestCase;

class ListFinancialEventsResponseParserTest extends TestCase
{

    /** @test */
    public function it_can_parse_financial_events_list_response()
    {
        $file = __DIR__ . '/Stubs/Responses/fetchListFinancialEvents.json';
        $jsonString = file_get_contents($file);

        $response = AmazonSpApiResponseParser::fromString($jsonString);

        $financialEvents = $response['FinancialEvents'];

        $this->assertEquals($financialEvents['SellerDealPaymentEventList'][0]['DealDescription'], "test fees");
        $this->assertEquals($financialEvents['ProductAdsPaymentEventList'][0]['TransactionType'], "Charge");
        $this->assertEquals($financialEvents['CouponPaymentEventList'][0]['CouponId'], "AWURESTX");
        $this->assertEquals($financialEvents['CouponPaymentEventList'][0]['FeeComponent']['FeeType'], "ImagingServicesFee");

        $this->assertEquals($financialEvents['RefundEventList'][0]['ShipmentFeeList'][0]['FeeType'], "Commission");
    }

}
