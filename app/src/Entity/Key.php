<?php

namespace App\Entity;

use App\Repository\KeyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Serializer;


/**
 * @ORM\Entity(repositoryClass=KeyRepository::class)
 * @ORM\Table(name="`key`" )
 * @UniqueEntity("name")
 */
class Key
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Type("string")
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"key"})
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=KeyLanguageTranslation::class, mappedBy="keyId", orphanRemoval=true)
     */
    private $language;

    /**
     * @ORM\OneToMany(targetEntity=KeyLanguageTranslation::class, mappedBy="keyId", orphanRemoval=true)
     */
    private $keyLanguageTranslations;

    /**
     * @ORM\OneToMany(targetEntity=Translation::class, mappedBy="keyId", orphanRemoval=true)
     */
    private $translations;

    public function __construct()
    {
        $this->language = new ArrayCollection();
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

    /**
     * @return Collection|KeyLanguageTranslation[]
     */
    public function getLanguage(): Collection
    {
        return $this->language;
    }

    public function addLanguage(KeyLanguageTranslation $language): self
    {
        if (!$this->language->contains($language)) {
            $this->language[] = $language;
            $language->setKeyName($this);
        }

        return $this;
    }

    public function removeLanguage(KeyLanguageTranslation $language): self
    {
        if ($this->language->removeElement($language)) {
            // set the owning side to null (unless already changed)
            if ($language->getKeyName() === $this) {
                $language->setKeyName(null);
            }
        }

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
            $keyLanguageTranslation->setKeyId($this);
        }

        return $this;
    }

    public function removeKeyLanguageTranslation(KeyLanguageTranslation $keyLanguageTranslation): self
    {
        if ($this->keyLanguageTranslations->removeElement($keyLanguageTranslation)) {
            // set the owning side to null (unless already changed)
            if ($keyLanguageTranslation->getKeyId() === $this) {
                $keyLanguageTranslation->setKeyId(null);
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
            $translation->setKeyId($this);
        }

        return $this;
    }

    public function removeTranslation(Translation $translation): self
    {
        if ($this->translations->removeElement($translation)) {
            // set the owning side to null (unless already changed)
            if ($translation->getKeyId() === $this) {
                $translation->setKeyId(null);
            }
        }

        return $this;
    }
}
