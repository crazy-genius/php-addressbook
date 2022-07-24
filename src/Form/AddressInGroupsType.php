<?php

namespace AddressBook\Form;

use AddressBook\Entity\AddressInGroups;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressInGroupsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('groupId')
            ->add('domainId')
            ->add('created')
            ->add('modified')
            ->add('deprecated')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddressInGroups::class,
        ]);
    }
}
