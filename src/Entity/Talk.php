<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Talk
{
    use SluggerTrait;

    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $abstract;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $originalRelativeUrl;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slidesUrl;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $joindinUrl;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $videoUrl;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $showcase = false;

    /**
     * @var Event
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="talks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @var Collection<int,Person>
     * @ORM\ManyToMany(targetEntity="App\Entity\Person", inversedBy="talks")
     */
    private $speakers;

    public function __construct(string $title, Event $event)
    {
        $this->speakers = new ArrayCollection();
        $this->setTitle($title);
        $this->event = $event;
        $this->showcase = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        $this->slug = $this->asSlug($title);

        return $this;
    }

    public function getAbstract(): ?string
    {
        return $this->abstract;
    }

    public function setAbstract(?string $abstract): self
    {
        $this->abstract = $abstract;

        return $this;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function getOriginalRelativeUrl(): ?string
    {
        return $this->originalRelativeUrl;
    }

    public function setOriginalRelativeUrl(?string $originalRelativeUrl): self
    {
        $this->originalRelativeUrl = $originalRelativeUrl;

        return $this;
    }

    public function getSlidesUrl(): ?string
    {
        return $this->slidesUrl;
    }

    public function setSlidesUrl(?string $slidesUrl): self
    {
        $this->slidesUrl = $slidesUrl;

        return $this;
    }

    public function getJoindinUrl(): ?string
    {
        return $this->joindinUrl;
    }

    public function setJoindinUrl(?string $joindinUrl): self
    {
        $this->joindinUrl = $joindinUrl;

        return $this;
    }

    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    public function setVideoUrl(?string $videoUrl): self
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    /**
     * @return Collection<int,Person>
     */
    public function getSpeakers(): Collection
    {
        return $this->speakers;
    }

    public function addSpeaker(Person $person): self
    {
        if (!$this->speakers->contains($person)) {
            $this->speakers[] = $person;
        }

        return $this;
    }

    public function removeSpeaker(Person $person): self
    {
        if ($this->speakers->contains($person)) {
            $this->speakers->removeElement($person);
        }

        return $this;
    }

    public function isShowcase(): bool
    {
        return $this->showcase;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setShowcase(bool $showcase): self
    {
        $this->showcase = $showcase;

        return $this;
    }
}
