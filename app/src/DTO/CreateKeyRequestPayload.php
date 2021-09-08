<?php

use Symfony\Component\Validator\Constraints as Assert;

final class CreateKeyRequestPayload
{
    /**
     * @Assert\Type(type="string")
     * @Assert\NotNull
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }
}