<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class UserType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class)
            ->add('apellido',TextType::class)
            ->add('email',EmailType::class)
            ->add('telefono',NumberType::class,[
                'required'=>false
            ])
            ->add('dni',NumberType::class)
            ->add('provincia',ChoiceType::class, [
                'choices'=> [
                    'Buenos Aires' => 'Buenos Aires',
                    'Catamarca' => 'Catamarca',
                    'Chaco' => 'Chaco',
                    'Chubut' => 'Chubut',
                    'Córdoba' => 'Córdoba',
                    'Corrientes' => 'Corrientes',
                    'Entre Ríos' => 'Entre Ríos',
                    'Formosa' => 'Formosa',
                    'Jujuy' => 'Jujuy',
                    'La Pampa' => 'La Pampa',
                    'La Rioja' => 'La Rioja',
                    'Mendoza' => 'Mendoza',
                    'Misiones' => 'Misiones',
                    'Neuquén' => 'Neuquén',
                    'Río Negro' => 'Río Negro',
                    'Salta' => 'Salta',
                    'San Juan' => 'San Juan',
                    'San Luis' => 'San Luis',
                    'Santa Cruz' => 'Santa Cruz',
                    'Santa Fe' => 'Santa Fe',
                    'Santiago del Estero' => 'Santiago del Estero',
                    'Tierra del Fuego' => 'Tierra del Fuego',
                    'Tucumán' => 'Tucumán',
            ]])
            ->add('perfil', ChoiceType::class,[
                "choices"=>[
                    'perfil1'=>'perfil1',
                    'perfil2'=>'perfil2',
                    'perfil3'=>'perfil3',
                ]])
            ->add('estudios',ChoiceType::class,[
                'choices'=> [
                    'Primario'=>'Primario',
                    'Segundario'=>'Segundario',
                    'Terciario'=> 'Terciario',
                    'Universitario'=>'Universitario',
                ]])
            ->add('antecedentes',TextareaType::class)
            ->add('formacion',TextareaType::class)
            ->add('cv',FileType::class,array('label'=>"Curriculum"))
            ->add('diploma',FileType::class,array('label'=>"Diploma del Campus Virtual"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
