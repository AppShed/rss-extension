<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \AppShed\Remote\HTML\Remote;

class RssController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {

        
        $this->get('rss.config')->setUrl('http://tamilwin.easyms.com/contents/rss/flash.xml');


        $screen = $this->get('rss.feed')->getFeed();

        $remote = new Remote($screen);

        $r = $remote->getResponse(NULL, false, true);

        $response = new \Symfony\Component\HttpFoundation\Response($r);
        $response->headers->set('Content-type', 'application/json');
        return $response;
    }

    /**
     * @Route("/read", name="read")
     */
    public function readAction() {
        
    }

    private function getScreen(\PicoFeed\Parser\Feed $feed) {

        $mainscreen = new Screen($this->getTitle(mb_substr($feed->getTitle(), 0, 10)));

        $mainscreen->addClass('rss-screen');
        $mainscreen->addClass('parent' . JRequest::getvar('parent', false));

        if (JRequest::getvar('refreshbtn', false)) {
            $mainscreen->addChild($b = new AppBuilderAPIHeaderButtonItem(''));
            $b->setRefreshLink(true);
            $b->addClass('refresh');
        }
        $limit = 21;
        $curcount = 0;
        $firstMainScreen = $mainscreen;
        $itemscount = count($feed->getItems());
        $fulllimit = 40;
        if ($itemscount > 0) {
            foreach ($feed->getItems() as $item) {

                if ($fulllimit < 0)
                    break;
                $fulllimit--;
                $curcount++;
                if ($curcount >= $limit) {
                    $curcount = 0;
                    $mainscreen->addChild($readmore = new AppBuilderAPIThumbItem('Read more...', ''));
                    $mainscreen = new Screen($this->getTitle(mb_substr($item->getTitle(), 0, 10)));
                    $mainscreen->addClass('rss-screen');
                    $mainscreen->addClass('parent' . JRequest::getvar('parent', false));
                    $readmore->setScreenLink($mainscreen);
                }

                ////$html = new FormattedItem($this->imageslink($item->textcontent));

                $text = $item->getContent();
                $full = $item->full;


                if (!empty($full)) {
                    $subtitle = $item->getContent();
                    $textContent = $full;
                } else {
                    $subtitle = '';
                    $textContent = $text;
                }

                if ($item->image) {
                    $mainscreen->addChild($plainlink = new AppBuilderAPIThumbItem($item->getTitle(), $subtitle, $item->image));
                } else {
                    $mainscreen->addChild($plainlink = new AppBuilderAPIPlainItem($item->getTitle(), $subtitle));
                }

                if (!JRequest::getvar('hidelistdate', false)) {
                    $mainscreen->addChild($d = new AppBuilderAPITextItem($item->date));
                    $d->setHrAfter(true);
                    $plainlink->setHrAfter(false);
                } else {
                    $plainlink->setHrAfter(true);
                }


                $plainlink->setScreenLink($screenWithArticle = new AppBuilderAPIListScreen($this->getTitle(mb_substr($item->getTitle(), 0, 10))));
                $screenWithArticle->setCSSText('.item.html img { max-width: 100%;  }');
                $screenWithArticle->addClass('rss-article');

                if (JRequest::getvar('nodescription', false)) {
                    $subtitle = '';
                }

                if (JRequest::getvar('dateinarticle', false)) {
                    $screenWithArticle->addChild($d = new AppBuilderAPITextItem($item->date));
                    $d->setAlign('right');
                    $d->addClass('rss-article-date');
                    $d->setSize(13);
                    $d->setHrAfter(false);
                }

                if ($item->image) {
                    $screenWithArticle->addChild($title = new \AppShed\Remote\Element\Item\Thumb($item->getTitle(), $subtitle, $item->image));
                } else {
                    $screenWithArticle->addChild($title = new \AppShed\Remote\Element\Item\Thumb($item->getTitle(), $subtitle));
                }


                $title->setPaddingBottom('20');
                $title->setHrAfter(false);
                if (JRequest::getvar('cleanhtml', false)) {
                    $textContent = html_entity_decode(strip_tags($textContent), ENT_NOQUOTES, 'UTF-8');
                }


                $screenWithArticle->addChild(new AppBuilderAPIFormattedItem($textContent));

                if (JRequest::getVar('fulllink', true)) {

                    $alltext = JRequest::getvar('fulltext', 'See full article');
                    $screenWithArticle->addChild($seeAllLink = new AppBuilderAPILinkItem($alltext));


                    $image = JRequest::getInt('image', 0);
                    if ($image == 0) {
                        $seeAllLink->setIcon(JRoute::_(JURI::base() . 'components/com_appbuilder/assets/images/appbuilder/rss.gif'));
                    } else {
                        $seeAllLink->setIcon(AppBuilderHelper::getImagesModel()->getSrcForImage($image, AppBuilderImagesHelper::SIZE_PLAIN_LINK));
                    }
                    $seeAllLink->setWebLink($item->getLink());
                }
            }
        } else {
            $mainscreen->addChild(new AppBuilderAPITextItem('No more entries'));
        }
        return $firstMainScreen;
    }

}
