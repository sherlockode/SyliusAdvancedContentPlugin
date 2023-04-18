<?php

namespace Sherlockode\SyliusAdvancedContentPlugin\Grid\Form;

use Sherlockode\AdvancedContentBundle\Model\PageInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageStatusType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'label' => 'sylius.ui.status',
                'choices' => [
                    'page.form.statuses.draft' => PageInterface::STATUS_DRAFT,
                    'page.form.statuses.published' => PageInterface::STATUS_PUBLISHED,
                    'page.form.statuses.trash' => PageInterface::STATUS_TRASH,
                ],
                'placeholder' => 'sylius.ui.all',
                'choice_translation_domain' => 'AdvancedContentBundle',
            ])
        ;
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
