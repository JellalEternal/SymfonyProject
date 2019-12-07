<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom :'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom :'
            ])
            ->add('phone', TextType::class, [
                'label' => 'Votre numéro de téléphone :'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse mail :'
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre adresse mail :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
