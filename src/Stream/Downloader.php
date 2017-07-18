<?php

namespace cjgratacos\ImageScrapper\Stream;


class Downloader
{

    public function download(string $url, string $path):void{
        $name = $this->getLasElementFromUrl($url);

        $resource = fopen($url,'r');

        file_put_contents($path.'/'.$name, $resource);

        fclose($resource);
    }

    public function downloadList(array $urls, string $path):void{
        foreach ($urls as $url) {
            $this->download($url, $path);
        }
    }

    private function getLasElementFromUrl(string $url):string {
        $urlPath = parse_url($url, PHP_URL_PATH);
        $explodedPath = explode('/', $urlPath);
        return end($explodedPath);
    }
}