<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="project")
 */
class Project
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\company", inversedBy="projects")
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProjectPeople", mappedBy="project")
     */
    private $projectPeople;

    public function __construct()
    {
        $this->projectPeople = new ArrayCollection();
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

    public function getCompany(): ?company
    {
        return $this->company;
    }

    public function setCompany(?company $company): self
    {
        $this->company = $company;

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
            $projectPerson->setProject($this);
        }

        return $this;
    }

    public function removeProjectPerson(ProjectPeople $projectPerson): self
    {
        if ($this->projectPeople->contains($projectPerson)) {
            $this->projectPeople->removeElement($projectPerson);
            // set the owning side to null (unless already changed)
            if ($projectPerson->getProject() === $this) {
                $projectPerson->setProject(null);
            }
        }

        return $this;
    }
}
