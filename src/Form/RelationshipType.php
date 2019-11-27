<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RelationshipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', TextType::class ,array('mapped' => false));
        $builder->add('relationship', TextType::class, [
                'required' => true,
                'attr'=> array(
                    'maxlength'=> 20
                )
                ]);
        $builder->add('status', ChoiceType::class, array(
            'required' => true,
            'choices' => [
                    'Enabled' => '1',
                    'Disabled' => '0'
                ],
            'label' => 'Status',
        ));
    }
}