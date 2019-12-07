<?php

namespace App\Form;

use App\Entity\Shoe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ShoeEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom'
            ])
            ->add('description', null, [
                'label' => 'Description'
            ])
            ->add('size', null, [
                'label' => 'Pointure'
            ])
            ->add('price', null, [
                'label' => 'Prix'
            ])
            ->add('side', ChoiceType::class, [
                'choices' => $this->getChoiceSide(),
                'label' => 'Coté'
            ])
            ->add('mark', null, [
                'label' => 'Marque'
            ])
            ->add('shoe_type', ChoiceType::class, [
                'choices' => $this->getChoiceType(),
                'label' => 'Type de chaussure'
            ])
            ->add('state', ChoiceType::class, [
                'choices' => $this->getChoiceState(),
                'label' => 'État de la chaussure'
            ])
            ->add('ImageFile', FileType::class, [
                'label' => 'Image (Fichier au format PNG)',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shoe::class,
        ]);
    }

    private function getChoiceState()
    {
        $choices = Shoe::CHOICES_STATE;
        $tabChoices = [];
        foreach ($choices as $key => $value){
            $tabChoices[$value] = $key;
        }
        return $tabChoices;
    }

    private function getChoiceSide()
    {
        $choices = Shoe::CHOICES_SIDE;
        $tabChoices = [];
        foreach ($choices as $key => $value){
            $tabChoices[$value] = $key;
        }
        return $tabChoices;
    }

    private function getChoiceType()
    {
        $choices = Shoe::CHOICES_TYPE;
        $tabChoices = [];
        foreach ($choices as $key => $value){
            $tabChoices[$value] = $key;
        }
        return $tabChoices;
    }
}
