<?php namespace Ihsw\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Post")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var integer
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     * @var string
     */
    public $body;
}
