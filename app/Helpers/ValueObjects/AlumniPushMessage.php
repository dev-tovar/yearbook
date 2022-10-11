<?php

namespace App\Helpers\ValueObjects;


use App\Enums\AlumniPushType;

/**
 * Class AlumniPushMessage
 *
 * @package App\Helpers\ValueObjects
 *
 * @property $message
 * @property $custom
 * @property $image
 * @property $type
 */
class AlumniPushMessage
{
    private $message;
    private $image;
    private $type;
    private $custom;

    /**
     * AlumniPushMessage constructor.
     *
     * @param string      $message
     * @param string      $custom
     * @param string|null $image
     * @param int         $type
     */
    public function __construct(string $message, string $custom, string $image = null, int $type = AlumniPushType::Standart)
    {
        $this->message = $message;
        $this->image = $image;
        $this->type = $type;
        $this->custom = $custom;

    }

    public function __get($value)
    {
        return $this->$value ?? null;
    }

}
