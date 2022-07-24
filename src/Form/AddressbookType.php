<?php

namespace AddressBook\Form;

use AddressBook\Entity\AddressBook;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressbookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('domainId')
            ->add('firstname')
            ->add('middlename')
            ->add('lastname')
            ->add('nickname')
            ->add('company')
            ->add('title')
            ->add('address')
            ->add('addrLong')
            ->add('addrLat')
            ->add('addrStatus')
            ->add('home')
            ->add('mobile')
            ->add('work')
            ->add('fax')
            ->add('email')
            ->add('email2')
            ->add('email3')
            ->add('im')
            ->add('im2')
            ->add('im3')
            ->add('homepage')
            ->add('bday')
            ->add('bmonth')
            ->add('byear')
            ->add('aday')
            ->add('amonth')
            ->add('ayear')
            ->add('address2')
            ->add('phone2')
            ->add('notes')
            ->add('photo')
            ->add('xVcard')
            ->add('xActivesync')
            ->add('created')
            ->add('modified')
            ->add('deprecated')
            ->add('password')
            ->add('login')
            ->add('role')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddressBook::class,
        ]);
    }
}
