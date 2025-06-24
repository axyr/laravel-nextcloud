<?php

namespace Axyr\Nextcloud\Api\Core;

class CoreApi
{
    public function avatar(): AvatarEndpoint
    {
        return app(AvatarEndpoint::class);
    }

    public function guestAvatar(): GuestAvatarEndpoint
    {
        return app(GuestAvatarEndpoint::class);
    }

    public function status(): StatusEndpoint
    {
        return app(StatusEndpoint::class);
    }

    public function appPassword(): AppPasswordEndpoint
    {
        return app(AppPasswordEndpoint::class);
    }

    public function autoComplete(): AutoCompleteEndpoint
    {
        return app(AutoCompleteEndpoint::class);
    }

    public function hoverCard(): HoverCardEndpoint
    {
        return app(HoverCardEndpoint::class);
    }
}
