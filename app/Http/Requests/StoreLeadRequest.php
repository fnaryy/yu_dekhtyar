<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'min:2', 'max:120'],
            'company' => ['required', 'string', 'min:2', 'max:120'],
            'contact' => ['required', 'string', 'min:3', 'max:200'],
            'phone'   => ['nullable', 'string', 'max:30'],
            'message' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'Укажите ваше имя',
            'name.min'         => 'Имя слишком короткое',
            'company.required' => 'Укажите название компании',
            'contact.required' => 'Укажите e-mail или Telegram',
            'contact.min'      => 'Контакт слишком короткий',
        ];
    }

    /**
     * Tighten input — trim whitespace and normalise contact a bit.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(array_map(
            fn ($v) => is_string($v) ? trim($v) : $v,
            $this->all()
        ));
    }
}
