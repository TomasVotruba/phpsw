<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template T
 */
abstract class AbstractRepository
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param T $entity
     */
    final public function persist($entity): void
    {
        $manager = $this->getObjectManager();
        $manager->persist($entity);
        $manager->flush();
    }

    /**
     * @param T $entity
     */
    protected function delete($entity): void
    {
        $manager = $this->getObjectManager();
        $manager->remove($entity);
        $manager->flush();
    }

    protected function getObjectManager(): ObjectManager
    {
        return $this->managerRegistry->getManager();
    }

    /**
     * @return ObjectRepository<T>
     */
    protected function getRepository(): ObjectRepository
    {
        $classType = $this->getClassType();

        return $this->managerRegistry->getRepository($classType);
    }

    /**
     * @return class-string<T> string
     */
    abstract protected function getClassType(): string;
}
