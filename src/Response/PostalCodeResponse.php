<?php

declare(strict_types=1);

namespace zonuexe\Kenall\Response;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use OutOfRangeException;
use Psr\Http\Message\ResponseInterface;
use Traversable;
use function json_decode;

/**
 * Postal Code
 *
 * @template-implements ArrayAccess<int, Area>
 * @template-implements IteratorAggregate<int, Area>
 */
class PostalCodeResponse implements ApiResponseInterface, ArrayAccess, IteratorAggregate
{
    /** @var string */
    private $version;
    /**
     * @var array
     * @phpstan-var array<int, array{
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
     *     town_partial: string,
     *     town_addressed_koaza: string,
     *     town_chome: string,
     *     town_multi: string,
     *     town_raw: string,
     *     corporation: array{
     *         name: string,
     *         name_kana: string,
     *         block_lot: string,
     *         post_office: string,
     *         code_type: string
     *     }
     * }>
     */
    private $data;

    /**
     * @phpstan-param array<int,array{
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
     *     town_partial: string,
     *     town_addressed_koaza: string,
     *     town_chome: string,
     *     town_multi: string,
     *     town_raw: string,
     *     corporation: array{
     *         name: string,
     *         name_kana: string,
     *         block_lot: string,
     *         post_office: string,
     *         code_type: string
     *     }
     * }> $data
     */
    final public function __construct(string $version, array $data)
    {
        $this->version = $version;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->$name;
    }

    /**
     * @return Traversable<int, Area>
     */
    public function getIterator()
    {
        foreach ($this->data as $i => $area) {
            yield $i => new Area($area);
        }
    }

    /**
     * @param int $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param int $offset
     * @return Area
     */
    public function offsetGet($offset)
    {
        return new Area($this->data[$offset]);
    }

    /**
     * @param int $offset
     * @param mixed $value
     * @return never
     */
    public function offsetSet($offset, $value)
    {
        throw new OutOfRangeException('Do not set value');
    }

    /**
     * @param int $offset
     * @return never
     */
    public function offsetUnset($offset)
    {
        throw new OutOfRangeException('Do not set value');
    }

    /**
     * @return static
     */
    public static function fromHttpResponse(ResponseInterface $response)
    {
        /**
         * @phpstan-var array{
         *     version: string,
         *     data: array<int, array{
         *         jisx0402: string,
         *         old_code: string,
         *         postal_code: string,
         *         prefecture_kana: string,
         *         city_kana: string,
         *         town_kana: string,
         *         town_kana_raw: string,
         *         prefecture: string,
         *         city: string,
         *         town: string,
         *         koaza: string,
         *         kyoto_street: string,
         *         building: string,
         *         floor: string,
         *         town_partial: string,
         *         town_addressed_koaza: string,
         *         town_chome: string,
         *         town_multi: string,
         *         town_raw: string,
         *         corporation: array{
         *             name: string,
         *             name_kana: string,
         *             block_lot: string,
         *             post_office: string,
         *             code_type: string
         *         }
         *     }>
         * } $data
         */
        $data = json_decode((string)$response->getBody(), true);

        return new static($data['version'], $data['data']);
    }
}
