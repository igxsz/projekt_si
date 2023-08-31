<?php
/**
 * Comment service.
 */

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Article;
use App\Entity\User;
use App\Repository\CommentRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class CommentService.
 */
class CommentService implements CommentServiceInterface
{
    /**
     * Comment repository.
     */
    private CommentRepository $commentRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param CommentRepository  $commentRepository Comment repository
     * @param PaginatorInterface $paginator         Paginator
     */
    public function __construct(CommentRepository $commentRepository, PaginatorInterface $paginator)
    {
        $this->commentRepository = $commentRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->commentRepository->QueryAll(),
            $page,
            CommentRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Paginated list by users.
     *
     * @param int     $page    Page
     * @param Article $article Article
     *
     * @return PaginationInterface Paginator interface
     */
    public function getPaginatedListByArticle(int $page, Article $article): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->commentRepository->findBy(
                ['article' => $article]
            ),
            $page,
            CommentRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Paginated list by users.
     *
     * @param int  $page Page
     * @param User $user User
     *
     * @return PaginationInterface Paginator interface
     */
    public function getPaginatedListByUser(int $page, User $user): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->commentRepository->findBy(
                ['User' => $user]
            ),
            $page,
            CommentRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Getter for article.
     *
     * @param Comment $comment Comment
     *
     * @return Article Article
     */
    public function getArticle(Comment $comment): ?Article
    {
        return $comment->getArticle();
    }

    /**
     * Save entity.
     *
     * @param Comment $comment Comment entity
     */
    public function save(Comment $comment): void
    {
        if (null === $comment->getId()) {
            $comment->setCreatedAt(new \DateTimeImmutable());
        }
        $this->commentRepository->save($comment);
    }

    /**
     * Delete entity.
     *
     * @param Comment $comment Article entity
     */
    public function delete(Comment $comment): void
    {
        $this->commentRepository->delete($comment);
    }
}
