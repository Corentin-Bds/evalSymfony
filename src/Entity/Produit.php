<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\OneToMany(mappedBy: 'produitCommentaire', targetEntity: Commentaire::class)]
    private Collection $produitCommentaire;

    public function __construct()
    {
        $this->produitCommentaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getProduitCommentaire(): Collection
    {
        return $this->produitCommentaire;
    }

    public function addProduitCommentaire(Commentaire $produitCommentaire): self
    {
        if (!$this->produitCommentaire->contains($produitCommentaire)) {
            $this->produitCommentaire->add($produitCommentaire);
            $produitCommentaire->setProduitCommentaire($this);
        }

        return $this;
    }

    public function removeProduitCommentaire(Commentaire $produitCommentaire): self
    {
        if ($this->produitCommentaire->removeElement($produitCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($produitCommentaire->getProduitCommentaire() === $this) {
                $produitCommentaire->setProduitCommentaire(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }
}
