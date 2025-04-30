<?php

namespace App\Entity;

use App\Repository\MembresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembresRepository::class)]
#[UniqueEntity('email', message: 'Cet email existe déja.')]
#[UniqueEntity('telephone', message: 'Le numéro de téléphone existe déja.')]
class Membres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true, unique: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true, unique: true)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'membres')]
    private ?Dahiras $dahiras = null;

    #[ORM\ManyToOne(inversedBy: 'membres')]
    private ?Encadreur $encadreur = null;

    /**
     * @var Collection<int, Presence>
     */
    #[ORM\OneToMany(targetEntity: Presence::class, mappedBy: 'membre')]
    private Collection $presences;

    /**
     * @var Collection<int, Intervenant>
     */
    #[ORM\OneToMany(targetEntity: Intervenant::class, mappedBy: 'membre')]
    private Collection $intervenants;

    #[ORM\Column(length: 255)]
    private ?string $numero = null;

    /**
     * @var Collection<int, Reunion>
     */
    #[ORM\ManyToMany(targetEntity: Reunion::class, mappedBy: 'membres')]
    private Collection $reunions;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poste = null;

    #[ORM\ManyToOne(inversedBy: 'membres')]
    private ?Specialites $specialite = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isnew = null;

    public function __construct()
    {
        $this->presences = new ArrayCollection();
        $this->intervenants = new ArrayCollection();
        $this->reunions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getDahiras(): ?Dahiras
    {
        return $this->dahiras;
    }

    public function setDahiras(?Dahiras $dahiras): static
    {
        $this->dahiras = $dahiras;
        return $this;
    }

    public function getEncadreur(): ?Encadreur
    {
        return $this->encadreur;
    }

    public function setEncadreur(?Encadreur $encadreur): static
    {
        $this->encadreur = $encadreur;
        return $this;
    }

    /**
     * @return Collection<int, Presence>
     */
    public function getPresences(): Collection
    {
        return $this->presences;
    }

    public function addPresence(Presence $presence): static
    {
        if (!$this->presences->contains($presence)) {
            $this->presences->add($presence);
            $presence->setMembre($this);
        }
        return $this;
    }

    public function removePresence(Presence $presence): static
    {
        if ($this->presences->removeElement($presence)) {
            // set the owning side to null (unless already changed)
            if ($presence->getMembre() === $this) {
                $presence->setMembre(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Intervenant>
     */
    public function getIntervenants(): Collection
    {
        return $this->intervenants;
    }

    public function addIntervenant(Intervenant $intervenant): static
    {
        if (!$this->intervenants->contains($intervenant)) {
            $this->intervenants->add($intervenant);
            $intervenant->setMembre($this);
        }
        return $this;
    }

    public function removeIntervenant(Intervenant $intervenant): static
    {
        if ($this->intervenants->removeElement($intervenant)) {
            // set the owning side to null (unless already changed)
            if ($intervenant->getMembre() === $this) {
                $intervenant->setMembre(null);
            }
        }
        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * @return Collection<int, Reunion>
     */
    public function getReunions(): Collection
    {
        return $this->reunions;
    }

    public function addReunion(Reunion $reunion): static
    {
        if (!$this->reunions->contains($reunion)) {
            $this->reunions->add($reunion);
            $reunion->addMembre($this);
        }
        return $this;
    }

    public function removeReunion(Reunion $reunion): static
    {
        if ($this->reunions->removeElement($reunion)) {
            $reunion->removeMembre($this);
        }
        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(?string $poste): static
    {
        $this->poste = $poste;
        return $this;
    }

    public function getSpecialite(): ?Specialites
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialites $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function isnew(): ?bool
    {
        return $this->isnew;
    }

    public function setIsnew(?bool $isnew): static
    {
        $this->isnew = $isnew;

        return $this;
    }
}
