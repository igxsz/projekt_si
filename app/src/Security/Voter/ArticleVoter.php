<?php
/**
 * Article voter.
 */

namespace App\Security\Voter;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ArticleVoter.
 */
class ArticleVoter extends Voter
{
    /**
     * Edit permission.
     *
     * @const string
     */
    public const EDIT = 'EDIT';

    /**
     * View permission.
     *
     * @const string
     */
    public const VIEW = 'VIEW';

    /**
     * Delete permission.
     *
     * @const string
     */
    public const DELETE = 'DELETE';

    /**
     * Security helper.
     */
    private Security $security;

    /**
     * OrderVoter constructor.
     *
     * @param Security $security Security helper
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed  $subject   The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool Result
     */
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof Article;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string         $attribute Permission name
     * @param mixed          $subject   Object
     * @param TokenInterface $token     Security token
     *
     * @return bool Vote result
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }
        if ($user->getRoles() === ['ROLE_ADMIN']) {
            return true; // Użytkownik z rolą ROLE_ADMIN ma uprawnienia do zarządzania zadaniami
        }

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($subject, $user);
                //            case self::VIEW:
                //                return $this->canView($subject, $user);
            case self::DELETE:
                return $this->canDelete($subject, $user);
        }

        return false;
    }

    /**
     * Checks if user can edit .
     *
     * @return bool Result
     */
    private function canEdit(): bool
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }

    //    /**
    //     * Checks if user can view .
    //     *
    //     * @param Article $ Article entity
    //     * @param User $user User
    //     *
    //     * @return bool Result
    //     */
    //    private function canView(): bool
    //    {
    //        return $this->security->isGranted('ROLE_ADMIN');
    //    }

    /**
     * Checks if user can delete .
     *
     * @return bool Result
     */
    private function canDelete(): bool
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }
}
