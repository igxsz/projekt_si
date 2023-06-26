<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\Table(name: 'tasks')]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;
    #[ORM\ManyToOne(fetch: "EXTRA_LAZY")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
     * Author.
     *
     * @var User|null
     */
    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Type(User::class)]
    private ?User $author;

//    #[ORM\ManyToOne(fetch: "EXTRA_LAZY")]
//    #[ORM\JoinColumn(nullable: false)]
//    private ?Comment $comment = null;

//    /**
//     * @var Comment|null
//     */
//    #[ORM\Column(type: Types::TEXT, nullable: true)]
//    private ?string $comment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

//    public function getComment(): ?string
//    {
//        return $this->comment;
//    }
//
//    public function setComment(?string $comment): self
//    {
//        $this->comment = $comment;
//
//        return $this;
//    }

///**
// * @return Collection<int, Comment>
// */
//public function getComment(): Collection
//{
//    return $this->comment;
//}
//
//public function addComment(Comment $comment): self
//{
//    if (!$this->comment->contains($comment)) {
//        $this->comment->add($comment);
//        $comment->setTask($this);
//    }
//
//    return $this;
//}

public function removeComment(Comment $comment): self
{
    if ($this->comment->removeElement($comment)) {
        // set the owning side to null (unless already changed)
        if ($comment->getTask() === $this) {
            $comment->setTask(null);
        }
    }

    return $this;
}
}