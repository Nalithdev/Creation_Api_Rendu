<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use ApiPlatform\Metadata\ApiProperty;
use App\Controller\CreateMediaObjectAction;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Metadata\Get;
use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

use Symfony\Component\Validator\Constraints as Assert;


#[Vich\Uploadable]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    types: ['https://schema.org/MediaObject'],
    operations: [
        new Get(),
        new GetCollection(),
        new Delete(),
        new Post(
            controller: CreateMediaObjectAction::class,
            deserialize: false,
            validationContext: ['groups' => ['Default', 'write']],
            openapi: new Model\Operation(
                requestBody: new Model\RequestBody(
                    content: new \ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary'
                                    ]
                                ]
                            ]
                        ]
                    ])
                )
            )
        )
    ]
)]

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[Groups(['read , write'])]
    private ?string $pathfile = null;

    #[ORM\OneToOne(inversedBy: 'media', cascade: ['persist', 'remove'])]
    #[Groups(['read', 'write'])]
    private ?Boisson $boisson = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPathfile(): ?string
    {
        return $this->pathfile;
    }

    public function setPathfile(?string $pathfile): static
    {
        $this->pathfile = $pathfile;

        return $this;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): static
    {
        $this->boisson = $boisson;

        return $this;
    }

    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[Groups(['read'])]
    public ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: 'media_object', fileNameProperty: 'pathfile')]
    #[Assert\NotNull(groups: ['write'])]
    public ?File $file = null;
}
