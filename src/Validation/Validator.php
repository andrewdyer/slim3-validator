<?php

namespace Anddye\Validation;

use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * Class Validator.
 */
class Validator
{
    /** @var array */
    private $_errors = [];

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->_errors;
    }

    /**
     * @return bool
     */
    public function hasPassed(): bool
    {
        return empty($this->_errors);
    }

    /**
     * @param string $key
     * @param array  $messages
     *
     * @return $this
     */
    public function setErrors(string $key, array $messages): self
    {
        $this->_errors[$key] = $messages;

        return $this;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function formatName(string $string): string
    {
        return str_replace(['-', '_'], ' ', ucfirst(strtolower($string)));
    }

    /**
     * @param Request $request
     * @param array   $rules
     *
     * @return $this
     */
    public function validate(Request $request, array $rules): self
    {
        foreach ($rules as $field => $validator) {
            try {
                $name = $this->formatName($field);
                $validator->setName($name)->assert($request->getParam($field));
            } catch (NestedValidationException $ex) {
                $this->setErrors($field, $ex->getMessages());
            }
        }

        return $this;
    }
}
