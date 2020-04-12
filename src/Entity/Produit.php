<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list", "detail" })
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Serializer\Groups({"list", "detail" })
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255 ,  nullable=true)
     * @Serializer\Groups({"list"})
     */
    private $urlDetail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getUrlDetail(): ?string
    {
        return $this->urlDetail;
    }

    public function setUrlDetail(?string $urlDetail): self
    {
        $this->urlDetail = $urlDetail;

        return $this;
    }
}
