<?php

namespace AppBundle\Service;

use PicoFeed\Reader\Reader;
use \AppShed\Remote\Element\Screen\Screen;
use \AppShed\Remote\Element\Item\Text;
use \AppShed\Remote\Element\Item\Thumb;
use \AppShed\Remote\Element\Item\Image;
use \AppShed\Remote\Element\Item\Marker;
use \AppShed\Remote\Element\Item\Toggle;
use \AppShed\Remote\HTML\Remote;

/**
 * Description of Feed
 *
 * @author vitaliy
 */
class Feed {

    /**
     *
     * @var Config
     */
    private $config;

    /**
     *
     * @var Element
     */
    private $element;

    /**
     *
     * @var ArticleNormalizer
     */
    private $normalizer;
    private $fulllimit = 40;
    private $limit = 20;
    private $position = 0;

    function __construct(Config $config, Element $element, ArticleNormalizer $normalizer) {
        $this->config = $config;
        $this->element = $element;
        $this->normalizer = $normalizer;
    }

    public function getFeed() {
        //'http://www.lankasrinews.com/rss/LATEST_10_NEWS.XML';
        //'http://feeds.eonline.com/eonline/uk/topstories'
        try {

            
            $reader = new Reader;
            $resource = $reader->download($this->config->getUrl());

            $parser = $reader->getParser(
                    $resource->getUrl(), $this->fixEncoding($resource->getContent()), $resource->getEncoding()
            );

            $feed = $parser->execute();

            $resultScreen = $screen = new Screen ($this->config->getScreenTitle($feed->getTitle()));
            $screen->addClass('rss-screen');
            $screen->addClass('parent ');

            $screen->setRefreshable($this->config->getRefreshbtn());
            foreach ($feed->getItems() as $item) {
                if ($this->checkFullLimit()) {
                       break;
                }

                $item = $this->normalizer->getItem($item);
                if ($this->position >= $this->limit) {
                    $this->position = 0;
                    $screen->addChild($readmore = new Thumb('Read more...', ''));
                    $screen = new Screen($this->config->getScreenTitle($feed->getTitle()));
                    $screen->addClass('rss-screen');
                    $screen->addClass('parent ');
                    $readmore->setScreenLink($screen);
                }

                $this->element->addItemToScreen($item, $screen);
            }
        } catch (Exception $e) {
            $resultScreen = new Screen('Error');
        }
        return $resultScreen;
    }

    private function checkFullLimit() {
        $ret = false;
        if ($this->fulllimit < 0) {
            $ret = true;
        }
        $this->fulllimit--;
        $this->position++;
        return $ret;
    }

    private function fixEncoding($input) {

        if (!function_exists('mb_detect_encoding')) {
            return $input;
        }
        $output_encoding = 'UTF-8';
        $encoding = mb_detect_encoding($input);
        switch ($encoding) {
            case 'ASCII':
            case $output_encoding:
                return $input;
            case '':
                return mb_convert_encoding($input, $output_encoding);
            default:
                return mb_convert_encoding($input, $output_encoding, $encoding);
        }
    }

}
