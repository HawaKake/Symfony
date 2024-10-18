<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 11)]
    private ?string $telephone = null;

    #[ORM\Column(length: 100)]
    private ?string $surname = null;

    #[ORM\Column(length: 100)]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\OneToOne(mappedBy: 'Client', cascade: ['persist', 'remove'])]
    private ?User $utilisateur = null;

    /**
     * @var Collection<int, Dettes>
     */
    #[ORM\OneToMany(targetEntity: Dettes::class, mappedBy: 'client')]
    private Collection $dettes;

    /**
     * @var Collection<int, Dette>
     */
    #[ORM\OneToMany(targetEntity: Dette::class, mappedBy: 'client')]
    private Collection $List_dettes;

    public function __construct()
    {
        $this->dettes = new ArrayCollection();
        $this->List_dettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): static
    {
        // unset the owning side of the relation if necessary
        if ($utilisateur === null && $this->utilisateur !== null) {
            $this->utilisateur->setClient(null);
        }

        // set the owning side of the relation if necessary
        if ($utilisateur !== null && $utilisateur->getClient() !== $this) {
            $utilisateur->setClient($this);
        }

        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Dettes>
     */
    public function getDettes(): Collection
    {
        return $this->dettes;
    }

    public function addDette(Dettes $dette): static
    {
        if (!$this->dettes->contains($dette)) {
            $this->dettes->add($dette);
            $dette->setClient($this);
        }

        return $this;
    }

    public function removeDette(Dettes $dette): static
    {
        if ($this->dettes->removeElement($dette)) {
            // set the owning side to null (unless already changed)
            if ($dette->getClient() === $this) {
                $dette->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Dette>
     */
    public function getListDettes(): Collection
    {
        return $this->List_dettes;
    }

    public function addListDette(Dette $listDette): static
    {
        if (!$this->List_dettes->contains($listDette)) {
            $this->List_dettes->add($listDette);
            $listDette->setClient($this);
        }

        return $this;
    }

    public function removeListDette(Dette $listDette): static
    {
        if ($this->List_dettes->removeElement($listDette)) {
            // set the owning side to null (unless already changed)
            if ($listDette->getClient() === $this) {
                $listDette->setClient(null);
            }
        }

        return $this;
    }
}
