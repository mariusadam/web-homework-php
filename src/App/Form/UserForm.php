<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class UserForm
 *
 * @package App\Form
 *
 * @author  Marius Adam
 */
class UserForm extends AbstractType
{


    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', ChoiceType::class, [
                'choices'     => $this->getRoles(),
                'placeholder' => 'Select a role',
            ])
            ->add('name', TextType::class)
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('age', IntegerType::class)
            ->add('email', EmailType::class)
            ->add('webPage', UrlType::class);
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class', User::class)
            ->setDefault('crsf_field_name', '_user_random_token')
            ->setDefault('crsf_token_id', self::class)
            ->setDefault('crsf_protection', true);
    }

    private function getRoles()
    {
        return [
            'ROLE_USER'  => 'ROLE_USER',
            'ROLE_ADMIN' => 'ROLE_ADMIN',
        ];
    }

}