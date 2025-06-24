<?php

namespace Axyr\Nextcloud\Api\Apps;

use Axyr\Nextcloud\Api\AbstractEndpoint;
use Axyr\Nextcloud\ValueObjects\UserStatus;
use Illuminate\Support\Collection;

class UserStatusEndpoint extends AbstractEndpoint
{
    public function get(array $options = []): UserStatus
    {
        $response = $this->apiGet('/ocs/v2.php/apps/user_status/api/v1/user_status', $options);

        $this->throwExceptionIfNotOk($response);

        return new UserStatus($response->json('ocs.data'));
    }

    public function setStatusType(string $statusType): UserStatus
    {
        $response = $this->apiPut('/ocs/v2.php/apps/user_status/api/v1/user_status/status', [
            'statusType' => $statusType,
        ]);

        $this->throwExceptionIfNotOk($response);

        return new UserStatus($response->json('ocs.data'));
    }

    public function setCustomMessage(?string $message = null, ?string $icon = null, ?int $clearAt = null): UserStatus
    {
        $payload = array_filter([
            'message' => $message,
            'statusIcon' => $icon,
            'clearAt' => $clearAt,
        ], fn($v) => ! is_null($v));

        $response = $this->apiPut('/ocs/v2.php/apps/user_status/api/v1/user_status/message/custom', $payload);

        $this->throwExceptionIfNotOk($response);

        return new UserStatus($response->json('ocs.data'));
    }

    public function setPredefinedMessage(string $messageId, ?int $clearAt = null): UserStatus
    {
        $response = $this->apiPut('/ocs/v2.php/apps/user_status/api/v1/user_status/message/predefined', [
            'messageId' => $messageId,
            'clearAt' => $clearAt,
        ]);

        $this->throwExceptionIfNotOk($response);

        return new UserStatus($response->json('ocs.data'));
    }

    public function clearMessage(): void
    {
        $response = $this->apiDelete('/ocs/v2.php/apps/user_status/api/v1/user_status/message');

        $this->throwExceptionIfNotOk($response);
    }

    public function heartbeat(string $status): UserStatus
    {
        $response = $this->apiPut('/ocs/v2.php/apps/user_status/api/v1/heartbeat', [
            'status' => $status,
        ]);

        $this->throwExceptionIfNotOk($response);

        return new UserStatus($response->json('ocs.data'));
    }

    public function getStatuses(array $options = []): Collection
    {
        $response = $this->apiGet('/ocs/v2.php/apps/user_status/api/v1/statuses', $options);

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data')->mapInto(UserStatus::class);
    }

    public function getStatus(string $userId): UserStatus
    {
        $response = $this->apiGet("/ocs/v2.php/apps/user_status/api/v1/statuses/{$userId}");

        $this->throwExceptionIfNotOk($response);

        return new UserStatus($response->json('ocs.data'));
    }

    public function revert(string $messageId): UserStatus
    {
        $response = $this->apiDelete("/ocs/v2.php/apps/user_status/api/v1/user_status/revert/{$messageId}");

        $this->throwExceptionIfNotOk($response);

        return new UserStatus($response->json('ocs.data'));
    }

    public function getPredefinedStatuses(): Collection
    {
        $response = $this->apiGet('/ocs/v2.php/apps/user_status/api/v1/predefined_statuses');

        $this->throwExceptionIfNotOk($response);

        return $response->collect('ocs.data')->mapInto(UserStatus::class);
    }
}
