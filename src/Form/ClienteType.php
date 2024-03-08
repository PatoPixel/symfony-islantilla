<?php

namespace App\Form;

use App\Entity\Cliente;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Range;

class ClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DNI', TextType::class, 
            ["label"=> "DNI", 
            'attr' =>['placeholder' => '9 Carácteres'],
            'label_attr' => ['class' => 'fw-bolder'],
            'constraints' => [
                new Length([
                    'min' => 9,
                    'max' => 9,])]])
            ->add('Nombre', TextType::class, ['label_attr' => ['class' => 'fw-bolder']])
            ->add('Edad', IntegerType::class, [
                'constraints' => [
                    new Range(['min' => 18, 'max' => 120])
                ],
                'attr' =>['placeholder' => 'Tiene que ser mayor de 18 y menor que 120'],
                'label_attr' => ['class' => 'fw-bolder']
            ])
            ->add('guardar', SubmitType::class,
                ["label"=> "Insertar Cliente", 'attr' => ['class' => 'btn btn-success']]);
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cliente::class,
        ]);
    }
}
