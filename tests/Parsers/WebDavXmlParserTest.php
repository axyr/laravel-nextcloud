<?php

namespace Axyr\Nextcloud\Tests\Parsers;

use Axyr\Nextcloud\Parsers\WebDavXmlParser;
use Axyr\Nextcloud\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class WebDavXmlParserTest extends TestCase
{
    #[DataProvider('dataParseErrorMessage')]
    public function testParseErrorMessage(string $fixture, string $expectedMessage): void
    {
        $content = $this->fixtureFileContent($fixture);
     
        $this->assertEquals($expectedMessage, WebDavXmlParser::parseErrorMessage($content));
    }

    public static function dataParseErrorMessage(): array
    {
        return [
            [
                'fixture' => 'fixtures/dav/parent-node-does-not-exists.xml',
                'expectedMessage' => 'Parent node does not exist',
            ],
            [
                'fixture' => 'fixtures/dav/resource-allready-exists.xml',
                'expectedMessage' => 'The resource you tried to create already exists',
            ],
        ];
    }
}
