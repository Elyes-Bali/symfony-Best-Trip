<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('tel', TextType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => 'Numéro de téléphone',
                    'pattern' => '[0-9]+', // Allow only numeric input
                ],])
            ->add('mdp')
            ->add('age',BirthdayType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
            
                'attr' => ['placeholder' => 'Age'],
            ])
           ->add ('gender', ChoiceType::class, [
            'label' => 'Genre',
            'choices' => [
                'Femme' => 'femme',
                'Homme' => 'homme',
            ],
            'expanded' => true, 
            'multiple' => false,
    
            
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
    
}
