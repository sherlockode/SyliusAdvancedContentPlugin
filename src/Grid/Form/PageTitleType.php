<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Grid\Form;

use Sylius\Component\Grid\Filter\StringFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageTitleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'sylius.ui.title',
                'choices' => [
                    'sylius.ui.contains' => StringFilter::TYPE_CONTAINS,
                    'sylius.ui.not_contains' => StringFilter::TYPE_NOT_CONTAINS,
                    'sylius.ui.equal' => StringFilter::TYPE_EQUAL,
                    'sylius.ui.not_equal' => StringFilter::TYPE_NOT_EQUAL,
                    'sylius.ui.empty' => StringFilter::TYPE_EMPTY,
                    'sylius.ui.not_empty' => StringFilter::TYPE_NOT_EMPTY,
                    'sylius.ui.starts_with' => StringFilter::TYPE_STARTS_WITH,
                    'sylius.ui.ends_with' => StringFilter::TYPE_ENDS_WITH,
                ],
            ])
            ->add('value', TextType::class, [
                'required' => false,
                'label' => 'sylius.ui.value',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => null,
            ])
            ->setDefined('type')
            ->setAllowedValues('type', [
                StringFilter::TYPE_CONTAINS,
                StringFilter::TYPE_NOT_CONTAINS,
                StringFilter::TYPE_EQUAL,
                StringFilter::TYPE_NOT_EQUAL,
                StringFilter::TYPE_EMPTY,
                StringFilter::TYPE_NOT_EMPTY,
                StringFilter::TYPE_STARTS_WITH,
                StringFilter::TYPE_ENDS_WITH,
                StringFilter::TYPE_IN,
                StringFilter::TYPE_NOT_IN,
            ])
        ;
    }
}
