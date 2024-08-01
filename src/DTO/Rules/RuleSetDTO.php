<?php


namespace Membergate\DTO\Rules;

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
