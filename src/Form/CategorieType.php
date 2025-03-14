<?php
// src/Form/CategorieType.php
namespace App\Form;

use App\Entity\Categorie;
use App\Enum\CategoryStatusEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nomCategorie', TextType::class, [
            'attr' => [
                'class' => 'w-full px-4 py-2 border border-black-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500',
                'required' => true,
                'id' => 'categoryName'
            ]
        ])
        ->add('description', TextareaType::class, [
            'attr' => [
                'class' => 'w-full px-4 py-2 border border-black-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500',
                'rows' => 3,
                'id' => 'categoryDescription',
            ],
            'required' => true,  // Vous pouvez choisir de le rendre obligatoire ou non
        ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Actif' => CategoryStatusEnum::Actif->value,
                    'Inactif' => CategoryStatusEnum::Inactif->value,
                ],
                'expanded' => false,  // Cela génère un <select> au lieu de boutons radio
                'multiple' => false,
                'attr' => [
                    'class' => 'w-full px-4 py-2 border border-black-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500',
                    'id' => 'categoryStatus'
                ]
                ]);
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
