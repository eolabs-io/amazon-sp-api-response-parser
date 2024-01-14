<?php

namespace EolabsIo\AmazonSpApiResponseParser\Support;

use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;
use EolabsIo\AmazonSpApiResponseParser\Contracts\Parser;

abstract class DomParser implements Parser
{
    /** @var Crawler */
    private $crawler;

    public function fromString(string $html): Collection
    {
        $dom = new Crawler($html);

        return $this->fromDomCrawler($dom);
    }

    public function fromDomCrawler(Crawler $crawler): Collection
    {
        return $this->setCrawler($crawler)
                    ->parse();
    }

    private function parse(): Collection
    {
        $crawler = $this->getCrawler();

        return $this->handle($crawler);
    }

    abstract public function handle(Crawler $crawler): Collection;

    private function setCrawler(Crawler $crawler)
    {
        $this->crawler = $crawler;

        return $this;
    }

    protected function getCrawler(): Crawler
    {
        return $this->crawler;
    }
}
