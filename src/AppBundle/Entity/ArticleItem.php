<?php

/**
 * Description of ArticleItem
 *
 * @author vitaliy
 */

namespace AppBundle\Entity;

class ArticleItem {

    private $title;
    private $subtitle;
    private $fulltext;
    private $date;
    private $image;
    private $link;

    public function getTitle() {
        return $this->title;
    }

    public function getSubtitle() {
        return $this->subtitle;
    }

    public function getFulltext() {
        return $this->fulltext;
    }

    public function getDate() {
        return $this->date;
    }

    public function getImage() {
        return $this->image;
    }

    public function getLink() {
        return $this->link;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setSubtitle($subtitle) {
        $this->subtitle = $subtitle;
    }

    public function setFulltext($fulltext) {
        $this->fulltext = $fulltext;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function isImageExist() {
        return $this->image ? true : false;
    }

}
