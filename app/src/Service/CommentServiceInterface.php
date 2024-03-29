<?php
/**
 * Comment service interface.
 */

namespace App\Service;

use App\Entity\Article;
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
     * Get paginated list by article.
     *
     * @param int     $page    Page
     * @param Article $article Article
     *
     * @return PaginationInterface Paginator interface
     */
    public function getPaginatedListByArticle(int $page, Article $article): PaginationInterface;

    /**
     * Get paginated list by user.
     *
     * @param int  $page Page
     * @param User $user User
     *
     * @return PaginationInterface Paginator interface
     */
    public function getPaginatedListByUser(int $page, User $user): PaginationInterface;
}
