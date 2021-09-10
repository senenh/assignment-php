<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class KeyLanguageTranslationDTO
{
    /**
     * @Assert\Type(type="string")
     * @Assert\NotNull
     * @Assert\NotBlank()
     */
    private $key;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotNull
     * @Assert\NotBlank()
     * @Assert\Length(3)
     */
    private $iso;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotNull
     * @Assert\NotBlank()
     */
    private $text;

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     * @return KeyLanguageTranslationDTO
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * @param mixed $iso
     * @return KeyLanguageTranslationDTO
     */
    public function setIso($iso)
    {
        $this->iso = $iso;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     * @return KeyLanguageTranslationDTO
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }
}
