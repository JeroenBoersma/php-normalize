# Srcoder\Normalize library

Use to normalize strings. Implements most basic conversions.
Find a new one, please create a PR :)

## Dependencies

Requires minimum PHP 7.0+

## Rules

* `Srcoder\Normalize\Rule\Append(string $append)`
* `Srcoder\Normalize\Rule\Prepend(string $prepend)`
* `Srcoder\Normalize\Rule\Lowercase`
* `Srcoder\Normalize\Rule\Uppercase`
* `Srcoder\Normalize\Rule\Replace($search, $replace)`
* `Srcoder\Normalize\Rule\Trim(string $chars)`
* `Srcoder\Normalize\Rule\Words(string $delimiters)`
* `Srcoder\Normalize\Rule\RegExp(string $pattern, string $replacement)`
* `Srcoder\Normalize\Rule\Callback(\Closure $closure)`

## Basic usage

This is basic usage of the normlizer.

```php
$normalizer = new Srcoder\Normalize\Normalize([
    new Srcoder\Normalize\Rule\Uppercase,
    new Srcoder\Normalize\Rule\Append(' World'),
    new Srcoder\Normalize\Rule\Append('!')
]);

echo $normalizer->normalize('Hello');
// "HELLO World!"

// Adding rules
$normalizer->addRule(new Srcoder\Normalize\Rule\Replace('HELLO', 'Bye'));

echo $normalizer->normalize('Hello');
// "Bye World!"
```

## Chaining

You can chain normalizer, if it only adds a simple thingy.

```php
// ... continue

$newNormalizer = new Srcoder\Normalize\Normalize([
    new Rule\Prepend('Good')
]);

echo $newNormalizer->normalize('Hello');
// "GoodHello"

// Set chain
$newNormalizer->setChain($normalizer);

echo $newNormalizer->normalize('Hello');
// "GoodBye World!"
```

## Manager (instance)

If you need your normalizers to be available everywhere.

```php
// ... continue

$normalizeManager = new Srcoder\Normalize\Manager();
// or static
$normalizeManager = Srcoder\Normalize\Manager::instance();

// Add already defined normalizer
$normalizeManager->add($normalizer, 'helloworld');

// createAndAdd
$normalizeManager->createAndAdd(
        [ // Rules
            new Srcoder\Normalize\Rule\RegExp("#[_ ]*([A-Z])#", "_\\1"),
            new Srcoder\Normalize\Rule\Trim("_ \t\n\r\0\x0B"),
            new Srcoder\Normalize\Rule\Lowercase()
        ],
        'underscore' // identifier
        //, 'helloworld' // chain
);

// ... snip to somewhere else

echo $normalizeManager->get('helloworld')
        ->normalize('Ibiza!');
// "Bye Ibiza!!"

echo Srcoder\Normalize\Manager::instance()
        ->get('underscore')
        ->normalize('HelloWorld');
// "hello_world"
```
