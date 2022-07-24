<?php

namespace AddressBook\Form;

use AddressBook\Entity\Group;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('domainId')
            ->add('groupId')
            ->add('groupParentId')
            ->add('created')
            ->add('modified')
            ->add('deprecated')
            ->add('groupName')
            ->add('groupHeader')
            ->add('groupFooter')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
