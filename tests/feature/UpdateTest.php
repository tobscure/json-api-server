<?php

/*
 * This file is part of tobyz/json-api-server.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tobyz\Tests\JsonApiServer\feature;

use Tobyz\JsonApiServer\JsonApi;
use Tobyz\Tests\JsonApiServer\AbstractTestCase;
use Tobyz\Tests\JsonApiServer\MockAdapter;

class UpdateTest extends AbstractTestCase
{
    /**
     * @var JsonApi
     */
    private $api;

    /**
     * @var MockAdapter
     */
    private $adapter;

    public function setUp(): void
    {
        $this->api = new JsonApi('http://example.com');

        $this->adapter = new MockAdapter();
    }

    public function test_resources_are_not_updatable_by_default()
    {
        $this->markTestIncomplete();
    }

    public function test_resource_updating_can_be_explicitly_enabled()
    {
        $this->markTestIncomplete();
    }

    public function test_resource_updating_can_be_conditionally_enabled()
    {
        $this->markTestIncomplete();
    }

    public function test_resource_updating_can_be_explicitly_disabled()
    {
        $this->markTestIncomplete();
    }

    public function test_resource_updating_can_be_conditionally_disabled()
    {
        $this->markTestIncomplete();
    }

    public function test_updating_a_resource_calls_the_save_adapter_method()
    {
        $this->markTestIncomplete();
    }

    // saver...
    // listeners...
}
