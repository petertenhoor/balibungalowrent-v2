<?php

// File generated from our OpenAPI spec
namespace MPHB\Stripe\Service;

class SetupAttemptService extends \MPHB\Stripe\Service\AbstractService
{
    /**
     * Returns a list of SetupAttempts that associate with a provided SetupIntent.
     *
     * @param null|array $params
     * @param null|array|\Stripe\Util\RequestOptions $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Collection<\Stripe\SetupAttempt>
     */
    public function all($params = null, $opts = null)
    {
        return $this->requestCollection('get', '/v1/setup_attempts', $params, $opts);
    }
}
