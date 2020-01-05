<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Talk;

/**
 * @extends AbstractRepository<Talk>
 */
class TalkRepository extends AbstractRepository
{
    /**
     * @param Talk $talk
     */
    public function delete($talk): void
    {
        foreach ($talk->getSpeakers() as $speaker) {
            $talk->removeSpeaker($speaker);
        }
        $talk->getEvent()->removeTalk($talk);
        parent::delete($talk);
    }

    protected function getClassType(): string
    {
        return Talk::class;
    }
}
