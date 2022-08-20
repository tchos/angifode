<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity (fields = "username", message="Il existe déjà un autre utilisateur avec ce nom.")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(min = 6, minMessage = "Votre mot de passe doit avoir au minimum '{{ limit }}' caractères")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastVisitDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registrationDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * CallBack appelé à chaque fois que l'on veut enregistrer un user pour
     * prendre automatiquement sa date de création du compte .
     *
     * @ORM\PrePersist
     *
     * @return void
     */
    public function PrePersist()
    {
        if (empty($this->registrationDate)) {
            $this->registrationDate = new \DateTimeImmutable();
        }

        $this->lastVisitDate = new \DateTime();
    }

    /**
     * CallBack appelé à chaque fois que l'on veut mettre à jour un user pour
     * prendre automatiquement sa date de dernière visite du compte .
     *
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function  PreUpdate()
    {
        $this->lastVisitDate = new \DateTime();
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getActivation(): ?bool
    {
        return $this->activation;
    }

    public function setActivation(bool $activation): self
    {
        $this->activation = $activation;

        return $this;
    }

    public function getLastVisitDate(): ?\DateTimeInterface
    {
        return $this->lastVisitDate;
    }

    public function setLastVisitDate(?\DateTimeInterface $lastVisitDate): self
    {
        $this->lastVisitDate = $lastVisitDate;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }
}
