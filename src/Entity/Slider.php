<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Repository\SliderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: SliderRepository::class)]
#[Vich\Uploadable]
class Slider
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Titre = null;

    #[ORM\Column(length: 255)]
    private ?string $SousTitre = null;

    #[ORM\Column(length: 255)]
    private ?string $Paragraphe = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName  = null;

    #[Vich\UploadableField(mapping: 'slider', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable  $updatedAt = null;

    // taille de nos images
    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Metier $Metier = null;

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

    public function getSousTitre(): ?string
    {
        return $this->SousTitre;
    }

    public function setSousTitre(string $SousTitre): self
    {
        $this->SousTitre = $SousTitre;

        return $this;
    }

    public function getParagraphe(): ?string
    {
        return $this->Paragraphe;
    }

    public function setParagraphe(string $Paragraphe): self
    {
        $this->Paragraphe = $Paragraphe;

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

    public function getMetier(): ?Metier
    {
        return $this->Metier;
    }

    public function setMetier(?Metier $Metier): self
    {
        $this->Metier = $Metier;

        return $this;
    }
}
