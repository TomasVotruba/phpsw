<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity()
 */
class Sponsor
{
    use SluggerTrait;

    public const FULL = 'full';
    public const VENUE = 'venue';

    public const SPONSOR_TYPES = [
        self::FULL,
        self::VENUE,
    ];

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $currentSponsor;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $logoUrl;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $websiteUrl;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $sponsorType;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var Collection<int,Event>
     * @ORM\ManyToMany(targetEntity="App\Entity\Event", mappedBy="sponsors")
     */
    private $events;

    public function __construct(string $name, string $sponsorType, string $logoUrl, string $websiteUrl)
    {
        $this->events = new ArrayCollection();
        $this->currentSponsor = false;
        $this->setName($name);
        $this->setSponsorType($sponsorType);
        $this->setLogoUrl($logoUrl);
        $this->setWebsiteUrl($websiteUrl);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        $this->slug = $this->asSlug($name);

        return $this;
    }

    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    public function setLogoUrl(string $logoUrl): self
    {
        $this->logoUrl = $logoUrl;

        return $this;
    }

    public function getWebsiteUrl(): ?string
    {
        return $this->websiteUrl;
    }

    public function setWebsiteUrl(string $websiteUrl): self
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    public function getSponsorType(): ?string
    {
        return $this->sponsorType;
    }

    public function setSponsorType(string $sponsorType): self
    {
        Assert::oneOf($sponsorType, self::SPONSOR_TYPES);
        $this->sponsorType = $sponsorType;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isCurrentSponsor(): bool
    {
        return $this->currentSponsor;
    }

    public function setCurrentSponsor(bool $currentSponsor): void
    {
        $this->currentSponsor = $currentSponsor;
    }

    /**
     * @return Collection<int,Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addSponsor($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            $event->removeSponsor($this);
        }

        return $this;
    }

    public function canDelete(): bool
    {
        return $this->events->isEmpty();
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
