<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Event
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
     * @ORM\Column(type="string", length=280)
     */
    private $slug;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $meetupId;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var Venue|null
     * @ORM\ManyToOne(targetEntity="App\Entity\Venue", inversedBy="events")
     */
    private $venue;

    /**
     * @var Venue|null
     * @ORM\ManyToOne(targetEntity="App\Entity\Venue", inversedBy="pubs")
     */
    private $pub;

    /**
     * @var Collection<int,Person>
     * @ORM\ManyToMany(targetEntity="App\Entity\Person", inversedBy="events")
     */
    private $organisers;

    /**
     * @var Collection<int,Sponsor>
     * @ORM\ManyToMany(targetEntity="App\Entity\Sponsor", inversedBy="events")
     */
    private $sponsors;

    /**
     * @var Collection<int,Talk>
     * @ORM\OneToMany(targetEntity="App\Entity\Talk", mappedBy="event", orphanRemoval=true)
     */
    private $talks;

    public function __construct(string $title, DateTimeImmutable $date)
    {
        $this->organisers = new ArrayCollection();
        $this->sponsors = new ArrayCollection();
        $this->talks = new ArrayCollection();
        $this->title = $title;
        $this->date = $date;
        $this->updateSlug();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeetupId(): ?string
    {
        return $this->meetupId;
    }

    public function setMeetupId(?string $meetupId): self
    {
        $this->meetupId = $meetupId;

        return $this;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): self
    {
        $this->date = $date;
        $this->updateSlug();

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        $this->updateSlug();

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

    public function getVenue(): ?Venue
    {
        return $this->venue;
    }

    public function setVenue(?Venue $venue): self
    {
        $this->venue = $venue;

        return $this;
    }

    public function getPub(): ?Venue
    {
        return $this->pub;
    }

    public function setPub(?Venue $pub): self
    {
        $this->pub = $pub;

        return $this;
    }

    /**
     * @return Collection<int,Person>
     */
    public function getOrganisers(): Collection
    {
        return $this->organisers;
    }

    public function addOrganiser(Person $organiser): self
    {
        if (!$this->organisers->contains($organiser)) {
            $this->organisers[] = $organiser;
        }

        return $this;
    }

    public function removeOrganiser(Person $organiser): self
    {
        if ($this->organisers->contains($organiser)) {
            $this->organisers->removeElement($organiser);
        }

        return $this;
    }

    /**
     * @return Collection<int,Sponsor>
     */
    public function getSponsors(): Collection
    {
        return $this->sponsors;
    }

    public function addSponsor(Sponsor $sponsor): self
    {
        if (!$this->sponsors->contains($sponsor)) {
            $this->sponsors[] = $sponsor;
        }

        return $this;
    }

    public function removeSponsor(Sponsor $sponsor): self
    {
        if ($this->sponsors->contains($sponsor)) {
            $this->sponsors->removeElement($sponsor);
        }

        return $this;
    }

    /**
     * @return Collection<int,Talk>
     */
    public function getTalks(): Collection
    {
        return $this->talks;
    }

    public function addTalk(Talk $talk): self
    {
        if (!$this->talks->contains($talk)) {
            $this->talks[] = $talk;
        }

        return $this;
    }

    public function removeTalk(Talk $talk): self
    {
        if ($this->talks->contains($talk)) {
            $this->talks->removeElement($talk);
        }

        return $this;
    }

    public function canDelete(): bool
    {
        return $this->talks->isEmpty();
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    private function updateSlug(): void
    {
        $raw = "{$this->date->format('Y-m')} {$this->title}";
        $this->slug = $this->asSlug($raw);
    }
}
