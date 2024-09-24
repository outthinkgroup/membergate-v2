<?php

namespace Membergate\Configuration;

/** 
 * @package Membergate\Configuration 
 *
 * This is a collection of modifiers. This will figure out which one 
 * may apply to the post if any. and will then call is methods when 
 * it has been selected. 
 * Allowing The Strategy Pattern
 **/
class ProtectionModifier {

    /**
     * @var ModifierInterface[] $checks
     **/
    private array $checks;
    private ModifierInterface|null $modifier;
    public function __construct(
        private ProtectBlocks $protectBlocks,
    ) {
        $this->checks = $this->loadChecks();
        $this->modifier = null;
    }

    /** 
     * Checks for a modification and sets it up if found
     *
     * @return bool
     **/
    public function hasMods(): bool {
        global $post;
        if (!$post) return false;

        if ($this->modifier) return true; // we are already setup no need to do it again? or is there

        foreach ($this->checks as $check) {
            if ($check->checkPost($post)) {
                $this->modifier = $check;
                return true;
            }
        }

        return false;
    }

    public function protectEvent(): string {
        return $this->modifier?->onEvent();
    }

    /** @return  ModifierInterface[]*/
    private function loadChecks(): array {
        return [
            $this->protectBlocks,
        ];
    }
}
