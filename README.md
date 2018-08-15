# Slim3 Validator

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/288ea903a3eb4f18990db20f8358be5d)](https://www.codacy.com/app/andrewdyer/slim3-validator?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=andrewdyer/slim3-validator&amp;utm_campaign=Badge_Grade)
[![Latest Stable Version](https://poser.pugx.org/andrewdyer/slim3-validator/version)](https://packagist.org/packages/andrewdyer/slim3-validator)
[![Latest Unstable Version](https://poser.pugx.org/andrewdyer/slim3-validator/v/unstable)](//packagist.org/packages/andrewdyer/slim3-validator)
[![License](https://poser.pugx.org/andrewdyer/slim3-validator/license)](https://packagist.org/packages/andrewdyer/slim3-validator)
[![Total Downloads](https://poser.pugx.org/andrewdyer/slim3-validator/downloads)](https://packagist.org/packages/andrewdyer/slim3-validator)
[![Daily Downloads](https://poser.pugx.org/andrewdyer/slim3-validator/d/daily)](https://packagist.org/packages/andrewdyer/slim3-validator)
[![Monthly Downloads](https://poser.pugx.org/andrewdyer/slim3-validator/d/monthly)](https://packagist.org/packages/andrewdyer/slim3-validator)
[![composer.lock available](https://poser.pugx.org/andrewdyer/slim3-validator/composerlock)](https://packagist.org/packages/andrewdyer/slim3-validator)

A validation library for the Slim Framework built using [Respect/Validation](https://github.com/Respect/Validation).

## License

Licensed under MIT. Totally free for private or commercial projects.

## Installation

```bash
composer require andrewdyer/slim3-validator
```

## Usage

Attach a new instance of `Anddye\Validation\Validator` to your applications container so 
it can be accessed anywhere you need.

```php
$app = new \Slim\App();

$container = $app->getContainer();

$container['validator'] = function () {
    return new Anddye\Validation\Validator();
};

$app->run();
```

You can easily validate your form inputs using the validate() helper. Assign to a 
variable the `validate()` method - passing in the $request object as well as an array 
where the array key represents the name of the field and the array value represents 
the validation rules:

```php
$app->get('/', function (Request $request, Response $response) use ($container) {
    $validation = $container['validator']->validate($request, [
        'email' => v::email()->length(1, 254)->notEmpty(),
        'forename' => v::alpha()->length(1, 100)->notEmpty()->noWhitespace(),
        'password' => v::length(8, 100)->notEmpty(),
        'surname' => v::alpha()->length(1, 100)->notEmpty()->noWhitespace(),
        'username' => v::alnum()->length(1, 32)->notEmpty()->noWhitespace(),
    ]);

    // ...
});
```

Respect\Validation is namespaced, but you can make your life easier by importing a
single class into your context:

```php
use Respect\Validation\Validator as v;
```

You can then check if the validation has passed using the `hasPassed()` method:

```php
if (!$validation->hasPassed()) {
    // Validation has not passed
} else {
    // Validation has passed
}
```

If the validation has failed, an array of the validation errors can be accessed 
by calling the `getErrors()` method:

```php
foreach ($validation->getErrors() as $input => $errors) {
    foreach ($errors as $error) {
        echo $error;
    }
}
```

## Useful Links

* [Slim Framework](https://www.slimframework.com)
* [Respect Validation](https://github.com/Respect/Validation)
