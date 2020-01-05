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
class Person
{
    use SluggerTrait;

    public const ORGANISER_USER = 'organiser';

    public const HELPER_USER = 'helper';

    public const NORMAL_USER = 'normal';

    public const USER_TYPES = [
        self::NORMAL_USER,
        self::HELPER_USER,
        self::ORGANISER_USER,
    ];

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
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoUrl;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=4096, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=4096, nullable=true)
     */
    private $fullDescription;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitterHandle;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $githubHandle;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $websiteUrl;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $meetupId;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $mobileNumber;

    /**
     * @var Collection<int,Talk>
     * @ORM\ManyToMany(targetEntity="App\Entity\Talk", mappedBy="speakers")
     */
    private $talks;

    /**
     * @var Collection<int,Event>
     * @ORM\ManyToMany(targetEntity="App\Entity\Event", mappedBy="organisers")
     */
    private $events;

    public function __construct(string $name, string $type)
    {
        $this->talks = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->setName($name);
        $this->setType($type);
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

    public function getPhotoUrl(): ?string
    {
        return $this->photoUrl;
    }

    public function setPhotoUrl(?string $photoUrl): self
    {
        $this->photoUrl = $photoUrl;

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

    public function getTwitterHandle(): ?string
    {
        return $this->twitterHandle;
    }

    public function setTwitterHandle(?string $twitterHandle): self
    {
        $this->twitterHandle = $twitterHandle;

        return $this;
    }

    public function getGithubHandle(): ?string
    {
        return $this->githubHandle;
    }

    public function setGithubHandle(?string $githubHandle): self
    {
        $this->githubHandle = $githubHandle;

        return $this;
    }

    public function getWebsiteUrl(): ?string
    {
        return $this->websiteUrl;
    }

    public function setWebsiteUrl(?string $websiteUrl): self
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
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
            $talk->addSpeaker($this);
        }

        return $this;
    }

    public function removeTalk(Talk $talk): self
    {
        if ($this->talks->contains($talk)) {
            $this->talks->removeElement($talk);
            $talk->removeSpeaker($this);
        }

        return $this;
    }

    public function getFullDescription(): ?string
    {
        return $this->fullDescription;
    }

    public function setFullDescription(?string $fullDescription): void
    {
        $this->fullDescription = $fullDescription;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    public function setMobileNumber(?string $mobileNumber): void
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        Assert::oneOf($type, self::USER_TYPES);
        $this->type = $type;
    }

    public function canDelete(): bool
    {
        return $this->talks->isEmpty() && $this->events->isEmpty();
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
