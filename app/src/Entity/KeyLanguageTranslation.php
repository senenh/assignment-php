<?php

namespace App\Entity;

use App\Repository\KeyLanguageTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Table(name="video_settings",
 *    uniqueConstraints={
 *        @UniqueConstraint(name="video_unique",
 *            columns={"key_id", "language_id", "translation_id"})
 *    }
 * )
 * @ORM\Entity(repositoryClass=KeyLanguageTranslationRepository::class)
 */
class KeyLanguageTranslation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Key::class, inversedBy="keyLanguageTranslations")
     * @ORM\JoinColumn(name="key_id", referencedColumnName="id", nullable=false)
     */
    private $keyId;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class, inversedBy="keyLanguageTranslations")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id", nullable=false)
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity=Translation::class, inversedBy="keyLanguageTranslations")
     * @ORM\JoinColumn(name="translation_id", referencedColumnName="id", nullable=false)
     */
    private $translation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeyName(): ?Key
    {
        return $this->keyName;
    }

    public function setKeyName(?Key $keyName): self
    {
        $this->keyName = $keyName;

        return $this;
    }

    public function getKeyId(): ?Key
    {
        return $this->keyId;
    }

    public function setKeyId(?Key $keyId): self
    {
        $this->keyId = $keyId;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getTranslation(): ?Translation
    {
        return $this->translation;
    }

    public function setTranslation(?Translation $translation): self
    {
        $this->translation = $translation;

        return $this;
    }
}
