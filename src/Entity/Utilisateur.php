<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @Assert\NotBlank(message="This value cannot be empty!")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list", "detail" })
     * @Assert\NotBlank(message="This value cannot be empty!")
     */
    private $firstname;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="utilisateurs")
     * @Assert\NotBlank(message="This value cannot be empty!")
     */
    private $clientId;

    /**
     * @Serializer\Groups({"list"})
     */
    private $urlDetail;

    /**
     * @Serializer\Groups({"list"})
     */
    private $urlDelete;


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
        return $this->urlDetail;
    }

    public function setUrlDetail(?string $urlDetail): self
    {
        $this->urlDetail = $urlDetail;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrlDelete()
    {
        return $this->urlDelete;
    }

    /**
     * @param mixed $urlDelete
     */
    public function setUrlDelete($urlDelete): void
    {
        $this->urlDelete = $urlDelete;
    }
}
