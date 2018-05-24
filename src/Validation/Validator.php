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

    /** @var array */
    private $_params = [];

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
     * @param Request $request
     * @param array $rules
     * @return $this
     */
    public function validate(Request $request, array $rules)
    {
        foreach ($rules as $param => $validator) {
            try {
                $name = str_replace(['-', '_'], ' ', ucfirst(strtolower($param)));
                $validator->setName($name)->assert($request->getParam($param));
            } catch (NestedValidationException $ex) {
                $this->_errors[$param] = $ex->getMessages();
            }
        }
        return $this;
    }

}
