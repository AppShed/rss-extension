<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feed
 *
 * @ORM\Table(indexes={@ORM\Index(name="uniq", columns={"identifier"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\FeedRepository")
 */
class Feed {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="rssScreenTitle", type="string", length=255, nullable=true)
     */
    private $screenTitle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rssFullLink", type="boolean")
     */
    private $fullLink = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rssCleanHtml", type="boolean")
     */
    private $cleanHtml = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rssNoDescription", type="boolean")
     */
    private $noDescription = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rssDateInArticle", type="boolean")
     */
    private $dateInArticle = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rssHideListDate", type="boolean")
     */
    private $hideListDate = false;

    /**
     * @var string
     *
     * @ORM\Column(name="rssFullText", type="string", nullable=true)
     */
    private $fullText;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rssRefreshButton", type="boolean")
     */
    private $refreshButton = true;

    /**
     * @var string
     *
     * @ORM\Column(name="rssImage", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=255, unique=true,)
     */
    private $identifier;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set screenTitle
     *
     * @param string $screenTitle
     * @return Feed
     */
    public function setScreenTitle($screenTitle) {
        $this->screenTitle = $screenTitle;

        return $this;
    }

    /**
     * Get screenTitle
     *
     * @return string 
     */
    public function getScreenTitle() {
        return $this->screenTitle;
    }

    /**
     * Set fullLink
     *
     * @param boolean $fullLink
     * @return Feed
     */
    public function setFullLink($rssFullLink) {
        $this->fullLink = $rssFullLink;

        return $this;
    }

    /**
     * Get fullLink
     *
     * @return boolean 
     */
    public function getFullLink() {
        return $this->fullLink;
    }

    /**
     * Set cleanHtml
     *
     * @param boolean $cleanHtml
     * @return Feed
     */
    public function setCleanHtml($cleanHtml) {
        $this->cleanHtml = $cleanHtml;

        return $this;
    }

    /**
     * Get cleanHtml
     *
     * @return boolean 
     */
    public function getCleanHtml() {
        return $this->cleanHtml;
    }

    /**
     * Set noDescription
     *
     * @param boolean $noDescription
     * @return Feed
     */
    public function setNoDescription($noDescription) {
        $this->noDescription = $noDescription;

        return $this;
    }

    /**
     * Get noDescription
     *
     * @return boolean 
     */
    public function getNoDescription() {
        return $this->noDescription;
    }

    /**
     * Set dateInArticle
     *
     * @param boolean $dateInArticle
     * @return Feed
     */
    public function setDateInArticle($dateInArticle) {
        $this->dateInArticle = $dateInArticle;

        return $this;
    }

    /**
     * Get dateInArticle
     *
     * @return boolean 
     */
    public function getDateInArticle() {
        return $this->dateInArticle;
    }

    /**
     * Set hideListDate
     *
     * @param boolean $hideListDate
     * @return Feed
     */
    public function setHideListDate($hideListDate) {
        $this->hideListDate = $hideListDate;

        return $this;
    }

    /**
     * Get hideListDate
     *
     * @return boolean 
     */
    public function getHideListDate() {
        return $this->hideListDate;
    }

    /**
     * Set fullText
     *
     * @param boolean $fullText
     * @return Feed
     */
    public function setFullText($fullText) {
        $this->fullText = $fullText;

        return $this;
    }

    /**
     * Get fullText
     *
     * @return boolean 
     */
    public function getFullText() {
        return $this->fullText;
    }

    /**
     * Set refreshButton
     *
     * @param boolean $refreshButton
     * @return Feed
     */
    public function setRefreshButton($refreshButton) {
        $this->refreshButton = $refreshButton;

        return $this;
    }

    /**
     * Get refreshButton
     *
     * @return boolean 
     */
    public function getRefreshButton() {
        return $this->refreshButton;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Feed
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Feed
     */
    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return Feed
     */
    public function setIdentifier($identifier) {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string 
     */
    public function getIdentifier() {
        return $this->identifier;
    }

}
