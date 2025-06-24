<?php

namespace Axyr\Nextcloud\Parsers;

class WebDavXmlParser
{
    public static function parse(string $xml): array
    {
        $xmlObject = simplexml_load_string($xml);
        $xmlObject->registerXPathNamespace('d', 'DAV:');
        $xmlObject->registerXPathNamespace('oc', 'http://owncloud.org/ns');
        $xmlObject->registerXPathNamespace('nc', 'http://nextcloud.org/ns');

        $resources = [];

        foreach ($xmlObject->xpath('//d:response') as $response) {
            $resource = [];

            $resource['href'] = urldecode((string)($response->xpath('d:href')[0] ?? ''));

            $propStats = $response->xpath('d:propstat');

            foreach ($propStats as $propStat) {
                $props = $propStat->xpath('d:prop')[0] ?? null;

                if ( ! $props) {
                    continue;
                }

                foreach ($props->children() as $child) {
                    $value = (string)$child;
                    $name = $child->getName();
                    $ns = $child->getNamespaces(true);

                    // Store base property
                    $resource[$name] = $value;

                    // Store fully-qualified property if namespaced (e.g. oc:fileid)
                    foreach ($ns as $prefix => $uri) {
                        $resource["{$prefix}:{$name}"] = $value;
                    }
                }

                // Add virtual flag for collection
                $resource['is_collection'] = isset($props->resourcetype->collection);
            }

            $resources[] = $resource;
        }

        return $resources;
    }
}
