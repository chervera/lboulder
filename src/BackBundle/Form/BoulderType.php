<?php

namespace BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BoulderType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name')->add('order')->add('slug')->add('sector');
        $builder->add('imageFile', VichImageType::class, [
            'required' => false,
            'allow_delete' => true,
                //'download_label' => '...',
                //'download_uri' => true,
                //'image_uri' => true,
                //'imagine_pattern' => '...',
        ]);
        $builder->add('latLng', PositionSelectorType::class, array(
            'label' => "Selecciona la posició del boulder",
            'alternative_points' => $builder->getData()->getSector()->getGeopositionPointsZones(\BackBundle\Entity\Sector::GEO_ZONES_BOULDERS_PARKING_1))
        )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BackBundle\Entity\Boulder'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'backbundle_boulder';
    }

}
