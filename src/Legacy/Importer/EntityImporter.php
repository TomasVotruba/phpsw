<?php

declare(strict_types=1);

namespace App\Legacy\Importer;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;

abstract class EntityImporter
{
    /**
     * @var ManagerRegistry
     */
    private $entityManager;

    final public function __construct(ManagerRegistry $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    abstract public function import(array $entityData, array $importedData): object;

    final protected function persistIfNew(string $type, object $entity, string $fieldName, $value)
    {
        $repository = $this->getRepository($type);
        $foundEntity = $repository->findOneBy([$fieldName => $value]);
        if (null === $foundEntity) {
            $this->persist($entity);

            return $entity;
        }

        return $foundEntity;
    }

    protected function persist(object $entity): void
    {
        $manager = $this->entityManager->getManager();
        $manager->persist($entity);
        $manager->flush();
    }

    protected function lookup(string $type, string $key, array $entityData, array $importedData)
    {
        $slug = $entityData[$key] ?? '';
        if (empty($slug)) {
            return null;
        }

        return $this->lookupValue($type, $slug, $importedData);
    }

    protected function lookupValue(string $type, string $slug, array $importedData)
    {
        return $importedData[$type][$slug];
    }

    private function getRepository(string $classType): ObjectRepository
    {
        return $this->entityManager->getRepository($classType);
    }
}
