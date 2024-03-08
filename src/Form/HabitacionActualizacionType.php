<?php

namespace App\Form;

use App\Entity\Habitacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class HabitacionActualizacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Numero', IntegerType::class, ["label"=> "Numero de Habitacion (Solo lectura)", 
                'constraints' => [
                    new Range(['min' => 101, 'max' => 999])
                ],
                'attr' =>['placeholder' => 'Primer nº: Bloque    Segundo nº: Planta     Tecer nº: Habitacion         (Ej: 348, Bloque:3, Planta:4, Puerta:8)', 'readonly' => true],
                'label_attr' => ['class' => 'fw-bolder']
            ])
            ->add('Precio', IntegerType::class, [
                'constraints' => [
                    new Range(['min' => 0])
                ],
                'attr' =>['placeholder' => 'Precio por noche'],
                'label_attr' => ['class' => 'fw-bolder']
            ])
            ->add('Bano')
            ->add('Camas', IntegerType::class, [
                'constraints' => [
                    new Range(['min' => 1, 'max' => 6])
                ],
                'attr' =>['placeholder' => 'Nº de camas '],
                'label_attr' => ['class' => 'fw-bolder']
            ])
            ->add('guardar', SubmitType::class,
                ["label"=> "Actualizar Habitación", 'attr' => ['class' => 'btn btn-success']]);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Habitacion::class,
        ]);
    }
}
