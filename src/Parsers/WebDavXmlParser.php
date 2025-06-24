<?php

namespace Axyr\Nextcloud\Parsers;

use DOMDocument;

class WebDavXmlParser
{
    public static function parse(string $xml): array
    {
        libxml_use_internal_errors(true);

        $doc = new DOMDocument();
        $success = $doc->loadXML(trim($xml));

        if ( ! $success) {
            $error = libxml_get_last_error();
            libxml_clear_errors();
            return [['error' => 'Invalid XML: ' . ($error->message ?? 'Unknown error')]];
        }

        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('d', 'DAV:');
        $xpath->registerNamespace('oc', 'http://owncloud.org/ns');
        $xpath->registerNamespace('nc', 'http://nextcloud.org/ns');

        $resources = [];

        foreach ($xpath->query('//d:response') as $responseNode) {
            $resource = [];

            $hrefNode = $xpath->query('d:href', $responseNode)->item(0);
            $resource['href'] = urldecode($hrefNode?->nodeValue ?? '');

            foreach ($xpath->query('d:propstat', $responseNode) as $propstatNode) {
                $propNode = $xpath->query('d:prop', $propstatNode)->item(0);
                if ( ! $propNode) {
                    continue;
                }

                foreach ($propNode->childNodes as $prop) {
                    if ($prop->nodeType !== XML_ELEMENT_NODE) {
                        continue;
                    }

                    $prefix = $prop->prefix;
                    $name = $prop->localName;
                    $value = $prop->nodeValue ?? '';

                    $resource[$name] = $value;

                    if ($prefix) {
                        $resource["{$prefix}:{$name}"] = $value;
                    }

                    if ($name === 'resourcetype') {
                        foreach ($prop->childNodes as $child) {
                            if ($child->localName === 'collection') {
                                $resource['is_collection'] = true;
                                break;
                            }
                        }
                    }
                }
            }

            $resources[] = $resource;
        }

        return $resources;
    }

    public static function parseErrorMessage(string $xml): string
    {
        $doc = new DOMDocument();
        $success = $doc->loadXML(trim($xml));

        if ( ! $success) {
            return 'Invalid XML: ' . ($error->message ?? 'Unknown error');
        }

        $messageElements = $doc->getElementsByTagNameNS('http://sabredav.org/ns', 'message');

        if ($messageElements->length > 0) {
            return $messageElements->item(0)->nodeValue;
        }

        return 'Unknown WebDAV error';
    }
}
