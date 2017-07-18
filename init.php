<?php

require_once "vendor/autoload.php";

use cjgratacos\ImageScrapper\App;

$siteInfo = [
    'name' => '<Website>',
    'img_class' =>"img_nofade frame",
    'img_prefix_url' => "<IMGSITE>",
    'img_rm_suffix' =>[
        "-180x160"
        ]
    ];

$folder = __DIR__."/imageFolder";

App::init($siteInfo, $folder);