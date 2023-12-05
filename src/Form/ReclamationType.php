<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule', null, [
                'label' => 'Intitule', // Add your desired title here
            ])
            ->add('textrec', null, [
                'label' => 'Reclamation', // Add your desired title here
            ])
            ->add('emailu', null, [
                'label' => 'Email', // Add your desired title here
            ])

            // ... other fields
            ->add('recaptcha_response', TextType::class, [
                'mapped' => false, // This field is not mapped to an entity property
                'attr' => [
                    'style' => 'display:none;', // Hide the field
                ],
                'label_attr' => [
                    'style' => 'display:none;', // Hide the label
                ],
            ])

         
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }

    
}
