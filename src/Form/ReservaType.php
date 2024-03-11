<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Habitacion;
use App\Entity\Reserva;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha_reserva', null, [
                'widget' => 'single_text',
                'label_attr' => ['class' => 'fw-bolder']
            ])
            ->add('fecha_llegada', null, [
                'widget' => 'single_text',
                'label_attr' => ['class' => 'fw-bolder']
            ])
            ->add('fecha_salida', null, [
                'widget' => 'single_text',
                'label_attr' => ['class' => 'fw-bolder']
            ])
            ->add('dni_cliente', EntityType::class, [
                'class' => Cliente::class,
                'choice_label' => 'dni',
                'label_attr' => ['class' => 'fw-bolder'],
                'required' => true,
                'placeholder' => 'Selecciona un cliente'
            ])
            ->add('numero_habitacion', EntityType::class, [
                'class' => Habitacion::class,
                'choice_label' => 'numero',
                'label_attr' => ['class' => 'fw-bolder'],
                'required' => true,
                'placeholder' => 'Selecciona un cliente'
            ])
            ->add('guardar', SubmitType::class,
                ["label"=> "Insertar Reserva", 'attr' => ['class' => 'btn btn-success']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reserva::class,
        ]);
    }
}
