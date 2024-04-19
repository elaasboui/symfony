<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponsee
 *
 * @ORM\Table(name="reponsee", indexes={@ORM\Index(name="id_reclamation", columns={"id_reclamation"})})
 * @ORM\Entity
 */
class Reponsee
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    #[Assert\NotBlank(message: "vous devez mettre la description!!!")]
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var \Reclamation
     *
     * @ORM\ManyToOne(targetEntity="Reclamation", inversedBy="reponses")
     * @ORM\JoinColumn(name="id_reclamation", referencedColumnName="id")
     */
    private $reclamation;




    public function getId(): ?int
    {
        return $this->id;
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

    public function getCodeReclamation(): ?string
    {
        return $this->codeReclamation;
    }

    public function setCodeReclamation(string $codeReclamation): self
    {
        $this->codeReclamation = $codeReclamation;

        return $this;
    }

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(?Reclamation $reclamation): self
    {
        $this->reclamation = $reclamation;

        return $this;
    }
}
