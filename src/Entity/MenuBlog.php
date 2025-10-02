<?php

namespace App\Entity;

use App\Repository\MenuBlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuBlogRepository::class)]
class MenuBlog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: ArticleBlog::class)]
    private Collection $articleBlogs;

    public function __construct()
    {
        $this->articleBlogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, ArticleBlog>
     */
    public function getArticleBlogs(): Collection
    {
        return $this->articleBlogs;
    }

    public function addArticleBlog(ArticleBlog $articleBlog): static
    {
        if (!$this->articleBlogs->contains($articleBlog)) {
            $this->articleBlogs->add($articleBlog);
            $articleBlog->setMenu($this);
        }

        return $this;
    }

    public function removeArticleBlog(ArticleBlog $articleBlog): static
    {
        if ($this->articleBlogs->removeElement($articleBlog)) {
            // set the owning side to null (unless already changed)
            if ($articleBlog->getMenu() === $this) {
                $articleBlog->setMenu(null);
            }
        }

        return $this;
    }
}
