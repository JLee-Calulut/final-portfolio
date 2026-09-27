<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    /**
     * The contact form is public — authorization happens at the throttle
     * middleware layer, not here.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Sanitize input before validation runs.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->clean($this->input('name')),
            'email' => $this->clean($this->input('email')),
            'subject' => $this->clean($this->input('subject')),
            'message' => $this->clean($this->input('message'), keepNewlines: true),
        ]);
    }

    /**
     * Trim whitespace and strip any HTML from incoming text.
     */
    private function clean(mixed $value, bool $keepNewlines = false): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = trim(strip_tags($value));

        if (! $keepNewlines) {
            $value = preg_replace('/\s+/', ' ', $value);
        }

        return $value === '' ? null : $value;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
            'subject' => ['required', 'string', 'min:3', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    /**
     * Friendlier validation messages for the contact form.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please tell me your name.',
            'email.required' => 'I need an email address to reply to.',
            'email.email' => 'That email address does not look valid.',
            'subject.required' => 'Please add a short subject.',
            'message.required' => 'Please write a message.',
            'message.min' => 'Give me a little more detail — at least 10 characters.',
        ];
    }
}
