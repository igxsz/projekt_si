<?php
/**
 * Comment fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Task;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


/**
 * Class CommentFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class CommentFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(20, 'comments', function (int $i) {
            $comment = new Comment();
            $comment->setContent($this->faker->sentence);

//            $task = $this->getRandomReference('tasks');
//            $comment->setTask($task);

            return $comment;
        });

        $this->manager->flush();
    }

    public function getDependecies(): array
    {
        return [TaskFixtures::class];
    }
}
