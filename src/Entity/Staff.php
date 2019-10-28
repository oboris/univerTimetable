<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="staff")
 */
class Staff
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $fullName;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $skills;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Department", mappedBy="staffs")
     */
    private $departments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProjectPeople", mappedBy="staff")
     */
    private $projectPeople;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
        $this->projectPeople = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSkills(): ?string
    {
        return $this->skills;
    }

    public function setSkills(?string $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return Collection|Department[]
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): self
    {
        if (!$this->departments->contains($department)) {
            $this->departments[] = $department;
            $department->addStaff($this);
        }

        return $this;
    }

    public function removeDepartment(Department $department): self
    {
        if ($this->departments->contains($department)) {
            $this->departments->removeElement($department);
            $department->removeStaff($this);
        }

        return $this;
    }

    /**
     * @return Collection|ProjectPeople[]
     */
    public function getProjectPeople(): Collection
    {
        return $this->projectPeople;
    }

    public function addProjectPerson(ProjectPeople $projectPerson): self
    {
        if (!$this->projectPeople->contains($projectPerson)) {
            $this->projectPeople[] = $projectPerson;
            $projectPerson->setStaff($this);
        }

        return $this;
    }

    public function removeProjectPerson(ProjectPeople $projectPerson): self
    {
        if ($this->projectPeople->contains($projectPerson)) {
            $this->projectPeople->removeElement($projectPerson);
            // set the owning side to null (unless already changed)
            if ($projectPerson->getStaff() === $this) {
                $projectPerson->setStaff(null);
            }
        }

        return $this;
    }
}
