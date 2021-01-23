<?php
/**
 * Created by PhpStorm.
 * User: aminebetari
 * Date: 03/12/20
 * Time: 11:56
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Exception\NotABuffetException;
use App\Exception\DinosaursAreRunningRampantException;

/**
 * @ORM\Entity
 * @ORM\Table(name="enclosure")
 */
class Enclosure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\Security", mappedBy="enclosure", cascade={"persist"})
     */
    private $securities;
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\Dinosaur",  mappedBy="enclosure", cascade={"persist"})
     */
    private $dinosaurs;

    public function __construct(bool $withBasicSecurity = false)
    {
        $this->dinosaurs = new ArrayCollection();
        $this->securities = new ArrayCollection();

        if ($withBasicSecurity) {
            $this->addSecurity(new Security('Fence', true, $this));
        }
    }

    public function getDinosaurs(): Collection
    {
        return $this->dinosaurs;
    }

    public function addSecurity(Security $security)
    {
        $this->securities[] = $security;
    }

    public function addDinosaur(Dinosaur $dinosaur)
    {
        if (!$this->canAddDinosaur($dinosaur)) {
            throw new NotABuffetException();
        }

        if (!$this->isSecurityActive()) {
          //  throw new DinosaursAreRunningRampantException('Are you craaazy?!?');
        }

        $this->dinosaurs[] = $dinosaur;
    }

    private function canAddDinosaur(Dinosaur $dinosaur): bool
    {
        return count($this->dinosaurs) === 0
            || $this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous();
    }


    public function isSecurityActive(): bool
    {
        foreach ($this->securities as $security) {
            if ($security->getIsActive()) {
                return true;
            }
        }
        return false;
    }


    public function getSecurities(): Collection
    {
        return $this->securities;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getDinosaurCount(): int
    {
        return $this->dinosaurs->count();
    }

}