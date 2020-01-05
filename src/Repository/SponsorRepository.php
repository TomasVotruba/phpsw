<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Sponsor;
use Webmozart\Assert\Assert;

/**
 * @extends AbstractRepository<Sponsor>
 */
class SponsorRepository extends AbstractRepository
{
    /**
     * @param Sponsor $sponsor
     */
    public function delete($sponsor): void
    {
        Assert::true($sponsor->canDelete());
        parent::delete($sponsor);
    }

    /**
     * @return Sponsor[]
     */
    public function findAll(): iterable
    {
        return $this->getRepository()->findBy([], ['name' => 'ASC']);
    }

    protected function getClassType(): string
    {
        return Sponsor::class;
    }
}
