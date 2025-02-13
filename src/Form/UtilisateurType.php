<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('login', TextType::class, [
                'constraints' => [
                    new Assert\NotNull(['message' => 'Le login ne peut pas être vide.']),
                    new Assert\NotBlank(['message' => 'Le login ne peut pas être laissé vide.']),
                    new Assert\Length([
                        'min' => 4,
                        'max' => 20,
                        'minMessage' => 'Le login doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le login ne doit pas dépasser {{ limit }} caractères.'
                    ])
                ]
            ])
            

            ->add('plainPassword', PasswordType::class, [
                'mapped' => false, 
                'constraints' => [
                    new Assert\NotNull(['message' => 'Le mot de passe ne peut pas être vide.']),
                    new Assert\NotBlank(['message' => 'Le mot de passe ne peut pas être laissé vide.']),
                    new Assert\Length([
                        'min' => 8,
                        'max' => 30,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le mot de passe ne doit pas dépasser {{ limit }} caractères.'
                    ]),
                    new Assert\Regex([
                        'pattern' => '#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\w\W]{8,30}$#',
                        'message' => 'Le mot de passe doit contenir au moins une minuscule, une majuscule et un chiffre.'
                    ])
                ]
            ])

            ->add('fichierPhotoProfil', FileType::class, [
                'mapped' => false, 
                'constraints' => [
                    new Assert\File([
                        'maxSize' => '10M',
                        'maxSizeMessage' => 'La taille maximale du fichier est de 10 Mo.',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Le format du fichier doit être JPG ou PNG.'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
