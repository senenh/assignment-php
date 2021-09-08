<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LanguageRepository::class)
 */
class Language
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $ISO;

    /**
     * @ORM\Column(type="boolean")
     */
    private $LTR;

    /**
     * @ORM\OneToMany(targetEntity=KeyLanguageTranslation::class, mappedBy="language")
     */
    private $keyLanguageTranslations;

    /**
     * @ORM\OneToMany(targetEntity=Translation::class, mappedBy="language", orphanRemoval=true)
     */
    private $translations;

    public function __construct()
    {
        $this->keyLanguageTranslations = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getISO(): ?string
    {
        return $this->ISO;
    }

    public function setISO(string $ISO): self
    {
        $this->ISO = $ISO;

        return $this;
    }

    public function getLTR(): ?bool
    {
        return $this->LTR;
    }

    public function setLTR(bool $LTR): self
    {
        $this->LTR = $LTR;

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
            $keyLanguageTranslation->setLanguage($this);
        }

        return $this;
    }

    public function removeKeyLanguageTranslation(KeyLanguageTranslation $keyLanguageTranslation): self
    {
        if ($this->keyLanguageTranslations->removeElement($keyLanguageTranslation)) {
            // set the owning side to null (unless already changed)
            if ($keyLanguageTranslation->getLanguage() === $this) {
                $keyLanguageTranslation->setLanguage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Translation[]
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(Translation $translation): self
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setLanguage($this);
        }

        return $this;
    }

    public function removeTranslation(Translation $translation): self
    {
        if ($this->translations->removeElement($translation)) {
            // set the owning side to null (unless already changed)
            if ($translation->getLanguage() === $this) {
                $translation->setLanguage(null);
            }
        }

        return $this;
    }
}
