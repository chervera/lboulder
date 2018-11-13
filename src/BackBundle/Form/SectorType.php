<?php

namespace BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectorType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name')
                ->add('order')
                ->add('slug')
                ->add('image')
                ->add('comments')
                ->add('active')
                ->add('map')
                ->add('code')
                ->add('zona')
                ->add('latLng1', PositionSelectorType::class, array(
                    'label' => "Selecciona el parquing 1",
                    'alternative_points' => $builder->getData()->getGeopositionPointsZones(\BackBundle\Entity\Sector::GEO_ZONES_BOULDERS_PARKING_2)
                        )
                )
                ->add('latLng2', PositionSelectorType::class, array(
                    'label' => "Selecciona el parquing 2",
                    'alternative_points' => $builder->getData()->getGeopositionPointsZones(\BackBundle\Entity\Sector::GEO_ZONES_BOULDERS_PARKING_1))
                )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BackBundle\Entity\Sector'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'backbundle_sector';
    }

}
