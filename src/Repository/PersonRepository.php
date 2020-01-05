<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Person;
use Webmozart\Assert\Assert;

/**
 * @extends AbstractRepository<Person>
 */
class PersonRepository extends AbstractRepository
{
    /**
     * @return Person[]
     */
    public function findAll(): iterable
    {
        return $this->getRepository()->findBy([], ['name' => 'ASC']);
    }

    public function findBySlug(string $slug): ?Person
    {
        return $this->getRepository()->findOneBy(['slug' => $slug]);
    }

    /**
     * @param Person $person
     */
    public function delete($person): void
    {
        Assert::true($person->canDelete());
        parent::delete($person);
    }

    protected function getClassType(): string
    {
        return Person::class;
    }
}
