<?php

namespace Membergate\Settings;

class Rules {
    public $editor;
    public function __construct(RuleEditor $editor) {
        $this->editor = $editor;
    }
    public function get_rules() {
        return [ // RulesSets[]
            [ // RuleSet
                [ // RuleGroup
                    [ // Rule
                        'parameter' => 'page_template',
                        'operator'  => 'is',
                        'value'     => 'product-search-results',
                    ]
                ]
            ]
        ];
    }
}
