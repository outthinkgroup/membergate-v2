<?php

namespace Membergate\Tests\Mock;

use phpmock\phpunit\PHPMock;

/**
 * Adds mocking methods for mocking PHP functions.
 */
trait FunctionMockTrait {
    use PHPMock;
    /**
     * Get the namespace of the given class.
     */
    private function getNamespace(string $className): string {
        return (new \ReflectionClass($className))->getNamespaceName();
    }
}
