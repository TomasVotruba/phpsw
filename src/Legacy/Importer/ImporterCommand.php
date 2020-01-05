<?php

declare(strict_types=1);

namespace App\Legacy\Importer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;
use Webmozart\Assert\Assert;

class ImporterCommand extends Command
{
    /**
     * @var string
     */
    public const VENUE = 'locations';

    /**
     * @var string
     */
    public const EVENT = 'events';

    /**
     * @var string
     */
    public const PERSON = 'people';

    /**
     * @var string
     */
    public const SPONSOR = 'sponsors';

    /**
     * @var string
     */
    public const TALK = 'talks';

    /**
     * @var string
     */
    protected static $defaultName = 'phpsw:legacy:import';

    /**
     * @phpstan-var array<string,EntityImporter>
     *
     * @var EntityImporter[]
     */
    private $importers = [];

    /**
     * @var DirectoryReader
     */
    private $directoryReader;

    /**
     * Importer constructor.
     */
    public function __construct(
        DirectoryReader $directoryReader,
        VenueImporter $venueImporter,
        SponsorImporter $sponsorImporter,
        PersonImporter $personImporter,
        EventImporter $eventImporter,
        TalkImporter $talkImporter
    ) {
        parent::__construct();
        $this->directoryReader = $directoryReader;
        $this->importers = [
            self::VENUE => $venueImporter,
            self::SPONSOR => $sponsorImporter,
            self::PERSON => $personImporter,
            self::EVENT => $eventImporter,
            self::TALK => $talkImporter,
        ];
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $importedData = [];

        // Import each entity type in turn
        foreach ($this->importers as $directory => $importer) {
            $importedData[$directory] = [];

            $files = $this->directoryReader->getFileNameMappings($directory);
            foreach ($files as $filename => $slug) {
                try {
                    $fileContents = file_get_contents($filename);
                    $entityData = json_decode($fileContents, true);
                    Assert::isArray($entityData);
                    $entity = $importer->import($entityData, $importedData);
                    $importedData[$directory][$slug] = $entity;
                } catch (Throwable $throwable) {
                    $output->writeln("${directory}, ${slug}");
                    $output->writeln($throwable->getMessage());

                    return 1;
                }
            }
        }

        return 0;
    }
}
