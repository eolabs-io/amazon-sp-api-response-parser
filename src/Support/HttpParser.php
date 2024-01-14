<?php

namespace EolabsIo\AmazonSpApiResponseParser\Support;

use EolabsIo\AmazonSpApiResponseParser\Contracts\Parser;
use Illuminate\Support\Collection;
use DOMDocument;

abstract class HttpParser implements Parser
{
    /** @var DOMDocument */
    private $dom;

    public function fromString(string $html): Collection
    {
        $dom = new DOMDocument();
        // @ symbol surpresses the page format error
        @$dom->loadHTML($html);
        return $this->fromDom($dom);
    }

    public function fromDom(DOMDocument $dom): Collection
    {
        return $this->setDom($dom)
                    ->parse();
    }

    private function parse(): Collection
    {
        $dom = $this->getDom();

        return $this->handle($dom);
    }

    abstract public function handle(DOMDocument $dom): Collection;

    private function setDom(DOMDocument $dom)
    {
        $this->dom = $dom;

        return $this;
    }

    protected function getDom(): DOMDocument
    {
        return $this->dom;
    }
}
