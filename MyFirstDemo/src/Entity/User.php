<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks  <-- DO NOT FORGET TO ADD THIS
 */

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?int $status = null;

    #[ORM\Column(length: 215, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(length: 12)]
    private ?string $gender = null;

    #[ORM\Column(length: 120, nullable: true)]
    private ?string $token = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $desciption = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UsersWork::class)]
    private Collection $usersWorks;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Country $country = null;

    #[ORM\ManyToMany(targetEntity: Location::class, mappedBy: 'user')]
    private Collection $locations;

    public function __construct()
    {
        $this->usersWorks = new ArrayCollection();
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getDesciption(): ?string
    {
        return $this->desciption;
    }

    public function setDesciption(?string $desciption): self
    {
        $this->desciption = $desciption;

        return $this;
    }

    /**
     * @return Collection<int, UsersWork>
     */
    public function getUsersWorks(): Collection
    {
        return $this->usersWorks;
    }

    public function addUsersWork(UsersWork $usersWork): self
    {
        if (!$this->usersWorks->contains($usersWork)) {
            $this->usersWorks->add($usersWork);
            $usersWork->setUser($this);
        }

        return $this;
    }

    public function removeUsersWork(UsersWork $usersWork): self
    {
        if ($this->usersWorks->removeElement($usersWork)) {
            // set the owning side to null (unless already changed)
            if ($usersWork->getUser() === $this) {
                $usersWork->setUser(null);
            }
        }

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
            $location->addUser($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->removeElement($location)) {
            $location->removeUser($this);
        }

        return $this;
    }

}
