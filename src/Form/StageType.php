<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('mission')
            ->add('email')
            ->add('entreprise',EntrepriseType::class)
            ->add('formations',EntityType::class, array(
                'class' => Formation::class,
                'choice_label' => function(Formation $formation)
                {return $formation->getnomCourt();},

                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
