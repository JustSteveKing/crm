<?php

declare(strict_types=1);

namespace Domains\Interactions\Enums;

enum InteractionType: string
{
    case PHONE = 'phone';
    case EMAIL = 'email';
    case MEETING = 'meeting';
}
