# Srcoder\Normalize strings library
Use to normalize strings. Implements most basic conversions.
Find a new one, please create a PR :-)

## Dependencies
Requires minimum PHP 7.0+

## Installation
```bash
composer require srcoder/normalize-strings
```

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

## Caching
Normalized strings are cached internally,
second lookup for the same string will be returned from cache. 

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
    new Srcoder\Normalize\Rule\Prepend('Good')
]);

echo $newNormalizer->normalize('Hello');
// "GoodHello"

// Set chain
$newNormalizer->setChain($normalizer);

echo $newNormalizer->normalize('Hello');
// "GoodBye World!"
```

## Add-/prepend-Rule
You can add or prepend rules to a normalizer.

```php
// ... continue

$newNormalizer->prependRule(new Srcoder\Normalize\RegExp('#[A-Z]+#', '+'));

echo $newNormalizer->normalize('Hello');
// "GoodBye+ELLO World!"
```

## Multiple rules at once
Just as in the constructor you can add multiple rules.

* `addRules([Rule, Rule])`
* `prependRules([Rule, Rule])`

## Adding your own rules

Just implement the `Sroder\Normalize\Rule\RuleInterface`

```php
class sha1Rule implements Sroder\Normalize\Rule\RuleInterface
{
    
    public function apply(string $string) : string
    {
        return sha1($strings);    
    }

}

$myNormalizer = new Sroder\Normalize([
    new sha1Rule
]);

echo $myNormalizer->normalize('test');
// "a94a8fe5ccb19ba61c4c0873d391e987982fbbd3"
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

## Trait
To use the normalizer in any of your classes you can use the trait.

```php
class MyAwesomeClass
{
    use \Srcoder\Normalize\NormalizeTrait;
    
    public function __construct()
    {
        $this->normalizerInit();
        
        $this->addNormalizeRules(
                [
                    new Srcoder\Normalize\Rule\Trim('Ho'),
                    new Srcoder\Normalize\Rule\Uppercase,
                ]
        );
    }
}

$myAwesome = new MyAwesomeClass;

echo $myAwesome->normalize('Hello');
// "ELL"
```
## Tests
All code is covered by tests, if you want to create a PR please run these tests too.
