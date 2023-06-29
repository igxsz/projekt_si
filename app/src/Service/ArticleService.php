<?php
/**
 * Article service.
 */

namespace App\Service;

use App\Entity\Category;
use App\Entity\Article;
use App\Entity\User;
use App\Repository\CommentRepository;
use App\Repository\ArticleRepository;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class ArticleService.
 */
class ArticleService implements ArticleServiceInterface
{
    /**
     * Article repository.
     */
    private ArticleRepository $articleRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Comment Repository.
     * @var CommentRepository
     */
    private CommentRepository $commentRepository;

    /**
     * Category service.
     *
     * @var CategoryService
     */
    private CategoryService $categoryService;

    /**
     * Constructor.
     *
     * @param PaginatorInterface $paginator         Paginator
     * @param ArticleRepository  $articleRepository Article repository
     * @param CommentRepository  $commentRepository
     * @param CategoryService    $categoryService
     */
    public function __construct(PaginatorInterface $paginator, ArticleRepository $articleRepository, CommentRepository $commentRepository, CategoryService $categoryService)
    {
        $this->commentRepository = $commentRepository;
        $this->paginator = $paginator;
        $this->articleRepository = $articleRepository;
        $this->categoryService = $categoryService;
    }

    /**
     * Get paginated list.
     *
     * @param int                $page    Page number
     * @param User|null          $author  Articles author
     * @param array<string, int> $filters Filters array
     *
     * @return PaginationInterface<SlidingPagination> Paginated list
     */
    public function getPaginatedList(int $page, User $author = null, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->articleRepository->queryAll($filters),
            $page,
            ArticleRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Get paginated list by category
     * @param int      $page
     * @param Category $category
     *
     * @return PaginationInterface
     */
    public function getPaginatedListByCategory(int $page, Category $category): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->articleRepository->findBy(
                ['category' => $category]
            ),
            $page,
            ArticleRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Article $article Article entity
     */
    public function save(Article $article): void
    {
        $this->articleRepository->save($article);
    }

    /**
     * Delete entity.
     *
     * @param Article $article Article entity
     */
    public function delete(Article $article): void
    {
        $comments = $this->commentRepository->findBy(
            ['article' => $article]
        );
        foreach ($comments as $comment) {
            $this->commentRepository->delete($comment);
        }
        $this->articleRepository->delete($article);
    }

    /**
     * Prepare filters for the articles list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['category_id'])) {
            $category = $this->categoryService->findOneById($filters['category_id']);
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        return $resultFilters;
    }
}
