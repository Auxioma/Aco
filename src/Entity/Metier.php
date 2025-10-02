<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MetierRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: MetierRepository::class)]
#[Vich\Uploadable]
class Metier
{
    public function __toString()
    {
        return $this->Titre;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Titre = null;

    #[ORM\Column(length: 255)]
    private ?string $Slug = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName  = null;

    #[Vich\UploadableField(mapping: 'metier', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable  $updatedAt = null;

    // taille de nos images
    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\OneToMany(mappedBy: 'Metier', targetEntity: Services::class)]
    private Collection $services;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $ShortDescription = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $LongDescription = null;

    #[ORM\Column(length: 255)]
    private ?string $h1 = null;

    #[ORM\Column(length: 255)]
    private ?string $h2 = null;

    #[ORM\Column(length: 255)]
    private ?string $h3 = null;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->Slug;
    }

    public function setSlug(string $Slug): self
    {
        $this->Slug = $Slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * @return Collection<int, Services>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Services $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setMetier($this);
        }

        return $this;
    }

    public function removeService(Services $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getMetier() === $this) {
                $service->setMetier(null);
            }
        }

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->ShortDescription;
    }

    public function setShortDescription(string $ShortDescription): self
    {
        $this->ShortDescription = $ShortDescription;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->LongDescription;
    }

    public function setLongDescription(string $LongDescription): self
    {
        $this->LongDescription = $LongDescription;

        return $this;
    }

    public function getH1(): ?string
    {
        return $this->h1;
    }

    public function setH1(string $h1): self
    {
        $this->h1 = $h1;

        return $this;
    }

    public function getH2(): ?string
    {
        return $this->h2;
    }

    public function setH2(string $h2): self
    {
        $this->h2 = $h2;

        return $this;
    }

    public function getH3(): ?string
    {
        return $this->h3;
    }

    public function setH3(string $h3): self
    {
        $this->h3 = $h3;

        return $this;
    }


}
