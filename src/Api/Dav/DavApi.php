<?php

namespace Axyr\Nextcloud\Api\Dav;

class DavApi
{
    public function namespaces(): NamespacesEndpoint
    {
        return app(NamespacesEndpoint::class);
    }

    public function files(): FilesEndpoint
    {
        return app(FilesEndpoint::class);
    }

    public function calendars(): CalendarsEndpoint
    {
        return app(CalendarsEndpoint::class);
    }

    public function trashbin(): TrashbinEndpoint
    {
        return app(TrashbinEndpoint::class);
    }
}
