<?php namespace Tartan\Signature\Tests\Guards;

use Tartan\Signature\Guards\CheckVersion;

class CheckVersionTest extends \PHPUnit_Framework_TestCase
{
    /** @var CheckVersionNumber */
    private $guard;

    public function setUp()
    {
        $this->guard = new CheckVersion;
    }

    /** @test */
    public function should_throw_exception_on_missing_version_number()
    {
        $this->setExpectedException('Tartan\Signature\Exceptions\SignatureVersionException');

        $this->guard->check([], ['auth_version' => '4.0.0'], 'auth_');
    }

    /** @test */
    public function should_throw_exception_on_invalid_version_number()
    {
        $this->setExpectedException('Tartan\Signature\Exceptions\SignatureVersionException');

        $this->guard->check(['auth_version' => '1.1'], ['auth_version' => '4.0.0'], 'auth_');
    }

    /** @test */
    public function should_return_true_with_valid_version_number()
    {
        $this->assertTrue($this->guard->check(['auth_version' => '4.0.0'], ['auth_version' => '4.0.0'], 'auth_'));
    }
}
