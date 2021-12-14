<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Interactions;

use Domains\Interactions\Enums\InteractionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'string',
                new Enum(
                    type: InteractionType::class,
                ),
            ],
            'content' => [
                'nullable',
                'string',
            ],
            'contact' => [
                'required',
                'int',
                'exists:contacts,id',
            ],
            'project' => [
                'nullable',
                'int',
                'exists:projects,id',
            ]
        ];
    }
}
