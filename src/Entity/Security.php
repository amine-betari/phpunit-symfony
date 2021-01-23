<?php
/**
 * Created by PhpStorm.
 * User: aminebetari
 * Date: 09/12/20
 * Time: 00:35
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="securities")
 */
class Security
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Enclosure", inversedBy="securities")
     */
    private $enclosure;


    public function __construct(string $name, bool $isActive, Enclosure $enclosure)
    {
        $this->name = $name;
        $this->isActive = $isActive;
        $this->enclosure = $enclosure;
    }
    public function getIsActive(): bool
    {
        return $this->isActive;
    }

}