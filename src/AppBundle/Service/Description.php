<?php

namespace AppBundle\Service;

/**
 * Description of Description
 *
 * @author vitaliy
 */
class Description {

    
    private $subtitle;
    private $fulltext;

    public function setItem(\PicoFeed\Parser\Item $item) {
        
        $full = null;

        if (!empty($full)) {
            $this->subtitle = $item->getContent();
            $this->fulltext = $full;
        } else {
            $this->subtitle = null;
            $this->fulltext = $item->getContent();
        }
    }

    public function getSubtitle() {
        return $this->subtitle;
    }

    public function getFullText() {
        return $this->fulltext;
    }

}
