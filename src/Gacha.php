<?php

namespace Deannv\PhpGachapon;

use Exception;

class Gacha
{
    public static ?array $data = null;

    /**
     * @return bool wether it's a key value pair data or not, idk
     */
    private function isAssoc(array $array): bool
    {
        return is_array($array) && array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * @param array<mixed, int> $data is used to store an associative array or key value pair data. with the following rule : $key is the item name and the $value is the drop rate for the item in INTEGER %.
     * @return Deannv\PhpGachapon instance.
     */
    public static function from(array $data): static
    {
        self::$data = $data;
        return new static();
    }

    /**
     * @param int $amount how many items that want to be fetched.
     * @return array the result.
     */
    public static function pull(int $amount = 1, array $data = []): array
    {
        if ($data) self::from($data);

        if ($amount > count(self::$data)) throw new Exception("Cannot pull more than available items in array.");

        if (!$amount || !count(self::$data)) return [];

        $normalizedData = [];
        $totalDropRate = 0;

        if ((new self())->isAssoc(self::$data)) {
            foreach (self::$data as $name => $dropRate) {
                $normalizedData[] = ['name' => $name, 'drop_rate' => $dropRate];
                $totalDropRate += $dropRate;
            }
        } else {
            foreach (self::$data as $item) {
                $normalizedData[] = ['name' => $item['name'], 'drop_rate' => $item['drop_rate']];
                $totalDropRate += $item['drop_rate'];
            }
        }

        $result = [];
        for ($i = 0; $i < $amount; $i++) {
            $rand = rand(1, $totalDropRate);
            $currentRate = 0;

            foreach ($normalizedData as $item) {
                $currentRate += $item['drop_rate'];
                if ($rand <= $currentRate) {
                    $result[] = $item['name'];
                    break;
                }
            }
        }

        return $result;
    }
}

$data = [
    ["name" => "item1", "drop_rate" => 3],
    ["name" => "item2", "drop_rate" => 5],
    ["name" => "item3", "drop_rate" => 2]
];

print_r(Gacha::from(['a' => 2, 'b' => 10])->pull());
print_r(Gacha::pull(2, ['a' => 2, 'b' => 10]));
print_r(Gacha::from($data)->pull());
