<?php namespace Tartan\Signature\Tests\Guards;

use Tartan\Signature\Guards\CheckKey;

class CheckKeyTest extends \PHPUnit_Framework_TestCase
{
    /** @var CheckVersionNumber */
    private $guard;

    public function setUp()
    {
        $this->guard = new CheckKey;
    }

    /** @test */
    public function should_throw_exception_on_missing_key()
    {
        $this->setExpectedException('Tartan\Signature\Exceptions\SignatureKeyException');

        $this->guard->check([], ['auth_key' => 'abc123'], 'auth_');
    }

    /** @test */
    public function should_throw_exception_on_invalid_key()
    {
        $this->setExpectedException('Tartan\Signature\Exceptions\SignatureKeyException');

        $this->guard->check(['auth_key' => 'edf456'], ['auth_key' => 'abc123'], 'auth_');
    }

    /** @test */
    public function should_return_true_with_valid_key()
    {
        $this->assertTrue($this->guard->check(
            ['auth_key' => 'abc123'], ['auth_key' => 'abc123'], 'auth_'
        ));
    }
}
