<?php
namespace Membergate\Configuration;

use Membergate\Settings\Rules;

class RuleEntity {
    private $rulesConfig;
    private $_rules;
    private $_condition; 
    private $_protect_method;
    public $isSet;

    public function __construct(Rules $rules){
        $this->rulesConfig = $rules;
        $this->isSet = false;
    }

    public function init(int $id){
        $this->isSet = true;
        $this->_condition = $this->rulesConfig->get_conditions($id);
        $this->_rules = $this->rulesConfig->get_rules($id);
        $this->_protect_method = $this->rulesConfig->get_protect_method($id);
    }

    public function rules(){
        if(!$this->isSet){
            throw new \Exception("Need To Call init first");
        }
        return $this->_rules; 
    }
    public function condition(){
        if(!$this->isSet){
            throw new \Exception("Need To Call init first");
        }
        return $this->_condition; 
    }
    public function protect_method(){
        if(!$this->isSet){
            throw new \Exception("Need To Call init first");
        }
        return $this->_protect_method; 
    }

}

