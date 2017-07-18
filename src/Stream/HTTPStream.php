<?php

namespace cjgratacos\ImageScrapper\Stream;

class HTTPStream
{

    private $stream;
    private $url;

    function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getStream() {
        return $this->stream;
    }

    public function isEndOfStream():bool {
        return feof($this->stream) === true;
    }

    public function getStreamString(): string {
        return fgets($this->stream);
    }

    public function getAllStreamData(): string {
        return stream_get_contents($this->stream);
    }

    public function openStream() {
        $this->stream = fopen($this->url, 'r');
    }

    public function reopenStream() {
        $this->closeStream();
        $this->stream = fopen($this->stream, 'r');

    }

    public function closeStream() {
        fclose($this->stream);
    }
}