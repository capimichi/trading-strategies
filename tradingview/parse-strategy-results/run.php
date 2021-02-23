<?php

$source = __DIR__ . '/source';
$fileNames = array_diff(scandir($source), ['..', '.']);

foreach ($fileNames as $fileName) {
    $sourcePath = $source . DIRECTORY_SEPARATOR . $fileName;
    $content = file_get_contents($sourcePath);
    $crawler = new \Symfony\Component\DomCrawler\Crawler($content);
    
    $f = $crawler->filter('table tr');
    if ($f->count()) {
        $rows = $f->each(function ($tr) {
            /** @var \Symfony\Component\DomCrawler\Crawler $tr */
            
            
        });
    }
}
