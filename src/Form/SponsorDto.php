<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Sponsor;
use Symfony\Component\Validator\Constraints;
use Webmozart\Assert\Assert;

class SponsorDto
{
    /**
     * @var string|null
     * @Constraints\NotBlank()
     * @Constraints\Length(max="255")
     */
    public $name;

    /**
     * @var bool
     */
    public $currentSponsor = false;

    /**
     * @var string|null
     * @Constraints\NotBlank()
     * @Constraints\Length(max="255")
     */
    public $logoUrl;

    /**
     * @var string|null
     * @Constraints\Url()
     * @Constraints\Length(max="255")
     */
    public $websiteUrl;

    /**
     * @var string|null
     * @Constraints\Length(max="255")
     */
    public $description;

    /**
     * @var string|null
     * @Constraints\NotBlank()
     * @Constraints\Length(max="255")
     */
    public $sponsorType;

    /**
     * @var Sponsor|null
     */
    private $sponsor = null;

    public static function newInstance(): self
    {
        return new self();
    }

    public static function newInstanceFromSponsor(Sponsor $sponsor): self
    {
        $sponsorDto = new self();
        $sponsorDto->sponsor = $sponsor;
        $sponsorDto->name = $sponsor->getName();
        $sponsorDto->currentSponsor = $sponsor->isCurrentSponsor();
        $sponsorDto->logoUrl = $sponsor->getLogoUrl();
        $sponsorDto->websiteUrl = $sponsor->getWebsiteUrl();
        $sponsorDto->sponsorType = $sponsor->getSponsorType();
        $sponsorDto->description = $sponsor->getDescription();

        return $sponsorDto;
    }

    public function asSponsor(): Sponsor
    {
        Assert::notNull($this->name);
        Assert::notNull($this->currentSponsor);
        Assert::notNull($this->logoUrl);
        Assert::notNull($this->websiteUrl);
        Assert::notNull($this->sponsorType);

        if ($this->sponsor) {
            $sponsor = $this->sponsor;

            $sponsor->setName($this->name);
            $sponsor->setLogoUrl($this->logoUrl);
            $sponsor->setWebsiteUrl($this->websiteUrl);
            $sponsor->setSponsorType($this->sponsorType);
        } else {
            $sponsor = new Sponsor($this->name, $this->sponsorType, $this->logoUrl, $this->websiteUrl);
        }

        $sponsor->setCurrentSponsor($this->currentSponsor);
        $sponsor->setDescription($this->description);

        return $sponsor;
    }
}
