<?php

namespace App\Form;

use App\Entity\FullChild;
use App\Entity\Rdv;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;

class RdvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];

        if ($user instanceof UserInterface) {
            $builder
            ->add('id_child', EntityType::class, [
                'class' => FullChild::class,
                'choice_label' => 'prenom',
                'label' => 'Votre enfant',
                'placeholder' => 'Sélectionner un enfant', 
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('c')
                ->andWhere('c.user = :user')
                ->andWhere('c.status = :status') 
                ->setParameter('user', $user)
                ->setParameter('status', 'new'); 
        }
            ])
                ->add('date', null, [
                    'widget' => 'single_text',
                    'label' => 'Date'
                ])  
                 ->add('heure_debut', null, [
                    'widget' => 'single_text',
                    'label' => 'Heure de début'
                ])
                 ->add('heure_fin', null, [
                    'widget' => 'single_text',
                    'label' => 'Heure de fin'
                ]);
             
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rdv::class,
            $resolver->setRequired('user'),
        ]);
    }
}
