<?php
/**
 * Password type.
 */

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class EditPasswordType.
 *
 * Form type for editing the user password.
 */
class EditPasswordType extends AbstractType
{
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * EditPasswordType constructor.
     *
     * @param UserPasswordHasherInterface $passwordHasher The password hasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top-most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array<string, mixed> $options The form options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'password',
                PasswordType::class,
                [
                    'label' => 'label.password',
                    'required' => true,
                    'attr' => ['max_length' => 64],
                ]
            )
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $user = $event->getData();

                // Hash the password
                $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());

                // Set the hashed password
                $user->setPassword($hashedPassword);

                $event->setData($user);
            });
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'user';
    }
}
