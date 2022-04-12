<?php
namespace MrGenis\Sat;

class Cadena40Test extends \PHPUnit_Framework_TestCase
{
    public function testCadenaString()
    {
        $xml = file_get_contents(realpath(__DIR__) . '/cfdv40/ejemplo.xml');
        $cadenaO = file_get_contents(realpath(__DIR__).'/cfdv40/ejemplo-cadena.txt');

        $cadena = CadenaOriginal40::cadenaOriginal($xml);
        echo "(Xml String) Cadena:\n" . $cadena . PHP_EOL . PHP_EOL;

        $this->assertNotNull($cadena, "(Xml String) La respuesta es null");
        $this->assertStringStartsWith('||', $cadena, "(Xml String) No inicia con doble pipe");
        $this->assertStringEndsWith('||', $cadena, "(Xml String) No termina con doble pipe");
        $this->assertEquals($cadenaO, $cadena);

    }

    public function testCadenaMinString()
    {
        $xml = file_get_contents(realpath(__DIR__) . '/cfdv40/min.xml');
        $cadenaO = file_get_contents(realpath(__DIR__).'/cfdv40/min-cadena.txt');

        $cadena = CadenaOriginal40::cadenaOriginal($xml);
        echo "(Xml String) Cadena:\n" . $cadena . PHP_EOL . PHP_EOL;

        $this->assertNotNull($cadena, "(Xml String) La respuesta es null");
        $this->assertStringStartsWith('||', $cadena, "(Xml String) No inicia con doble pipe");
        $this->assertStringEndsWith('||', $cadena, "(Xml String) No termina con doble pipe");
        $this->assertEquals($cadenaO, $cadena);

    }

    public function testComplementoPagos20()
    {
        $xml = file_get_contents(realpath(__DIR__) . '/cfdv40/complemento-pagos20.xml');
        $cadenaO = file_get_contents(realpath(__DIR__).'/cfdv40/complemento-pagos20-cadena.txt');

        $cadena = CadenaOriginal40::cadenaOriginal($xml);
        echo "(Xml String) Cadena:\n" . $cadena . PHP_EOL . PHP_EOL;

        $this->assertNotNull($cadena, "(Xml String) La respuesta es null");
        $this->assertStringStartsWith('||', $cadena, "(Xml String) No inicia con doble pipe");
        $this->assertStringEndsWith('||', $cadena, "(Xml String) No termina con doble pipe");
        $this->assertEquals($cadenaO, $cadena);

    }
}