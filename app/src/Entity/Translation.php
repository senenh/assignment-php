<?php

namespace App\Entity;

use App\Repository\TranslationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TranslationRepository::class)
 */
class Translation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\OneToMany(targetEntity=KeyLanguageTranslation::class, mappedBy="translation", orphanRemoval=true)
     */
    private $keyLanguageTranslations;

    public function __construct()
    {
        $this->keyLanguageTranslations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection|KeyLanguageTranslation[]
     */
    public function getKeyLanguageTranslations(): Collection
    {
        return $this->keyLanguageTranslations;
    }

    public function addKeyLanguageTranslation(KeyLanguageTranslation $keyLanguageTranslation): self
    {
        if (!$this->keyLanguageTranslations->contains($keyLanguageTranslation)) {
            $this->keyLanguageTranslations[] = $keyLanguageTranslation;
            $keyLanguageTranslation->setTranslation($this);
        }

        return $this;
    }

    public function removeKeyLanguageTranslation(KeyLanguageTranslation $keyLanguageTranslation): self
    {
        if ($this->keyLanguageTranslations->removeElement($keyLanguageTranslation)) {
            // set the owning side to null (unless already changed)
            if ($keyLanguageTranslation->getTranslation() === $this) {
                $keyLanguageTranslation->setTranslation(null);
            }
        }

        return $this;
    }
}
