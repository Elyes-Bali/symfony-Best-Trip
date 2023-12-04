<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Circuit
 *
 * @ORM\Table(name="circuit", indexes={@ORM\Index(name="iddest", columns={"destination_id"})})
 * @ORM\Entity
 */
class Circuit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="depart", type="string", length=255, nullable=false)
     */
    private $depart;

    /**
     * @var string
     *
     * @ORM\Column(name="arrive", type="string", length=255, nullable=false)
     */
    private $arrive;

    /**
     * @var string
     *
     * @ORM\Column(name="temps", type="string", length=255, nullable=false)
     */
    private $temps;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable=false)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255, nullable=false)
     */
    private $pays;

    /**
     * @var \Destination
     *
     * @ORM\ManyToOne(targetEntity="Destination")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destination_id", referencedColumnName="iddest")
     * })
     */
    private $destination;


}
