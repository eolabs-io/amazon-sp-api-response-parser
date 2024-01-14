<?php

namespace EolabsIo\AmazonSpApiResponseParser\Support;

use Illuminate\Support\Collection;
use EolabsIo\AmazonSpApiResponseParser\Contracts\Parser;

abstract class CsvParser implements Parser
{
    /** @var array */
    private $csv;

    public function fromTabDelimitedString(string $csv)
    {
        return $this->fromString($csv, "\t");
    }

    public function fromString(string $csv, $delimiter = ","): Collection
    {
        $lines = explode(PHP_EOL, $csv);
        $array = array();
        foreach ($lines as $line) {
            $array[] = str_getcsv($line, $delimiter);
        }

        return $this->setCsv($array)
                    ->parse();
    }

    private function parse(): Collection
    {
        $csv = $this->getCsv();

        return $this->handle($csv);
    }

    abstract public function handle(array $csv): Collection;

    private function setCsv(array $csv)
    {
        $this->csv = $csv;

        return $this;
    }

    protected function getcsv(): array
    {
        return $this->csv;
    }
}
