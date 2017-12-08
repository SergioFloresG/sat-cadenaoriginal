<?php
/**
 * Created by PhpStorm.
 * User: Sergio Flores Genis
 * Date: 2017-12-08T09:50
 */

namespace MrGenis\Sat;


class CadenaTest extends \PHPUnit_Framework_TestCase
{

    public function testCadenaString()
    {
        $xml = file_get_contents(realpath(__DIR__) . '/__barron_xml.xml');
        $cadena = CadenaOriginal33::cadenaOriginal($xml);

        $this->assertNotNull($cadena, "(Xml String) La respuesta es null");
        $this->assertStringStartsWith('||', $cadena, "(Xml String) No inicia con doble pipe");
        $this->assertStringEndsWith('||', $cadena, "(Xml String) No termina con doble pipe");
        echo "(Xml String) Cadena:\n" . $cadena . PHP_EOL . PHP_EOL;
    }

    public function testCadenaDom()
    {
        $dom = new \DOMDocument();
        $dom->load(realpath(__DIR__) . '/__barron_xml.xml');

        $cadena = CadenaOriginal33::cadenaOriginal($dom);

        $this->assertNotNull($cadena, "(Xml DOM) La respuesta es null");
        $this->assertStringStartsWith('||', $cadena, "(Xml DOM) No inicia con doble pipe");
        $this->assertStringEndsWith('||', $cadena, "(Xml DOM) No termina con doble pipe");
        echo "(Xml DOM) Cadena:\n" . $cadena . PHP_EOL . PHP_EOL;
    }

    public function testCadenaSimpleXml()
    {
        $dom = simplexml_load_file(realpath(__DIR__) . '/__barron_xml.xml');

        $cadena = CadenaOriginal33::cadenaOriginal($dom);

        $this->assertNotNull($cadena, "(Xml Simple) La respuesta es null");
        $this->assertStringStartsWith('||', $cadena, "(Xml Simple) No inicia con doble pipe");
        $this->assertStringEndsWith('||', $cadena, "(Xml Simple) No termina con doble pipe");
        echo "(Xml Simple) Cadena:\n" . $cadena . PHP_EOL . PHP_EOL;
    }

}