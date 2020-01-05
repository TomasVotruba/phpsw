<?php

declare(strict_types=1);

namespace App\Legacy\Importer;

use App\Entity\Person;

class PersonImporter extends EntityImporter
{
    public function import(array $entityData, array $importedData): object
    {
        $person = new Person($entityData['name'], Person::NORMAL_USER);

        if (isset($entityData['meetupId'])) {
            $person->setMeetupId((string) $entityData['meetupId']);
        }

        $person->setDescription($entityData['description'] ?? null);
        $person->setWebsiteUrl($entityData['website-url'] ?? null);
        $person->setGithubHandle($entityData['github-handle'] ?? null);
        $person->setTwitterHandle($entityData['twitter-handle'] ?? null);
        $person->setPhotoUrl($entityData['photo-url'] ?? null);

        return $this->persistIfNew(Person::class, $person, 'name', $person->getName());
    }
}
