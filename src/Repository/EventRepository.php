<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Event;
use Webmozart\Assert\Assert;

/**
 * @extends AbstractRepository<Event>
 */
class EventRepository extends AbstractRepository
{
    /**
     * @param Event $event
     */
    public function delete($event): void
    {
        Assert::true($event->canDelete());
        parent::delete($event);
    }

    /**
     * @return Event[]
     */
    public function findAll(): iterable
    {
        return $this->getRepository()->findBy([], ['date' => 'DESC']);
    }

    protected function getClassType(): string
    {
        return Event::class;
    }
}
