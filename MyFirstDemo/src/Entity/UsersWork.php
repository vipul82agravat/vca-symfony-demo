<?php

namespace App\Entity;

use App\Repository\UsersWorkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UsersWorkRepository::class)]
class UsersWork
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    //[Assert\Length(min:7,max: 12)]
    private ?string $taskname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $startdate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enddate = null;

    #[ORM\Column(nullable: true)]
    private ?int $status = null;

    #[ORM\ManyToOne(inversedBy: 'usersWorks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaskname(): ?string
    {
        return $this->taskname;
    }

    public function setTaskname(?string $taskname): self
    {
        $this->taskname = $taskname;

        return $this;
    }

    public function getStartdate(): ?string
    {
        return $this->startdate;
    }

    public function setStartdate(?string $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate(): ?string
    {
        return $this->enddate;
    }

    public function setEnddate(?string $enddate): self
    {
        $this->enddate = $enddate;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    public function getEmail(): ?string
    {
        return true;
    }
    
}
