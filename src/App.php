<?php

namespace cjgratacos\ImageScrapper;

use cjgratacos\ImageScrapper\Processor\HtmlProcessor;
use cjgratacos\ImageScrapper\Stream\Downloader;
use cjgratacos\ImageScrapper\Stream\HTTPStream;

class App
{

    /**
     * @var array
     */
    private $siteInfo;

    /**
     * @var string
     */
    private $folderName;

    /**
     * @var
     */
    private $services;

    /**
     * @param array $siteInfo
     * @param string $folderName
     */
    static function init(array $siteInfo, string $folderName):void {
        $app = new App($siteInfo, $folderName);
        $app->run();
    }

    /**
     * App constructor.
     * @param array $siteInfo
     * @param string $folderName
     */
    function __construct(array $siteInfo, string $folderName) {

        $this->siteInfo = $siteInfo;
        $this->folderName=$folderName;

        $this->loadServices();
    }

    private function loadServices(){
        $this->services['stream:http'] = new HTTPStream($this->siteInfo['name']);
        $this->services['processor:html'] = new HtmlProcessor();
        $this->services['downloader'] = new Downloader();
    }


    private function run():void {

        file_exists($this->folderName)?:mkdir($this->folderName,0775, true);

        $httpStream = $this->services['stream:http'];
        $htmlProcessor = $this->services['processor:html'];
        $downloader = $this->services['downloader'];

        $imagesUrl = $htmlProcessor->imageSrcListStripSuffix(
            $htmlProcessor->imageSrcFilter(
                $htmlProcessor->getImagesSrc(
                    $htmlProcessor->getAllImages($httpStream)
                ),
                $this->siteInfo['img_prefix_url']
            ),
            $this->siteInfo["img_rm_suffix"]
        );


        $downloader->downloadList($imagesUrl, $this->folderName);

    }
}