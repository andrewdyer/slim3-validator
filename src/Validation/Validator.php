<?php

namespace Anddye\Validation;

use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * Class Validator
 * 
 * @author Andrew Dyer <andrewdyer@outlook.com>
 * @category Validation
 * @see https://github.com/andrewdyer/slim3-validator
 */
class Validator
{

    /** @var array */
    private $_errors = [];

    /**
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * 
     * @return boolean
     */
    public function hasPassed()
    {
        return empty($this->_errors);
    }

    /**
     * 
     * @param string $key
     * @param array $messages
     * @return $this
     */
    public function setErrors(string $key, array $messages)
    {
        $this->_errors[$key] = $messages;

        return $this;
    }

    /**
     * 
     * @param string $string
     * @return string
     */
    protected function formatName(string $string)
    {
        return str_replace(["-", "_"], " ", ucfirst(strtolower($string)));
    }

    /**
     * 
     * @param Request $request
     * @param array $rules
     * @return $this
     */
    public function validate(Request $request, array $rules)
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
