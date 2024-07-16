<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\User;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $TableNumber = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $CreatedDate = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?User $serveur = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?User $barman = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $status = null;

    /**
     * @var Collection<int, Boisson>
     */
    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'commandes')]
    private Collection $list_boisson;

    public function __construct()
    {
        $this->list_boisson = new ArrayCollection();
        $this -> CreatedDate = new \DateTime();
        $this -> status = "En cours de préparation";
        $this -> barman = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTableNumber(): ?int
    {
        return $this->TableNumber;
    }

    public function setTableNumber(int $TableNumber): static
    {
        $this->TableNumber = $TableNumber;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->CreatedDate;
    }

    public function setCreatedDate(\DateTimeInterface $CreatedDate): static
    {
        $this->CreatedDate = $CreatedDate;

        return $this;
    }

    public function getServeur(): ?User
    {
        return $this->serveur;
    }

    public function setServeur(?User $serveur): static
    {
        $this->serveur = $serveur;

        return $this;
    }

    public function getBarman(): ?User
    {
        return $this->barman;
    }

    public function setBarman(?User $barman): static
    {
        $this->barman = $barman;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }




    /**
     * @return Collection<int, Boisson>
     */
    public function getListBoisson(): Collection
    {
        return $this->list_boisson;
    }

    public function addListBoisson(Boisson $listBoisson): static
    {
        if (!$this->list_boisson->contains($listBoisson)) {
            $this->list_boisson->add($listBoisson);
        }

        return $this;
    }

    public function removeListBoisson(Boisson $listBoisson): static
    {
        $this->list_boisson->removeElement($listBoisson);

        return $this;
    }
}
