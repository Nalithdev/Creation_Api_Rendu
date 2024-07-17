<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    forceEager: false,
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],

)]
#[Get()]
#[GetCollection()]
#[Patch()]
#[Delete()]
#[Post(security: "is_granted('ROLE_BARMAN')")]
class Boisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read')]
    private ?int $id = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column]
    private ?float $price = null;

    /**
     * @var Collection<int, Commande>
     */
    #[Groups('read')]
    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'list_boisson')]
    private Collection $commandes;

    #[ORM\OneToOne(mappedBy: 'boisson', cascade: ['persist', 'remove'])]
    #[Groups('read, write')]
    private ?Media $media = null;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->addListBoisson($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeListBoisson($this);
        }

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): static
    {
        // unset the owning side of the relation if necessary
        if ($media === null && $this->media !== null) {
            $this->media->setBoisson(null);
        }

        // set the owning side of the relation if necessary
        if ($media !== null && $media->getBoisson() !== $this) {
            $media->setBoisson($this);
        }

        $this->media = $media;

        return $this;
    }
}
