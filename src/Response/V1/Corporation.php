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
 * @property-read string $name
 * @property-read string $name_kana
 * @property-read string $block_lot
 * @property-read string $post_office
 * @property-read int $code_type
 */
class Corporation implements JsonSerializable
{
    /** @var string */
    private $name;
    /** @var string */
    private $name_kana;
    /** @var string */
    private $block_lot;
    /** @var string */
    private $post_office;
    /** @var int */
    private $code_type;

    final public function __construct(
        string $name,
        string $name_kana,
        string $block_lot,
        string $post_office,
        int $code_type
    ) {
        $this->name = $name;
        $this->name_kana = $name_kana;
        $this->block_lot = $block_lot;
        $this->post_office = $post_office;
        $this->code_type = $code_type;
    }

    /**
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->$name;
    }

    /**
     * @return array{
     *     name: string,
     *     name_kana: string,
     *     block_lot: string,
     *     post_office: string,
     *     code_type: int
     * }
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'name_kana' => $this->name_kana,
            'block_lot' => $this->block_lot,
            'post_office' => $this->post_office,
            'code_type' => $this->code_type,
        ];
    }
}
