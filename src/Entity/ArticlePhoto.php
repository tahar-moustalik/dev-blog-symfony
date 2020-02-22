<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticlePhotoRepository")
 */
class ArticlePhoto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phoyo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="photos")
     */
    private $article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoyo(): ?string
    {
        return $this->phoyo;
    }

    public function setPhoyo(string $phoyo): self
    {
        $this->phoyo = $phoyo;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
