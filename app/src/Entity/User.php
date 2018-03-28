<?php namespace Ihsw\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Users")
 */
class User implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var integer
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     * @var string
     */
    public $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, name="hashed_password")
     * @var string
     */
    public $hashedPassword;

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'hashed_password' => $this->hashedPassword
        ];
    }
}
