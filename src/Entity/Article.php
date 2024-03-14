<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name:'articles')]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:3, max:60)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $text = null;

    #[ORM\Column]
    #[Assert\Type(DateTimeImmutable::class)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'articles')]
    private Collection $authors;
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }
 
    /**
     * getter for Id
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

        
    /**
     * getter for Title
     *
     * @return string
     */
    
    public function getTitle(): ?string
    {
        return $this->title;
    }

        
    /**
     * setter for Title
     *
     * @param  string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

        
    /**
     * getter for Text
     *
     * @return string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

        
    /**
     * setter for Text
     *
     * @param  mixed $text
     * @return void
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

        
    /**
     * getter for CreatedAt
     *
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

        
    /**
     * setter for CreatedAt
     *
     * @param  DateTimeImmutable $createdAt
     * @return void
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }
    
    /**
     * addAuthor
     *
     * @param  Author $author
     * @return static
     */
    public function addAuthor(Author $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
        }

        return $this;
    }

        
    /**
     * removeAuthor
     *
     * @param  Author $author
     * @return static
     */
    public function removeAuthor(Author $author): static
    {
        $this->authors->removeElement($author);

        return $this;
    }
}
