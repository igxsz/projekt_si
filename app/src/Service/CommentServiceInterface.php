<?php
/**
 * Comment service interface.
 */

namespace App\Service;

use App\Entity\Task;
use App\Entity\Comment;
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
    public function getPaginatedListByTask(int $page, Task $task): PaginationInterface;
    public function getPaginatedListByUser(int $page, User $user): PaginationInterface;

}