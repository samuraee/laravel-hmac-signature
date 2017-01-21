<?php namespace Tartan\Signature\Guards;

use Tartan\Signature\Signature;

interface Guard
{

    /**
     * Check to ensure the auth parameters
     * satisfy the rule of the guard
     *
     * @param array  $auth
     * @param array  $signature
     * @param string $prefix
     * @return bool
     */
    public function check(array $auth, array $signature, $prefix);
}
