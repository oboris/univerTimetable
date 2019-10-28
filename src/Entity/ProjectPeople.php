<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="project_people")
 */
class ProjectPeople
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
    private $type;

    /**
     * @ORM\Column(type="string")
     */
    private $responsibility;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="projectPeople")
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Staff", inversedBy="projectPeople")
     */
    private $staff;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getResponsibility(): ?string
    {
        return $this->responsibility;
    }

    public function setResponsibility(string $responsibility): self
    {
        $this->responsibility = $responsibility;

        return $this;
    }

    public function getProject(): ?project
    {
        return $this->project;
    }

    public function setProject(?project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getStaff(): ?staff
    {
        return $this->staff;
    }

    public function setStaff(?staff $staff): self
    {
        $this->staff = $staff;

        return $this;
    }
}
