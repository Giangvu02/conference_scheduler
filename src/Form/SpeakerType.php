<?php

namespace App\Form;

use App\Entity\Speaker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpeakerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Họ và tên',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('topic', TextType::class, [
                'label' => 'Chủ đề diễn thuyết',
            ])
            ->add('biography', TextareaType::class, [
                'label' => 'Tiểu sử',
            ])
            ->add('photo', TextType::class, [
                'label' => 'Đường dẫn ảnh (URL)',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Speaker::class,
        ]);
    }
}