<?php

namespace Axyr\Nextcloud\Requests;

class UserCreateRequest
{
    public function __construct(
        public string $userid,
        public string $password,
        public string $displayName,
        public string $email,
        public array $groups = [],
        public array $subadmin = [],
        public string $quota,
        public string $language,
        public ?string $manager = null,
    ) {}

    public function toArray(): array
    {
        return [
            'userid' => $this->userid,
            'password' => $this->password,
            'displayName' => $this->displayName,
            'email' => $this->email,
            'groups' => $this->groups,
            'subadmin' => $this->subadmin,
            'quota' => $this->quota,
            'language' => $this->language,
            'manager' => $this->manager,
        ];
    }
}
