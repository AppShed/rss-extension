<?php

namespace AppBundle\Service;

/**
 * Description of Config
 *
 * @author vitaliy
 */
use Symfony\Component\HttpFoundation\RequestStack;

class Config {

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    /**
     *
     * @var \AppBundle\Entity\Feed;
     */
    private $feed;

    /**
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     *
     * @var string
     */
    private $url;

    function setUrl($url) {
        $this->url = $url;
    }

    public function setRequest(RequestStack $request_stack) {
        $this->request = $request_stack->getCurrentRequest();

        $identifier = $this->request->query->get('identifier', null);

        if ($identifier) {
            $feed = $this->em->getRepository('AppBundle:Feed')->findOneBy(['identifier' => $identifier]);
            if ($feed) {
                $this->feed = $feed;
            }
        }
    }

    function getUrl() {
        return $this->feed->getUrl();
    }

    public function getScreenTitle($feedTtle) {

        $title = urldecode($this->feed->getScreenTitle());
        if (empty($title)) {
            return mb_substr($feedTtle, 0, 10);
        }
        return $title;
    }

    public function getFulltext($default) {
        return $this->request->query->get('fulltext', $default);
    }

    public function getFulllink() {
        return $this->feed->getFullLink();
    }

    public function getCleanhtml() {
        return $this->feed->getCleanHtml();
    }

    public function getNodescription() {
        return $this->feed->getNoDescription();
    }

    public function getHidelistdate() {
        return $this->feed->getHideListDate();
    }

    public function getDateinarticle() {
        return $this->feed->getDateInArticle();
    }

    public function getRefreshbtn() {
        return $this->feed->getRefreshButton();
    }

    public function getImage() {
        return $this->feed->getImage();
    }

}
