<?php

namespace EolabsIo\AmazonSpApiResponseParser\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EolabsIo\AmazonSpApiResponseParser\Skeleton\SkeletonClass
 */
class GetReportResponseParser extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'amazon-get-report-response-parser';
    }
}
