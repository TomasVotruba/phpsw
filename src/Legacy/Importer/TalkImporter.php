<?php

declare(strict_types=1);

namespace App\Legacy\Importer;

/*
{
  "title": "Web Security - The Human Factor",
  "abstract": "An overview of how web developers can protect their applications, their businesses, but most importantly; their sanity. It will include a brief overview of common mistakes made with web applications that could lead the developer, and/or others to a security faux pas. Some best practices to follow, and some real world examples of where I/others have screwed up.",
  "event": "2018-05-security",
  "speakers": [
    "rob-wilson"
  ],
  "joindin-url": "dd98f",
  "slides-url": "",
  "video-url": "https://www.youtube.com/watch?v=4c-c8qUWve8",
  "showcase": true
}
*/

use App\Entity\Talk;

class TalkImporter extends EntityImporter
{
    public function import(array $entityData, array $importedData): object
    {
        $event = $this->lookup(ImporterCommand::EVENT, 'event', $entityData, $importedData);
        $talk = new Talk($entityData['title'], $event);

        $talk->setAbstract($entityData['abstract'] ?? null);
        $talk->setJoindinUrl($entityData['joindin-url'] ?? null);
        $talk->setSlidesUrl($entityData['slides-url'] ?? null);
        $talk->setVideoUrl($entityData['video-url'] ?? null);
        $talk->setShowcase($entityData['showcase'] ?? false);

        $speakers = $entityData['speakers'] ?? [];
        foreach ($speakers as $speaker) {
            $talk->addSpeaker($this->lookupValue(ImporterCommand::PERSON, $speaker, $importedData));
        }

        $this->persist($talk);

        return $talk;
    }
}
