<?php
/**
 * Class SampleTest
 *
 * @package Membergate
 */

namespace Membergate;

use Membergate\Configuration\ProtectContent;
use Membergate\Configuration\RuleEntity;
use Membergate\Settings\Rules;
use Membergate\Tests\Mock\FunctionMockTrait;
require_once 'tests/Mock/FunctionMockTrait.php';

use WP_UnitTestCase;

/**
 * Sample test case.
 */
class SampleTest extends WP_UnitTestCase {

    use FunctionMockTrait;

    /**
     * A single example test.
     */
    public function test_sample() {
        // Replace this with some actual testing code.
        $get_post_type = $this->getFunctionMock("\Membergate\Plugin", "get_plugin_path");
        $get_post_type->expects($this->once())->willReturn("post");
        
        global $membergate;
    $membergate->get_plugin_path();
        $this->assertTrue($membergate->get_plugin_path() == "post");
    }

    public function test_is_protected() {

        global $membergate;
        $container = $membergate->get_container();
        $get_rules = $this->getFunctionMock(Rules::class, 'get_rules');
        $get_rules->expects($this->once())
            ->willReturn(["asdfasdfd"]);
        $is_single = $this->getFunctionMock("Membergate", "is_singular");
        $is_single->expects($this->once())->willReturn(false);

        // $get_post_type = $this->getFunctionMock("Membergate\Tests", "get_post_type");
        // $get_post_type->expects($this->once())->willReturn("post");

        $post = $this->factory->post->create_and_get([
            "post_type" => "post",
        ]);

        $pc = new ProtectContent($container->get(Rules::class), $container->get(RuleEntity::class));
        $this->assertTrue($pc->is_post_protected($post, 1));
    }
}

