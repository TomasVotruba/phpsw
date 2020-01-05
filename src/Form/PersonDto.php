<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Validator\Constraints;
use Webmozart\Assert\Assert;

class PersonDto
{
    /**
     * @var string|null
     * @Constraints\NotBlank()
     * @Constraints\Length(max="255")
     */
    public $name;

    /**
     * @var string|null
     * @Constraints\NotBlank()
     * @Constraints\Length(max="255")
     */
    public $type;

    /**
     * @var string|null
     * @Constraints\Url()
     * @Constraints\Length(max="255")
     */
    public $photoUrl;

    /**
     * @var string|null
     * @Constraints\Length(max="4096")
     */
    public $description;

    /**
     * @var string|null
     * @Constraints\Length(max="4096")
     */
    public $fullDescription;

    /**
     * @var string|null
     * @Constraints\Length(max="255")
     */
    public $twitterHandle;

    /**
     * @var string|null
     * @Constraints\Url()
     * @Constraints\Length(max="255")
     */
    public $websiteUrl;

    /**
     * @var string|null
     */
    public $meetupId;

    /**
     * @var string|null
     * @Constraints\Length(max="255")
     */
    public $githubHandle;

    /**
     * @var string|null
     * @Constraints\Email()
     * @Constraints\Length(max="255")
     */
    public $email;

    /**
     * @var string|null
     * @Constraints\Length(max="20")
     */
    public $mobileNumber;

    /**
     * @var Person|null
     */
    private $person = null;

    public static function newInstance(): self
    {
        return new self();
    }

    public static function newInstanceFromPerson(Person $person): self
    {
        $personDto = new self();
        $personDto->person = $person;
        $personDto->name = $person->getName();
        $personDto->type = $person->getType();
        $personDto->photoUrl = $person->getPhotoUrl();
        $personDto->description = $person->getDescription();
        $personDto->fullDescription = $person->getFullDescription();
        $personDto->twitterHandle = $person->getTwitterHandle();
        $personDto->githubHandle = $person->getGithubHandle();
        $personDto->websiteUrl = $person->getWebsiteUrl();
        $personDto->meetupId = $person->getMeetupId();
        $personDto->email = $person->getEmail();
        $personDto->mobileNumber = $person->getMobileNumber();

        return $personDto;
    }

    public function asPerson(): Person
    {
        Assert::notNull($this->name);
        Assert::notNull($this->type);

        if ($this->person) {
            $person = $this->person;

            $person->setName($this->name);
            $person->setType($this->type);
        } else {
            $person = new Person($this->name, $this->type);
        }

        $person->setPhotoUrl($this->photoUrl);
        $person->setDescription($this->description);
        $person->setFullDescription($this->fullDescription);
        $person->setTwitterHandle($this->twitterHandle);
        $person->setGithubHandle($this->githubHandle);
        $person->setWebsiteUrl($this->websiteUrl);
        $person->setMeetupId($this->meetupId);
        $person->setEmail($this->email);
        $person->setMeetupId($this->mobileNumber);

        return $person;
    }
}
