<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Destination
 *
 * @ORM\Table(name="destination")
 * @ORM\Entity
 */
class Destination
{
    /**
     * @var int
     *
     * @ORM\Column(name="iddest", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iddest;

    /**
     * @var string
     *
     * @ORM\Column(name="countries", type="string", length=255, nullable=false)
     */
    private $countries;


}
