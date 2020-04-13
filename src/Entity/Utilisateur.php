<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur
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
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list", "detail" })
     */
    private $firstname;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="utilisateurs")
     */
    private $clientId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"list"})
     */
    private $url_detail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getClientId(): ?User
    {
        return $this->clientId;
    }

    public function setClientId(?User $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function getUrlDetail(): ?string
    {
        return $this->url_detail;
    }

    public function setUrlDetail(?string $url_detail): self
    {
        $this->url_detail = $url_detail;

        return $this;
    }
}
