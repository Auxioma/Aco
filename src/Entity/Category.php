<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[Vich\Uploadable]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Slug = null;

    #[ORM\Column(length: 255)]
    private ?string $hn = null;

    #[ORM\Column(length: 255)]
    private ?string $MetaTitre = null;

    #[ORM\Column(length: 255)]
    private ?string $MetaDescription = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName  = null;

    #[Vich\UploadableField(mapping: 'categories', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable  $updatedAt = null;

    // taille de nos images
    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null; 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

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

    public function getHn(): ?string
    {
        return $this->hn;
    }

    public function setHn(string $hn): self
    {
        $this->hn = $hn;

        return $this;
    }

    public function getMetaTitre(): ?string
    {
        return $this->MetaTitre;
    }

    public function setMetaTitre(string $MetaTitre): self
    {
        $this->MetaTitre = $MetaTitre;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->MetaDescription;
    }

    public function setMetaDescription(string $MetaDescription): self
    {
        $this->MetaDescription = $MetaDescription;

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
}
