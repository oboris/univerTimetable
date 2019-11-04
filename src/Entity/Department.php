<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="department")
 */
class Department
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
    private $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Staff", cascade={"persist", "remove"})
     */
    private $teamLead;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Staff", inversedBy="departments")
     */
    private $staffs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="departments")
     */
    private $company;

    public function __construct()
    {
        $this->staffs = new ArrayCollection();
    }

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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTeamLead(): ?staff
    {
        return $this->teamLead;
    }

    public function setTeamLead(?staff $teamLead): self
    {
        $this->teamLead = $teamLead;

        return $this;
    }

    /**
     * @return Collection|staff[]
     */
    public function getStaffs(): Collection
    {
        return $this->staffs;
    }

    public function addStaff(staff $staff): self
    {
        if (!$this->staffs->contains($staff)) {
            $this->staffs[] = $staff;
        }

        return $this;
    }

    public function removeStaff(staff $staff): self
    {
        if ($this->staffs->contains($staff)) {
            $this->staffs->removeElement($staff);
        }

        return $this;
    }

    public function getCompany(): ?company
    {
        return $this->company;
    }

    public function setCompany(?company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->title;
    }
}
