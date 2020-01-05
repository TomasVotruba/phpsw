<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonDtoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('type', ChoiceType::class, [
                'choices' => Person::USER_TYPES,
                'choice_label' => function ($choice, $key, $value) {
                    return ucfirst($value);
                },
            ])
            ->add('photoUrl', TextType::class, [
                'required' => false,
            ])
            ->add('description', TextType::class, [
                'required' => false,
            ])
            ->add('fullDescription', TextType::class, [
                'required' => false,
            ])
            ->add('twitterHandle', TextType::class, [
                'required' => false,
            ])
            ->add('githubHandle', TextType::class, [
                'required' => false,
            ])
            ->add('websiteUrl', TextType::class, [
                'required' => false,
            ])
            ->add('meetupId', TextType::class, [
                'required' => false,
            ])
            ->add('email', TextType::class, [
                'required' => false,
            ])
            ->add('mobileNumber', TextType::class, [
                'required' => false,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PersonDto::class,
        ]);
    }
}
