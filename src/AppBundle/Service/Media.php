<?php

namespace AppBundle\Service;

/**
 * Description of Media
 *
 * @author vitaliy
 */
class Media {

    private $urldata;
    private $url;

    /**
     *
     * @var Config
     */
    private $config;

    function __construct(Config $config) {
        $this->config = $config;
        $this->urldata = parse_url($this->config->getUrl());
    }

    public function setItem(\PicoFeed\Parser\Item $item) {
        $this->url = null;
        $this->findImage($item->xml);
    }

    private function findImage(\SimpleXMLElement $el) {
        $found = false;
        $ns = $el->getNamespaces(true);
        if (array_key_exists('media', $ns)) {
            foreach ($el->children($ns['media']) as $mmm) {
                $url = strval($mmm->attributes()->url);
                if (empty($this->url) && !empty($url)) {
                    $this->url = $url;
                }
            }
        }
        foreach ($el as $key => $value) {
            $url = strval($value);
            if ($value->getName() == 'imgURL') {
                if (empty($this->url) && !empty($url)) {
                    $this->url = strval($value);
                }
            }
            if ($value->getName() == 'media') {
                if (empty($this->url) && !empty($url)) {
                    $this->url = strval($value);
                }
            }
        }
    }

    public function getImage() {
        if ($this->url) {
            return $this->fixLink($this->url);
        }
        return null;
    }

    private function imageslink($text) {
        $regex = "<img.+?src=\"(.+?)\".+?>";
        preg_match_all($regex, $text, $matches);
        foreach ($matches[1] as $url) {
            //  echo $newurl.'<br>';
            $text = str_replace($url, $this->fixLink($url), $text);
        }
        return $text;
    }

    private function fixLink($url) {

        $imageurlinfo = parse_url($url);
        //  echo $url.'<br>';
        if (isset($imageurlinfo['host'])) {
            $newurl = $url;
        } elseif (isset($imageurlinfo['path'])) {

            if (strpos($imageurlinfo['path'], '/') === 0 and ( empty($imageurlinfo['host']) )) {
                $newurl = $this->urldata['host'] . $url;
            } elseif (empty($imageurlinfo['host'])) {
                $newurl = $this->urldata['host'] . '/' . $this->urldata['path'] . $url;
            } else {
                $newurl = $this->urldata['host'] . $this->urldata['path'] . $url;
            }
            while (strpos($newurl, '//')) {
                $newurl = str_replace('//', '/', $newurl);
            }
            $newurl = $this->urldata['scheme'] . '://' . $newurl;
        }


        return $newurl;
    }

}
