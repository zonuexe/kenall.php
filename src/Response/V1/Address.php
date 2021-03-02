<?php

declare(strict_types=1);

namespace zonuexe\Kenall\Response\V1;

use ArrayIterator;
use IteratorAggregate;
use JsonSerializable;
use Psr\Http\Message\ResponseInterface;
use function json_decode;

/**
 * Postal Address (郵便区画)
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
 * @property-read ?Corporation $corporation
 */
class Address implements JsonSerializable
{
    /** @var string */
    private $jisx0402;
    /** @var string */
    private $old_code;
    /** @var string */
    private $postal_code;
    /** @var string */
    private $prefecture_kana;
    /** @var string */
    private $city_kana;
    /** @var string */
    private $town_kana;
    /** @var string */
    private $town_kana_raw;
    /** @var string */
    private $prefecture;
    /** @var string */
    private $city;
    /** @var string */
    private $town;
    /** @var string */
    private $koaza;
    /** @var string */
    private $kyoto_street;
    /** @var string */
    private $building;
    /** @var string */
    private $floor;
    /** @var bool */
    private $town_partial;
    /** @var bool */
    private $town_addressed_koaza;
    /** @var bool */
    private $town_chome;
    /** @var bool */
    private $town_multi;
    /** @var string */
    private $town_raw;
    /** @var ?Corporation */
    private $corporation;

    final public function __construct(
        string $jisx0402,
        string $old_code,
        string $postal_code,
        string $prefecture_kana,
        string $city_kana,
        string $town_kana,
        string $town_kana_raw,
        string $prefecture,
        string $city,
        string $town,
        string $koaza,
        string $kyoto_street,
        string $building,
        string $floor,
        bool $town_partial,
        bool $town_addressed_koaza,
        bool $town_chome,
        bool $town_multi,
        string $town_raw,
        ?Corporation $corporation
    ) {
        $this->jisx0402 = $jisx0402;
        $this->old_code = $old_code;
        $this->postal_code = $postal_code;
        $this->prefecture_kana = $prefecture_kana;
        $this->city_kana = $city_kana;
        $this->town_kana = $town_kana;
        $this->town_kana_raw = $town_kana_raw;
        $this->prefecture = $prefecture;
        $this->city = $city;
        $this->town = $town;
        $this->koaza = $koaza;
        $this->kyoto_street = $kyoto_street;
        $this->building = $building;
        $this->floor = $floor;
        $this->town_partial = $town_partial;
        $this->town_addressed_koaza = $town_addressed_koaza;
        $this->town_chome = $town_chome;
        $this->town_multi = $town_multi;
        $this->town_raw = $town_raw;
        $this->corporation = $corporation;
    }

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
     *     corporation: ?array{
     *         name: string,
     *         name_kana: string,
     *         block_lot: string,
     *         post_office: string,
     *         code_type: int
     *     }
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new Address(
            $data['jisx0402'],
            $data['old_code'],
            $data['postal_code'],
            $data['prefecture_kana'],
            $data['city_kana'],
            $data['town_kana'],
            $data['town_kana_raw'],
            $data['prefecture'],
            $data['city'],
            $data['town'],
            $data['koaza'],
            $data['kyoto_street'],
            $data['building'],
            $data['floor'],
            $data['town_partial'],
            $data['town_addressed_koaza'],
            $data['town_chome'],
            $data['town_multi'],
            $data['town_raw'],
            $data['corporation'] !== null ? new Corporation(
                $data['corporation']['name'],
                $data['corporation']['name_kana'],
                $data['corporation']['block_lot'],
                $data['corporation']['post_office'],
                $data['corporation']['code_type']
            ) : null
        );
    }

    /**
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->$name;
    }

    /**
     * @return array<string,mixed>
     */
    public function __debugInfo()
    {
        return $this->jsonSerialize();
    }

    /**
     * @return array{
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
     *     corporation: ?Corporation
     * }
     */
    public function jsonSerialize()
    {
        return [
            'jisx0402' => $this->jisx0402,
            'old_code' => $this->old_code,
            'postal_code' => $this->postal_code,
            'prefecture_kana' => $this->prefecture_kana,
            'city_kana' => $this->city_kana,
            'town_kana' => $this->town_kana,
            'town_kana_raw' => $this->town_kana_raw,
            'prefecture' => $this->prefecture,
            'city' => $this->city,
            'town' => $this->town,
            'koaza' => $this->koaza,
            'kyoto_street' => $this->kyoto_street,
            'building' => $this->building,
            'floor' => $this->floor,
            'town_partial' => $this->town_partial,
            'town_addressed_koaza' => $this->town_addressed_koaza,
            'town_chome' => $this->town_chome,
            'town_multi' => $this->town_multi,
            'town_raw' => $this->town_raw,
            'corporation' => $this->corporation,
        ];
    }
}
