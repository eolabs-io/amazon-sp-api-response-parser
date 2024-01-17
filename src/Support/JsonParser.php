<?php

namespace EolabsIo\AmazonSpApiResponseParser\Support;

use EolabsIo\AmazonSpApiResponseParser\Contracts\Parser;
use EolabsIo\AmazonSpApiResponseParser\Exceptions\AmazonSpApiResponseParserException;
use Illuminate\Support\Collection;

abstract class JsonParser implements Parser
{
    /** @var array */
    private $json;


    public function fromString(string $jsonString): Collection
    {
        $json = json_decode($jsonString, true);

        return $this->fromJson($json);
    }

    public function fromJson(array $json): Collection
    {
        return $this->setJson($json)
                    ->parse();
    }

    private function parse(): Collection
    {
        $json = $this->getJson();

        $errorsAccessor = $this->getErrorsAccessor();
        $hasErrors = array_key_exists($errorsAccessor, $json);
        $contentAccessor = $this->getContentAccessor();

        $results = ($hasErrors)
            ? $json
            : data_get($json, $contentAccessor);

        throw_if(! filled($results), AmazonSpApiResponseParserException::class);

        return collect($results);
    }

    public function getErrorsAccessor(): string
    {
        return 'errors';
    }

    public function getContentAccessor(): string
    {
        return 'payload';
    }

    private function setJson(array $json)
    {
        $this->json = $json;

        return $this;
    }

    protected function getJson(): array
    {
        return $this->json;
    }

}
