<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    protected array $rules;

    protected array $requiredAttributes = [];

    protected array $assignedMethod = [];

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->rules = $this->defaultRules();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $this->validatePerHtmlMethod();

        return $this->rules;
    }

    /**
     * Add required attributes dynamically based on extension if needed
     */
    protected function validatePerHtmlMethod(): void
    {
        if ($this->assignedMethod && in_array($this->getMethod(), $this->assignedMethod)) {
            $this->addRequiredAttributes();
        }
    }

    protected function addRequiredAttributes(): void
    {
        if (count($this->requiredAttributes) > 0) {
            foreach ($this->requiredAttributes as $field) {
                $this->rules[$field][] = 'required';
            }
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    abstract public function authorize(): bool;

    /**
     * Builds default rule list available for all types of requests
     */
    abstract protected function defaultRules(): array;
}
