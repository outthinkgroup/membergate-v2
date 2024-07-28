<?php


namespace Membergate\DTO\Rules;

class ConditionDTO {
    public function __construct(public string $parameter = "cookie", public string $key = "is_member", public string $operator = "notset", public ?string $value = null) {
    }

    static function fromArray(array $arr): ConditionDTO {
        if (isset($arr['value'])) {
            return new ConditionDTO($arr['parameter'], $arr['key'], $arr['operator'], $arr['value']);
        }
        return new ConditionDTO($arr['parameter'], $arr['key'], $arr['operator']);
    }

    static function fromObject(object $obj): ConditionDTO {
        if (property_exists($obj, 'value')) {
            return new ConditionDTO($obj->parameter, $obj->key, $obj->operator, $obj->value);
        }
        return new ConditionDTO($obj->parameter, $obj->key, $obj->operator);
    }
}
