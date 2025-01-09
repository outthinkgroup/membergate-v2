<?php

namespace Membergate\Configuration;

use Exception;
use Membergate\DTO\Rules\ConditionDTO;
use Membergate\DTO\Rules\ProtectMethodDTO;
use Membergate\Settings\Rules;
use Membergate\DTO\Rules\RuleSetDTO;

/** 
 * 
 **/
class RuleEntity {
    private Rules $rulesConfig;
    public bool $isSet;
    /** 
     * @var array<array<RuleSetDTO>>|array<RuleSetDTO> $_rules
     **/
    private array $_rules;
    private ConditionDTO $_condition;
    private ProtectMethodDTO $_protect_method;
    private bool $_allowLoggedIn;

    public function __construct(Rules $rules) {
        $this->rulesConfig = $rules;
        $this->isSet = false;
    }

    public function init(int $id):void {
        $this->isSet = true;
        $this->_condition = $this->rulesConfig->get_condition_by_id($id);
        $this->_rules = $this->rulesConfig->get_rules($id);
        $this->_protect_method = $this->rulesConfig->get_protect_method($id);
        $this->_allowLoggedIn = $this->rulesConfig->get_allow_logged_in_users($id);
    }

    /**
     * @return array<RuleSetDTO|array<RuleSetDTO>>
     * @throws Exception
     */
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

    /**
     * @return ProtectMethodDTO
     * @throws Exception
     */
    public function protect_method() {
        if (!$this->isSet) {
            throw new \Exception("Need To Call init first");
        }
        return $this->_protect_method;
    }

    /**
     * @return bool
     * @throws Exception 
     */
    public function allowLoggedInUsers():bool{
        if (!$this->isSet) {
            throw new \Exception("Need To Call init first");
        }
        return $this->_allowLoggedIn;
    }
}
