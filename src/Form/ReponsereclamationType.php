<?php

namespace App\Form;

use App\Entity\Reponsereclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ReponsereclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('prenom')
            ->add('intitule')
            ->add('textreprec')
            ->add('idrec', TextType::class, [
                'disabled' => true, // Set the field to read-only
                // You may want to customize the display, e.g., 'attr' => ['readonly' => true]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponsereclamation::class,
        ]);
    }
}
