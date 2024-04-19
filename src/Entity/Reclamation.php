<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */

class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat;
    
    #[Assert\NotBlank(message: "vous devez mettre le type!!!")]
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="text", length=65535, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_reclation", type="integer", nullable=false)
     */
    private $nombreReclation;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @ORM\OneToMany(targetEntity="Reponsee", mappedBy="reclamation")
     */
    private $reponses;
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    
    #[Gedmo\Timestampable(on: "create")]
    private ?\DateTimeInterface $dateajout = null;
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]

    #[Gedmo\Timestampable(on: "update")]
    private ?\DateTimeInterface $datemodif = null;

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    private ?User $User = null;

    #[ORM\OneToMany(mappedBy: 'Reclamation', targetEntity: Reponse::class)]
   
    public function __construct()
    {
        $this->reponses = new ArrayCollection();
        $this->reponse = new ArrayCollection();
    }

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNombreReclation(): ?int
    {
        return $this->nombreReclation;
    }

    public function setNombreReclation(int $nombreReclation): self
    {
        $this->nombreReclation = $nombreReclation;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection|Reponsee[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponsee $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setReclamation($this);
        }

        return $this;
    }

    public function removeReponse(Reponsee $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getReclamation() === $this) {
                $reponse->setReclamation(null);
            }
        }

        return $this;
    }
}
