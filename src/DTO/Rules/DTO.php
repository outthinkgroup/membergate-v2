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


class RuleSetDTO {
    public function __construct(public array $sets = []) {
    }

    /**
     * @param array<array> $set 
     * @return RuleSetDTO
     */
    static function fromArray(array $set = []): RuleSetDTO {
        return new RuleSetDTO(array_map(fn(array $ruleArr) => RuleDTO::fromArray($ruleArr), $set));
    }

    /**
     * @param array<object> $set 
     * @return RuleSetDTO
     */
    static function fromObject(array $set = []): RuleSetDTO {
        return new RuleSetDTO(array_map(fn(object $ruleArr) => RuleDTO::fromObject($ruleArr), $set));
    }
}

