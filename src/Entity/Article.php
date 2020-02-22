<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoPrincinpal;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArticlePhoto", mappedBy="article", cascade={"persist"})
     */
    private $photos;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhotoPrincinpal(): ?string
    {
        return $this->photoPrincinpal;
    }

    public function setPhotoPrincinpal(string $photoPrincinpal): self
    {
        $this->photoPrincinpal = $photoPrincinpal;

        return $this;
    }

    /**
     * @return Collection|ArticlePhoto[]
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    public function addPhoto(ArticlePhoto $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setArticle($this);
        }

        return $this;
    }

    public function removePhoto(ArticlePhoto $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getArticle() === $this) {
                $photo->setArticle(null);
            }
        }

        return $this;
    }


}
