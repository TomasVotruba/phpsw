<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Event;
use App\Entity\Venue;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints;
use Webmozart\Assert\Assert;

class EventDto
{
    /**
     * @var string|null
     * @Constraints\NotBlank()
     * @Constraints\Length(max="255")
     */
    public $title;

    /**
     * @var DateTimeImmutable|null
     * @Constraints\NotBlank()
     */
    public $date;

    /**
     * @var string|null
     */
    public $description;

    /**
     * @var string|null
     * @Constraints\Length(max="255")
     */
    public $meetupId;

    /**
     * @var Venue|null
     */
    public $venue;

    /**
     * @var Venue|null
     */
    public $pub;

    /**
     * @var Event|null
     */
    private $event = null;

    public static function newInstance(): self
    {
        return new self();
    }

    public static function newInstanceFromEvent(Event $event): self
    {
        $eventDto = new self();
        $eventDto->event = $event;
        $eventDto->title = $event->getTitle();
        $eventDto->meetupId = $event->getMeetupId();
        $eventDto->date = $event->getDate();
        $eventDto->description = $event->getDescription();
        $eventDto->venue = $event->getVenue();
        $eventDto->pub = $event->getPub();

        return $eventDto;
    }

    public function asEvent(): Event
    {
        Assert::notNull($this->title);
        Assert::notNull($this->date);

        if ($this->event) {
            $event = $this->event;

            $event->setTitle($this->title);
            $event->setDate($this->date);
        } else {
            $event = new Event($this->title, $this->date);
        }

        $event->setMeetupId($this->meetupId);
        $event->setDescription($this->description);
        $event->setVenue($this->venue);
        $event->setPub($this->pub);

        return $event;
    }
}
