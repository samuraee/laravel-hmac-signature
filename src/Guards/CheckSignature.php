<?php namespace Tartan\Signature\Guards;

use Tartan\Signature\Exceptions\SignatureSignatureException;

class CheckSignature implements Guard
{

    /**
     * Check to ensure the auth parameters
     * satisfy the rule of the guard
     *
     * @param array  $auth
     * @param array  $signature
     * @param string $prefix
     * @throws SignatureSignatureException
     * @return bool
     */
    public function check(array $auth, array $signature, $prefix)
    {
        if (! isset($auth[$prefix . 'signature'])) {
            throw new SignatureSignatureException('The signature has not been set');
        }

        if ($auth[$prefix . 'signature'] !== $signature[$prefix . 'signature']) {
            $message = 'The signature is not valid.';
            // add correct signature during
            if (config('app.debug') === true) {
                $message .= ' correct signature is ' . $signature[$prefix . 'signature'];
            }
            throw new SignatureSignatureException($message);
        }

        return true;
    }
}
