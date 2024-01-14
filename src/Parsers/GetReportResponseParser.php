<?php

namespace EolabsIo\AmazonSpApiResponseParser\Parsers;

use Illuminate\Support\Collection;
use EolabsIo\AmazonSpApiResponseParser\Support\CsvParser;

class GetReportResponseParser extends CsvParser
{
    public function handle(array $csv): Collection
    {
        array_walk($csv, function (&$a) use ($csv) {
            if (count($csv[0]) == count($a)) {
                $a = array_combine($csv[0], $a);
            }
        });
        array_shift($csv); # remove column header

        return collect($csv);
    }
}
