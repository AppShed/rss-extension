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

    public function addItemToScreen(\AppBundle\Entity\ArticleItem $item, \AppShed\Remote\Element\Screen\Screen $rootScreen) {

        if ($item->isImageExist()) {
            $link = new \AppShed\Remote\Element\Item\Thumb($item->getTitle(), $item->getSubtitle(), new \AppShed\Remote\Style\Image($item->getImage()));
        } else {
            $link = new \AppShed\Remote\Element\Item\Plain($item->getTitle(), $item->getSubtitle());
        }
        $link->setPaddingBottom('20');
        $link->setHrAfter(true);

        $rootScreen->addChild($link);
        if ($this->config->getHidelistdate()) {
            $rootScreen->addChild($date = new \AppShed\Remote\Element\Item\HTML($item->getDate()->format('D d m Y h:i')));
            $date->setHrAfter(true);
            $link->setHrAfter(false);
        }
        


        $article = new \AppShed\Remote\Element\Screen\Screen($item->getTitle());
        $article->addChild(new \AppShed\Remote\Element\Item\HTML($item->getFulltext()));

        $link->setScreenLink($articleScreen = new \AppShed\Remote\Element\Screen\Screen($this->config->getScreenTitle($item->getTitle())));
        $articleScreen->setCustomCSS('.item.html img { max-width: 100%;  }');
        $articleScreen->addClass('rss-article');





        if ($item->getImage()) {
            $articleScreen->addChild($title = new \AppShed\Remote\Element\Item\Thumb($item->getTitle(), $item->getSubtitle($this->config->getNodescription()), new \AppShed\Remote\Style\Image($item->getImage())));
        } else {
            $articleScreen->addChild($title = new \AppShed\Remote\Element\Item\Plain($item->getTitle(), $item->getSubtitle($this->config->getNodescription())));
        }


        $title->setPaddingBottom('20');
        $title->setHrAfter(false);
        

//        echo $item->getFulltext();

        $articleScreen->addChild(new \AppShed\Remote\Element\Item\HTML($item->getFulltext()));

        if ($this->config->getFulllink()) {

            
            if ($this->config->getImage()) {
                $img = 'http://appshed.com/components/com_appbuilder/assets/images/appbuilder/rss.gif';
            } else {
                $img = 'http://appshed.com/components/com_appbuilder/assets/images/appbuilder/rss.gif';
            }

            $articleScreen->addChild(
                    $seeAllLink = new \AppShed\Remote\Element\Item\Link(
                    $this->config->getFulltext('See full article'), new \AppShed\Remote\Style\Image($img)
            ));

            
            $seeAllLink->setWebLink($item->getLink());
        }
        if ($this->config->getDateinarticle()) {
            $articleScreen->addChild($d = new \AppShed\Remote\Element\Item\Text($item->getDate()->format('D d m Y h:i')));
            $d->setAlign('right');
            $d->addClass('rss-article-date');
            $d->setSize(13);
            $d->setHrAfter(false);
        }



//                $screen->addChild(
//                        new Image(new \AppShed\Remote\Style\Image("http://images.nationalgeographic.com/wpf/media-live/photos/000/005/cache/domestic-cat_516_600x450.jpg"))
//                );
        //$rootScreen->addChild($link);
    }

}
