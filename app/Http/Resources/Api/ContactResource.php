<?php

declare(strict_types=1);

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

class ContactResource extends JsonApiResource
{
    /**
     * @param Request $request
     * @return string
     */
    protected function toType(Request $request): string
    {
        return 'contact';
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function toAttributes(Request $request): array
    {
        return [
            'title' => $this->title,
            'name' => [
                'first' => $this->first_name,
                'middle' => $this->middle_name,
                'last' => $this->last_name,
                'preferred' => $this->preferred_name,
                'full' => $this->fullName(),
            ],
            'pronoun' => $this->pronoun,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }

    /**
     * @return string
     */
    protected function fullName(): string
    {
        return ltrim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
}
