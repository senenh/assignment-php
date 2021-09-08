<?php

namespace App\Entity;

use App\Repository\KeyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KeyRepository::class)
 * @ORM\Table(name="`key`")
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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=KeyLanguageTranslation::class, mappedBy="keyName", orphanRemoval=true)
     */
    private $language;

    /**
     * @ORM\OneToMany(targetEntity=KeyLanguageTranslation::class, mappedBy="keyId", orphanRemoval=true)
     */
    private $keyLanguageTranslations;

    public function __construct()
    {
        $this->language = new ArrayCollection();
        $this->keyLanguageTranslations = new ArrayCollection();
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
}
