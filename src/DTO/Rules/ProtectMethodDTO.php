<?php


namespace Membergate\DTO\Rules;

class ProtectMethodDTO {
    public function __construct(
        public string $method = "redirect",
        public int $value,
    ) {
    }

    static function fromArray(array $arr): ProtectMethodDTO {
        return new ProtectMethodDTO($arr['method'], $arr['value']);
    }

    static function fromObject(object $obj): ProtectMethodDTO {
        return new ProtectMethodDTO($obj->method, $obj->value);
    }
}
