<?php
/**
 * Comment service interface.
 */

namespace App\Service;

use App\Entity\Task;
use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface CommentServiceInterface.
 */
interface CommentServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Get paginated list by task
     * @param int  $page
     * @param Task $task
     *
     * @return PaginationInterface
     */
    public function getPaginatedListByTask(int $page, Task $task): PaginationInterface;

    /**
     * Get paginated list by user.
     * @param int  $page
     * @param User $user
     *
     * @return PaginationInterface
     */
    public function getPaginatedListByUser(int $page, User $user): PaginationInterface;
}
