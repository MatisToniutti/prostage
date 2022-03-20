<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     */
    private $activite;

    /**
     * @ORM\Column(type="string", length=150)
     
     * @Assert\Regex(pattern="#^[1-9][0-9]{0,2}( bis|bis)?#",message="Le numéro de rue semble incorrect")
     * @Assert\Regex(pattern="#rue|boulevard|avenue|impasse|allée|place|voie#i",message="Le type de route/voie semble incorrect")
     * @Assert\Regex(pattern="# [0-9]{5} #",message="Il semble y avoir un problème avec le code postal")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=50)
     * 
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "Your first name must be at least {{ limit }} characters long",
     *    maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\Url
     * 
     */
    private $URLSite;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="entreprise")
     */
    private $stages;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getURLSite(): ?string
    {
        return $this->URLSite;
    }

    public function setURLSite(string $URLSite): self
    {
        $this->URLSite = $URLSite;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }

        return $this;
    }
}
