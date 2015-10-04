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
                ->add('url')
                ->add('screenTitle', null, ['label' => 'Screen Title'])
                ->add('fullLink', null, ['required' => false])
                ->add('cleanHtml', null, ['required' => false])
                ->add('noDescription', null, ['required' => false])
                ->add('dateInArticle', null, ['required' => false])
                ->add('hideListDate', null, ['required' => false])
                ->add('fullText', null, ['required' => false])
                ->add('refreshButton', null, ['required' => false]);
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
