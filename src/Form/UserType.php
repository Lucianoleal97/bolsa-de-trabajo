<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $entity = $builder->getData();

        $rolesChoices = [];
        $roles = $this->entityManager->getRepository(Role::class)->findAll();
        foreach ($roles as $rol) {
            $rolesChoices[$rol->__toString()] = $rol->getId();
        }
        $rolesIds = [];
        foreach ($entity->getRolesObjects() as $role) {
            $rolesIds[] = $role->getId();
        }
        $builder
            ->add('dni',NumberType::class)
            ->add('apellido',TextType::class)
            ->add('nombre',TextType::class)
            ->add('email',EmailType::class)
//            ->add('roles_in_form', ChoiceType::class, [
//                'mapped' => false,
//                'expanded' => true,
//                'multiple' => true,
//                'choices' => $rolesChoices,
//                'data' => $rolesIds,
//            ])
            ->add('password', PasswordType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
