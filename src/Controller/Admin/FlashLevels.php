<?php

declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * Add constants as required for different kinds of flash methods.
 */
interface FlashLevels
{
    /**
     * @var string
     */
    public const SUCCESS = 'success';

    /**
     * @var string
     */
    public const DANGER = 'danger';
}
