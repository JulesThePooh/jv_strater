<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $launchAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $noteGlobal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pathImg;

    /**
     * @ORM\ManyToMany(targetEntity=GameCategory::class, mappedBy="games")
     */
    private $gameCategories;

    /**
     * @ORM\ManyToMany(targetEntity=Device::class, mappedBy="games")
     */
    private $devices;

    /**
     * @ORM\OneToOne(targetEntity=Forum::class, mappedBy="game", cascade={"persist", "remove"})
     */
    private $forum;

    public function __construct()
    {
        $this->gameCategories = new ArrayCollection();
        $this->devices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLaunchAt(): ?\DateTimeInterface
    {
        return $this->launchAt;
    }

    public function setLaunchAt(?\DateTimeInterface $launchAt): self
    {
        $this->launchAt = $launchAt;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getNoteGlobal(): ?int
    {
        return $this->noteGlobal;
    }

    public function setNoteGlobal(?int $noteGlobal): self
    {
        $this->noteGlobal = $noteGlobal;

        return $this;
    }

    public function getPathImg(): ?string
    {
        return $this->pathImg;
    }

    public function setPathImg(?string $pathImg): self
    {
        $this->pathImg = $pathImg;

        return $this;
    }

    /**
     * @return Collection|GameCategory[]
     */
    public function getGameCategories(): Collection
    {
        return $this->gameCategories;
    }

    public function addGameCategory(GameCategory $gameCategory): self
    {
        if (!$this->gameCategories->contains($gameCategory)) {
            $this->gameCategories[] = $gameCategory;
            $gameCategory->addGame($this);
        }

        return $this;
    }

    public function removeGameCategory(GameCategory $gameCategory): self
    {
        if ($this->gameCategories->removeElement($gameCategory)) {
            $gameCategory->removeGame($this);
        }

        return $this;
    }

    /**
     * @return Collection|Device[]
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(Device $device): self
    {
        if (!$this->devices->contains($device)) {
            $this->devices[] = $device;
            $device->addGame($this);
        }

        return $this;
    }

    public function removeDevice(Device $device): self
    {
        if ($this->devices->removeElement($device)) {
            $device->removeGame($this);
        }

        return $this;
    }

    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(?Forum $forum): self
    {
        // unset the owning side of the relation if necessary
        if ($forum === null && $this->forum !== null) {
            $this->forum->setGame(null);
        }

        // set the owning side of the relation if necessary
        if ($forum !== null && $forum->getGame() !== $this) {
            $forum->setGame($this);
        }

        $this->forum = $forum;

        return $this;
    }
}
