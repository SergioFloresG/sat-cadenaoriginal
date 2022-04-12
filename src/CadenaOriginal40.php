<?php
/**
 * Created by PhpStorm.
 * User: Sergio Flores Genis
 * Date: 2017-12-07T15:34
 */

namespace MrGenis\Sat;
use XSLTProcessor;

/**
 * Class CadenaOriginal40
 *
 * @package MrGenis\Sat
 */
class CadenaOriginal40
{

    const XSLT_CADENAORIGINAL = 'http://www.sat.gob.mx/sitio_internet/cfd/4/cadenaoriginal_4_0/cadenaoriginal_4_0.xslt';

    /** @var string */
    private static $default_xslt_directory = null;

    /**
     * @param string|\SimpleXMLElement|\DOMDocument $xml
     *
     * @return string
     */
    public static function cadenaOriginal($xml)
    {

        $dom_xml = Tools::buildDomDocumentXml($xml);

        $xslt = static::cadenaoriginal_path('cadenaoriginal_4_0.xslt');
        if (!file_exists($xslt)) {
            Tools::downloadXslt(
                CadenaOriginal40::XSLT_CADENAORIGINAL,
                CadenaOriginal40::cadenaoriginal_path()
            );
        }

        $xslt = static::xslt(static::cadenaoriginal_path('cadenaoriginal_4_0.xslt'));

        return $xslt->transformToXml($dom_xml);
    }

    /**
     * @param string $directory establece el directorio donde se almacena el xlst para generar la cadena origianl
     */
    public static function default_xslt_directory($directory)
    {
        static::$default_xslt_directory = $directory;
    }

    /**
     * @param string $file_xslt
     * @return XSLTProcessor
     */
    private static function xslt($file_xslt)
    {
        static $xslt = null;
        if (!is_null($xslt)) {
            return $xslt;
        }

        return $xslt = Tools::buildXsltProcessor($file_xslt);
    }

    /**
     * @param string $file archivo en el paquete de cadena original
     * @return string
     */
    private static function cadenaoriginal_path($file = '')
    {
        if (null !== static::$default_xslt_directory) {
            $directory = static::$default_xslt_directory;
        } else {
            $directory = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'xslt40';
            if (!file_exists($directory)) {
                mkdir($directory, 0775, true);
            }
        }

        return $directory . ($file ? '/' . $file : '');
    }

}