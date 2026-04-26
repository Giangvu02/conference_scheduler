<?php

namespace App\Form;

use App\Entity\Conference;
use App\Entity\Room;
use App\Entity\Session;
use App\Entity\Speaker;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('sessionDate')
            ->add('startTime')
            ->add('endTime')
            ->add('conference', EntityType::class, [
                'class' => Conference::class,
                'choice_label' => 'id',
            ])
            ->add('speaker', EntityType::class, [
                'class' => Speaker::class,
                'choice_label' => 'id',
            ])
            ->add('room', EntityType::class, [
                'class' => Room::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
