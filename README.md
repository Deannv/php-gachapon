# PHP Simple Gachapon

A wild, basic gachapon system that I highly doubt will be working.

## Installation

Install the package

```bash
composer require deannv/php-gachapon
```

## Basic usage

`note` This package only accept associative array or key value pair data.

1. Simple use case

```php
// item_name => drop_rate_in_percentage
Gacha::from(['a' => 2, 'b' => 10])->pull();
```

or if you want to get more than 1 result

```php
Gacha::from(['a' => 2, 'b' => 10])->pull(2);
```

2. Using object

```php
$data = [
    ["name" => "item1", "drop_rate" => 3],
    ["name" => "item2", "drop_rate" => 5],
    ["name" => "item3", "drop_rate" => 2]
];

Gacha::from($data)->pull();
```

3. Or just using pull

```php
Gacha::pull(2, ['a' => 2, 'b' => 10]);
```

this is the result (array)

```bash
Array
(
    [0] => item2
)
```

that's it!
