<?php

declare(strict_types=1);

namespace Domains\Interactions\ValueObjects;

use Infrastructure\Contracts\ValueObjectContract;

class InteractionValueObject implements ValueObjectContract
{
    /**
     * @param string $type
     * @param int $contact
     * @param int|null $user
     * @param string|null $content
     * @param int|null $project
     */
    public function __construct(
        public string $type,
        public int $contact,
        public null|int $user,
        public null|string $content = null,
        public null|int $project = null,
    ) {}

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'content' => $this->content,
            'user_id' => $this->user,
            'contact_id' => $this->contact,
            'project_id' => $this->project,
        ];
    }
}
