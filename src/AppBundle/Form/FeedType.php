<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class FeedType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('url', null, ['label' => 'RSS link:'])
                ->add('screenTitle', null, ['label' => 'Screen title:'])
                ->add('cleanHtml', null, ['required' => false, 'label'=>'Show article as a plain text without original styles:'])
                ->add('noDescription', null, ['required' => false, 'label' => 'Hide description.'])
                ->add('dateInArticle', null, ['required' => false, 'label' => 'Show date in article.'])
                ->add('hideListDate', null, ['required' => false, 'label' => 'Hide date in list.'])
                ->add('refreshButton', null, ['required' => false, 'label' => 'Show refresh button.'])
                ->add('fullLink', null, ['required' => false, 'label' => 'Show full link (allows a user to see the article fully in the source inside of the app):'])
                ->add('fullText', null, ['required' => false, 'label' => 'Change the standard text on "Full link" of article:'])
                ->add('image', null, ['required' => false, 'label' => 'Change image on "Full link" (insert the link of the image)']);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Feed',
            'view_timezone' => 'UTC',
        ]);
    }

    /**
     * @return string
     */
    public function getName() {
        return 'sony_backendbundle_featuredcontent';
    }

}
