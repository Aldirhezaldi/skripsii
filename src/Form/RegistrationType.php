<?php

namespace App\Form;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType 
{
    /**
     * 
     * @var array
     */
    private $configs;
    
    /**
     * 
     * @var PasswordHasherFactoryInterface
     */
    private $passwordHasherFactory;
    
    // /**
    //  * 
    //  * @var ExternalUserRepository
    //  */
    // private $externalUserRepository;
    
    public function __construct(PasswordHasherFactoryInterface $passwordHasherFactory, ParameterBagInterface $bag) 
    {
        $this->passwordHasherFactory = $passwordHasherFactory;
        $this->configs = $bag->get('user');
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'username :',
                'attr' => array(
                    'placeholder' => 'Username'
                )
            ])
            ->add('password', PasswordType::class, [
                'label' => 'password :',
                'attr' => array(
                    'placeholder' => 'Password'
                )
            ]);
        
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            
            // $data->setEmail(trim($data->getEmail()));
            // $other = $this->externalUserRepository->findOneBy([
            //     "username" => $data->getEmail(),
            //     "is_active" => true
            // ]);
            // if ($other) {
            //     $event->getForm()
            //             ->get('email')
            //             ->addError(new FormError(sprintf('email "%s" already used', $data->getUsername())));
            //     return;
            // }
            $passwordHasher = $this->passwordHasherFactory->getPasswordHasher($data);
            $password = $passwordHasher->hash(trim($data->getPassword()));

            $data->setPassword($password);
            $data->setIsActive(true);
            
            $event->setData($data);
        });
    }

    // public function configureOptions(OptionsResolver $resolver)
    // {
    //     $resolver->setDefaults([
    //         'data_class' => KmjUserInterface::class,
    //     ]);
    // }
}