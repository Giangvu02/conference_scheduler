<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            
            // 1. Sửa trường roles thành Checkbox để chứa được mảng (Array)
            ->add('roles', ChoiceType::class, [
                'label' => 'Quyền hạn',
                'choices' => [
                    'Người dùng (User)' => 'ROLE_USER',
                    'Quản trị viên (Admin)' => 'ROLE_ADMIN',
                ],
                'multiple' => true, // Bắt buộc phải là true vì roles là dạng mảng []
                'expanded' => true, // true: hiển thị Checkbox. false: hiển thị Select box
            ])
            
            // 2. Sửa trường password thành PasswordType để ẩn ký tự
            ->add('password', PasswordType::class, [
                'label' => 'Mật khẩu',
                'mapped' => false, // Không tự động map vào entity (để Controller tự mã hóa)
                'required' => false, // Không bắt buộc nhập (rất tiện khi ở trang Edit, không nhập thì giữ nguyên pass cũ)
                'attr' => ['autocomplete' => 'new-password'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}