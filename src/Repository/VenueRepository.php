<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Venue;
use Webmozart\Assert\Assert;

/**
 * @extends AbstractRepository<Venue>
 */
class VenueRepository extends AbstractRepository
{
    /**
     * @param Venue $venue
     */
    public function delete($venue): void
    {
        Assert::true($venue->canDelete());
        parent::delete($venue);
    }

    /**
     * @return Venue[]
     */
    public function findAll(): iterable
    {
        return $this->getRepository()->findBy([], ['name' => 'ASC']);
    }

    protected function getClassType(): string
    {
        return Venue::class;
    }
}
