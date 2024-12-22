<?php

namespace Anddye\Validation;

use Psr\Http\Message\RequestInterface as Request;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * Class Validator.
 *
 * @author Andrew Dyer
 *
 * @category Validation
 *
 * @see https://github.com/andrewdyer/slim3-validator
 */
class Validator
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasPassed(): bool
    {
        return empty($this->errors);
    }

    /**
     * @param string $field
     * @param array  $messages
     *
     * @return Validator
     */
    public function setErrors(string $field, array $messages): self
    {
        $this->errors[$field] = $messages;

        return $this;
    }

    /**
     * @param Request $request
     * @param array   $rules
     *
     * @return Validator
     */
    public function validate(Request $request, array $rules): self
    {
        foreach ($rules as $field => $validator) {
            try {
                $name = str_replace(['-', '_'], ' ', ucfirst(strtolower($field)));
                $validator->setName($name)->assert($request->getParam($field));
            } catch (NestedValidationException $ex) {
                $this->setErrors($field, $ex->getMessages());
            }
        }

        return $this;
    }
}
