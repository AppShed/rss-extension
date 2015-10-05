<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \AppShed\Remote\HTML\Remote;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RssController extends Controller {

    //http://rss.cnn.com/rss/edition_world.rss
    //http://tamilwin.easyms.com/contents/rss/flash.xml

    /**
     * @Route("/edit/{identifier}", name="editor")
     * @Cache(expires="-2 days", public=false, smaxage="0", maxage="0")
     * @Template()
     */
    public function indexAction(Request $request, $identifier = null) {

        $identifier = $request->query->get('identifier', $identifier);

        $em = $this->getDoctrine()->getManager();

        $feed = $em->getRepository('AppBundle:Feed')->findOneBy(['identifier' => $identifier]);
        if (!$feed) {
            $feed = new \AppBundle\Entity\Feed();
            $feed->setIdentifier($identifier);
            $em->persist($feed);
            $em->flush();
        }


        $feedForm = $this->createEditForm($feed);


        return ['configForm' => $feedForm->createView()];
    }

    /**
     * @Route("/read", name="read")
     */
    public function readAction() {


        $screen = $this->get('rss.feed')->getFeed();

        $remote = new Remote($screen);

        $r = $remote->getResponse(NULL, false, true);

        $response = new \Symfony\Component\HttpFoundation\Response($r);
        $response->headers->set('Content-type', 'application/json');
        return $response;
    }

    /**
     * @Route("/update/{identifier}", name="update")
     * @Template("index.html.twig")
     */
    public function updateAction(Request $request, $identifier) {
        $em = $this->getDoctrine()->getManager();
        $key = ['identifier' => $identifier];

        $feed = $em->getRepository('AppBundle:Feed')->findOneBy($key);

        if (!$feed) {
            return $this->redirect($this->generateUrl('editor'));
        }

        $editForm = $this->createEditForm($feed);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('editor', $key));
        }


        return ['configForm' => $feed->createView()];
    }

    /**
     * Creates a form to create a Pinboard entity.
     *
     * @param Pinboard $feed The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(\AppBundle\Entity\Feed $feed) {
        $form = $this->createForm(new \AppBundle\Form\FeedType(), $feed, [
            'action' => $this->generateUrl('update', ['identifier' => $feed->getIdentifier()]),
            'method' => 'POST'
        ]);

        $form->add('submit', 'submit', [
            'label' => 'Update',
            'attr' => ['class' => 'btn btn-success', 'iconclass' => 'fa fa-save']
        ]);

        return $form;
    }

}
