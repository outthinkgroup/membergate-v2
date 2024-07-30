<?php

namespace Membergate\Configuration;

use Membergate\DTO\Rules\ConditionDTO;
use Membergate\Settings\Rules;

/** 
 * 
 **/
class RuleEntity {
    private Rules $rulesConfig;
    public bool $isSet;
    private $_rules;
    private ConditionDTO $_condition;
    private $_protect_method;

    public function __construct(Rules $rules) {
        $this->rulesConfig = $rules;
        $this->isSet = false;
    }

    public function init(int $id):void {
        $this->isSet = true;
        $this->_condition = $this->rulesConfig->get_condition_by_id($id);
        $this->_rules = $this->rulesConfig->get_rules($id);
        $this->_protect_method = $this->rulesConfig->get_protect_method($id);
    }

    public function rules() {
        if (!$this->isSet) {
            throw new \Exception("Need To Call init first");
        }
        return $this->_rules;
    }
    public function condition(): \Membergate\DTO\Rules\ConditionDTO {
        if (!$this->isSet) {
            throw new \Exception("Need To Call init first");
        }
        return $this->_condition;
    }
    public function protect_method() {
        if (!$this->isSet) {
            throw new \Exception("Need To Call init first");
        }
        return $this->_protect_method;
    }
}
