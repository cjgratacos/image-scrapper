<?php

namespace cjgratacos\ImageScrapper\Processor;

use cjgratacos\ImageScrapper\Stream\HTTPStream;

class HtmlProcessor
{
    private const HTML_IMAGE_TAG = "<img";

    public function getAllImages(HTTPStream $stream):array {

        $stream->openStream();

        $images =[];

        while ($stream->isEndOfStream() !== true) {

            $str = $stream->getStreamString();

            if (!(strpos($str, '<img') === false)) {
                $images[] = $str;
            }
        }

        $stream->closeStream();

        return $images;
    }

    public function getImagesSrc(array $images): array {
        $srcList =[];
        foreach ($images as $image) {
            $match = null;
            preg_match("/src=\".+?\"|src='.+?'/", $image, $match);

            $match = preg_replace('/src="|src=\'|"|\'/','', $match);
            $srcList[] = $match[0];
        }

        return $srcList;
    }

    public function imageSrcFilter(array $srcList, string $filter): array {
        $filteredSrcList = [];

        foreach ($srcList as $src) {
            $match = null;
            if (!(strpos($src,$filter) === false)) {
                $filteredSrcList[] = $src;
            }
        }

        return $filteredSrcList;
    }

    public function imageSrcListStripSuffix(array $srcList, array $suffixes): array {
        $stripperSrcList = [];
        $suffixeList = [];

        foreach ($suffixes as $suffix) {
            $suffixeList[] = "/$suffix/";
        }

        foreach ($srcList as $src) {
            $stripperSrcList[] = preg_replace($suffixeList,"",$src);
        }

        return $stripperSrcList;
    }
}