<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\Task;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TaskVoter extends Voter
{
    const ADD = 'add';
    const EDIT = 'edit';
    const DELETE = 'delete';

    /**
     * Supports
     * @param string $attribute attribute
     * @param mixed $subject subject
     *
     * @return bool
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::ADD, self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Task) {
            return false;
        }

        return true;
    }

    /**
     * Vote on attribute
     * @param string $attribute attribute
     * @param mixed $subject subject
     * @param TokenInterface $token token
     *
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $task = $subject;

        return $attribute === self::ADD ? $this->canAdd($user) : $this->canEditOrDelete($task, $user);
    }

    /**
     * Can add
     * @param User $user user
     *
     * @return bool
     */
    private function canAdd(User $user): bool
    {
        return in_array('ROLE_USER', $user->getRoles());
    }

    /**
     * Can edit or delete
     * @param Task $task task
     * @param User $user user
     *
     * @return bool
     */
    private function canEditOrDelete(Task $task, User $user): bool
    {
        return $user === $task->getUser() || (in_array('ROLE_ADMIN', $user->getRoles()) && $task->getUser()->getUsername() === 'anonyme');
    }
}
