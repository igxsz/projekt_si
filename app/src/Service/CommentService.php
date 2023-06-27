<?php
/**
 * Comment service.
 */

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Task;
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
     * Paginated list by users
     * @param int  $page
     * @param Task $task
     *
     * @return PaginationInterface
     */
    public function getPaginatedListByTask(int $page, Task $task): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->commentRepository->findBy(
                ['task' => $task]
            ),
            $page,
            CommentRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Paginated list by users
     *
     * @param int  $page
     * @param User $user
     *
     * @return PaginationInterface
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
     * Getter for task.
     *
     * @param Comment $comment
     *
     * @return Task|null
     */
    public function getTask(Comment $comment): ?Task
    {
        return $comment->getTask();
    }

    /**
     * Save entity.
     *
     * @param Comment $comment Comment entity
     */
    public function save(Comment $comment): void
    {
        if (null == $comment->getId()) {
            $comment->setCreatedAt(new \DateTimeImmutable());
        }
        $this->commentRepository->save($comment);
    }

    /**
     * Delete entity.
     *
     * @param Comment $comment Task entity
     */
    public function delete(Comment $comment): void
    {
        $this->commentRepository->delete($comment);
    }
}
