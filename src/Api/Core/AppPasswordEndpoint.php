<?php

namespace Axyr\Nextcloud\Api\Core;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\ValueObjects\AppPassword;

class AppPasswordEndpoint extends AbstractEndpoint
{
    public function get(array $options = []): AppPassword
    {
        $response = $this->apiGet('/ocs/v2.php/core/apppassword', $options);

        $this->throwExceptionIfNotOk($response);

        return new AppPassword($response->json('ocs.data'));
    }

    public function delete(array $options = []): bool
    {
        $response = $this->apiDelete('/ocs/v2.php/core/apppassword', $options);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function rotate(array $options = []): AppPassword
    {
        $response = $this->apiPost('/ocs/v2.php/core/apppassword', $options);

        $this->throwExceptionIfNotOk($response);

        return new AppPassword($response->json('ocs.data'));
    }

    public function confirm(array $options = []): AppPassword
    {
        $response = $this->apiPost('/ocs/v2.php/core/apppassword/confirm', $options);

        $this->throwExceptionIfNotOk($response);

        return new AppPassword($response->json('ocs.data'));
    }
}
