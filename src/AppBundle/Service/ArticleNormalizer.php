<?php

namespace AppBundle\Service;

/**
 * Description of ArticleNormalizer
 *
 * @author vitaliy
 */
class ArticleNormalizer {

        /**
     *
     * @var Config
     */
    private $config;

    /**
     *
     * @var Media
     */
    private $media;

    /**
     *
     * @var Description
     */
    private $description;

    function __construct(Config $config, Media $media, Description $description) {
        $this->config = $config;
        $this->media = $media;
        $this->description = $description;
    }

    public function getItem(\PicoFeed\Parser\Item $item) {


        $this->description->setItem($item);
        $this->media->setItem($item);
        $article = new \AppBundle\Entity\ArticleItem();
        $article->setDate($item->getDate());
        $article->setTitle($item->getTitle());
        $article->setSubtitle($this->description->getSubtitle());


        if ($this->config->getCleanhtml()) {
            $textContent = html_entity_decode(strip_tags($this->description->getFullText()), ENT_NOQUOTES, 'UTF-8');
            $article->setFulltext($textContent);
        } else {
            $article->setFulltext($this->description->getFullText());
        }

        $article->setImage($this->media->getImage($article));
        $article->setLink($article->getLink());
        return $article;
    }

}
