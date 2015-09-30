<?php

namespace AppBundle\Service;

/**
 * Description of Config
 *
 * @author vitaliy
 */
use Symfony\Component\HttpFoundation\RequestStack;

class Config {

    protected $request;

    private $url;

    function setUrl($url) {
        $this->url = $url;
    }

    public function setRequest(RequestStack $request_stack) {
        $this->request = $request_stack->getCurrentRequest();
    }

    function getUrl() {
        return $this->request->query->get('url', $this->url);
    }

    public function getScreenTitle($feedTtle) {

        $title = urldecode($this->request->query->get('screenTitle'));
        if (empty($title)) {
            return mb_substr($feedTtle, 0, 10);
        }
        return $title;
    }

    public function getFulltext($default) {
        return $this->request->query->get('fulltext', $default);
    }

    public function getFulllink() {
        return $this->request->query->get('fulllink', true);
    }

    public function getCleanhtml() {
        return $this->request->query->get('cleanhtml');
    }

    public function getNodescription() {
        return $this->request->query->get('nodescription');
    }

    public function getHidelistdate() {
        return $this->request->query->get('hidelistdate', false);
    }

    public function getDateinarticle() {
        return $this->request->query->get('dateinarticle');
    }

    public function getRefreshbtn() {
        return $this->request->query->get('refreshbtn', false);
    }

    public function getImage() {
        return $this->request->query->get('image');
    }

    public function getParent() {
        return $this->request->query->get('parent');
    }

}
