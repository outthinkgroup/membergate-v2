<?php

namespace Membergate\DTO\Rules;

class RuleDTO {
    public function __construct(
        public string $parameter = "post_type",
        public string $operator = 'is',
        public string $value = 'post',
    ) {
    }

    static function fromArray(array $arr): RuleDTO {
        return new RuleDTO($arr['parameter'], $arr['operator'], $arr['value']);
    }

    static function fromObject(object $obj): RuleDTO {
        return new RuleDTO($obj->parameter, $obj->operator, $obj->value);
    }
}
