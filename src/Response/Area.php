<?php

declare(strict_types=1);

namespace zonuexe\Kenall\Response;

use ArrayIterator;
use IteratorAggregate;
use Psr\Http\Message\ResponseInterface;
use function json_decode;

/**
 * Postal Area (郵政区画)
 *
 * @property-read string $jisx0402
 * @property-read string $old_code
 * @property-read string $postal_code
 * @property-read string $prefecture_kana
 * @property-read string $city_kana
 * @property-read string $town_kana
 * @property-read string $town_kana_raw
 * @property-read string $prefecture
 * @property-read string $city
 * @property-read string $town
 * @property-read string $koaza
 * @property-read string $kyoto_street
 * @property-read string $building
 * @property-read string $floor
 * @property-read bool $town_partial
 * @property-read bool $town_addressed_koaza
 * @property-read bool $town_chome
 * @property-read bool $town_multi
 * @property-read string $town_raw
 * @property-read array{name:string, name_kana:string, block_lot:string, post_office:string, code_type:string} $corporation
 */
class Area
{
    /**
     * @var array
     * @phpstan-var array{
     *     jisx0402: string,
     *     old_code: string,
     *     postal_code: string,
     *     prefecture_kana: string,
     *     city_kana: string,
     *     town_kana: string,
     *     town_kana_raw: string,
     *     prefecture: string,
     *     city: string,
     *     town: string,
     *     koaza: string,
     *     kyoto_street: string,
     *     building: string,
     *     floor: string,
     *     town_partial: bool,
     *     town_addressed_koaza: bool,
     *     town_chome: bool,
     *     town_multi: bool,
     *     town_raw: string,
     *     corporation: array{
     *         name: string,
     *         name_kana: string,
     *         block_lot: string,
     *         post_office: string,
     *         code_type: string
     *     }
     * }
     */
    private $data;

    /**
     * @phpstan-param array{
     *     jisx0402: string,
     *     old_code: string,
     *     postal_code: string,
     *     prefecture_kana: string,
     *     city_kana: string,
     *     town_kana: string,
     *     town_kana_raw: string,
     *     prefecture: string,
     *     city: string,
     *     town: string,
     *     koaza: string,
     *     kyoto_street: string,
     *     building: string,
     *     floor: string,
     *     town_partial: bool,
     *     town_addressed_koaza: bool,
     *     town_chome: bool,
     *     town_multi: bool,
     *     town_raw: string,
     *     corporation: array{
     *         name: string,
     *         name_kana: string,
     *         block_lot: string,
     *         post_office: string,
     *         code_type: string
     *     }
     * } $data
     */
    final public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->data[$name];
    }
}
