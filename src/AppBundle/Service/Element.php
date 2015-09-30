<?php

namespace AppBundle\Service;

/**
 * Description of Element
 *
 * @author vitaliy
 */
class Element {

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

    public function addItemToScreen(\AppBundle\Entity\ArticleItem $item, \AppShed\Remote\Element\Screen\Screen $screen) {

        if ($item->isImageExist()) {
            $link = new \AppShed\Remote\Element\Item\Thumb($item->getTitle(), $item->getSubtitle(), new \AppShed\Remote\Style\Image($item->getImage()));
        } else {
            $link = new \AppShed\Remote\Element\Item\Plain($item->getTitle(), $item->getSubtitle());
        }
        $link->setPaddingBottom('20');
        $link->setHrAfter(true);

        $screen->addChild($link);
        if ($this->config->getHidelistdate()) {
            $screen->addChild($date = new \AppShed\Remote\Element\Item\HTML($item->date));
            $date->setHrAfter(true);
            $link->setHrAfter(false);
        }
        


        $article = new \AppShed\Remote\Element\Screen\Screen($item->getTitle());
        $article->addChild(new \AppShed\Remote\Element\Item\HTML($item->getFulltext()));

        
       $title = $this->config->getScreenTitle($item->getTitle());

        $link->setScreenLink($screenWithArticle = new \AppShed\Remote\Element\Screen\Screen($title));
        $screenWithArticle->setCustomCSS('.item.html img { max-width: 100%;  }');
        $screenWithArticle->addClass('rss-article');

        if ($this->config->getNodescription()) {
            $subtitle = '';
        }

        if ($this->config->getDateinarticle()) {
            $screenWithArticle->addChild($d = new \AppShed\Remote\Element\Item\Text($item->getDate()));
            $d->setAlign('right');
            $d->addClass('rss-article-date');
            $d->setSize(13);
            $d->setHrAfter(false);
        }


        if ($item->getImage()) {
            $screenWithArticle->addChild($title = new \AppShed\Remote\Element\Item\Thumb($item->getTitle(), $item->getSubtitle(), new \AppShed\Remote\Style\Image($item->getImage())));
        } else {
            $screenWithArticle->addChild($title = new \AppShed\Remote\Element\Item\Plain($item->getTitle(), $item->getSubtitle()));
        }


        $title->setPaddingBottom('20');
        $title->setHrAfter(false);
        

//        echo $item->getFulltext();

        $screenWithArticle->addChild(new \AppShed\Remote\Element\Item\HTML($item->getFulltext()));

        if ($this->config->getFulllink()) {

            
            if ($this->config->getImage()) {
                $img = 'http://appshed.com/components/com_appbuilder/assets/images/appbuilder/rss.gif';
            } else {
                $img = 'http://appshed.com/components/com_appbuilder/assets/images/appbuilder/rss.gif';
            }

            $screenWithArticle->addChild(
                    $seeAllLink = new \AppShed\Remote\Element\Item\Link(
                    $this->config->getFulltext('See full article'), new \AppShed\Remote\Style\Image($img)
            ));

            
            $seeAllLink->setWebLink($item->getLink());
        }



//                $screen->addChild(
//                        new Image(new \AppShed\Remote\Style\Image("http://images.nationalgeographic.com/wpf/media-live/photos/000/005/cache/domestic-cat_516_600x450.jpg"))
//                );
        $screen->addChild($link);
    }

}
