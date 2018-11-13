<?php

namespace BackBundle\Form;

use BackBundle\Repository\ViaRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ViaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $via = $builder->getData();

        $builder->add('name')
                ->add('order')
                ->add('comments', TextareaType::class)
                ->add('sitStart')
                ->add('jump')
                ->add('expo')
                ->add('featured')
                ->add('boulder')
                ->add('grade')
                ->add('parent', EntityType::class, array(
                    'class' => "BackBundle:Via",
                    'placeholder' => 'No tiene padre',
                    'choice_label' => function ($via) {
                        return $via->getOrder() . " - " . $via->getRealName();
                    },
                    'query_builder' => function (ViaRepository $er) use ($via) {
                        return $er->createQueryBuilder('u')->where("u.boulder = :boulder")->setParameter("boulder", $via->getBoulder());
                    },
                ))
                ->add('startAt', EntityType::class, array(
                    'class' => "BackBundle:Via",
                    'placeholder' => 'No comparte arranque',
                    'choice_label' => function ($via) {
                        return $via->getOrder() . " - " .$via->getRealName();
                    },
                    'query_builder' => function (ViaRepository $er) use ($via) {
                        return $er->createQueryBuilder('u')->where("u.boulder = :boulder")->setParameter("boulder", $via->getBoulder());
                    },
                ))
                ->add('endAt', EntityType::class, array(
                    'class' => "BackBundle:Via",
                    'placeholder' => 'No comparte fin',
                    'choice_label' => function ($via) {
                        return $via->getOrder() . " - " .$via->getRealName();
                    },
                    'query_builder' => function (ViaRepository $er) use ($via) {
                        return $er->createQueryBuilder('u')->where("u.boulder = :boulder")->setParameter("boulder", $via->getBoulder());
                    },
                ))
                ->add('draw', HiddenType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BackBundle\Entity\Via'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'backbundle_via';
    }

}
