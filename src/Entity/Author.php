<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
#[ORM\Table(name:'authors')]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Article::class, mappedBy: 'authors')]
    private Collection $articles;
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
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
     * getter for Name
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    
    /**
     * seteter for Name
     *
     * @param  string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }
    
    /**
     * add Article
     *
     * @param  Article $article
     * @return static
     */
    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->addAuthor($this);
        }

        return $this;
    }
    
    /**
     * remove Article
     *
     * @param  Article $article
     * @return static
     */
    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            $article->removeAuthor($this);
        }

        return $this;
    }
}
