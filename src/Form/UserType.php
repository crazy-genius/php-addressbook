<?php

namespace AddressBook\Form;

use AddressBook\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('domainId')
            ->add('username')
            ->add('md5Pass')
            ->add('passwordHint')
            ->add('ssoFacebookUid')
            ->add('ssoGoogleUid')
            ->add('ssoLiveUid')
            ->add('ssoYahooUid')
            ->add('lastname')
            ->add('firstname')
            ->add('email')
            ->add('phone')
            ->add('address1')
            ->add('address2')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('country')
            ->add('masterCode')
            ->add('confirmationCode')
            ->add('passResetCode')
            ->add('status')
            ->add('trials')
            ->add('created')
            ->add('modified')
            ->add('deprecated')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
