<?php

namespace Axyr\Nextcloud\Api\V2\Core;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\ValueObjects\AppPassword;

class AppPasswordEndpoint extends AbstractEndpoint
{
    public function get(array $options = []): AppPassword
    {
        $response = $this->http->get('/ocs/v2.php/core/apppassword', $options);

        $this->throwExceptionIfNotOk($response);

        return new AppPassword($response->json('ocs.data'));
    }

    public function delete(array $options = []): bool
    {
        $response = $this->http->delete('/ocs/v2.php/core/apppassword', $options);

        $this->throwExceptionIfNotOk($response);

        return true;
    }

    public function rotate(array $options = []): AppPassword
    {
        $response = $this->http->post('/ocs/v2.php/core/apppassword', $options);

        $this->throwExceptionIfNotOk($response);

        return new AppPassword($response->json('ocs.data'));
    }

    public function confirm(array $options = []): AppPassword
    {
        $response = $this->http->post('/ocs/v2.php/core/apppassword/confirm', $options);

        $this->throwExceptionIfNotOk($response);

        return new AppPassword($response->json('ocs.data'));
    }
}
