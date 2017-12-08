<?php
/**
 * Created by PhpStorm.
 * User: Sergio Flores Genis
 * Date: 2017-12-07T15:34
 */

class CadenaOriginal33
{

    private static $XSLT_CADENAORIGINAL = 'http://www.sat.gob.mx/sitio_internet/cfd/3/cadenaoriginal_3_3/cadenaoriginal_3_3.xslt';

    /** @var string */
    private static $default_xslt_directory = null;

    /**
     * @param string|\SimpleXMLElement|\DOMDocument $xml
     *
     * @return string
     */
    public static function cadenaOriginal($xml)
    {

        $dom_xml = new \DOMDocument();
        if ($xml instanceof \DOMDocument) {
            $dom_xml = $xml;
        }
        else if ($xml instanceof \SimpleXMLElement) {
            $dom_xml->loadXML($xml->asXML());
        }
        else if (file_exists($xml)) {
            $dom_xml->load($xml);
        }
        else {
            $dom_xml->loadXML($xml);
        }

        $xslt = static::cadenaoriginal_path('cadenaoriginal_3_3.xslt');
        if (!file_exists($xslt)) static::download();

        /** @var \XSLTProcessor $xslt */
        $xslt = (function ($file_xslt) {
            static $xslt = null;
            if (!is_null($xslt)) return $xslt;

            $xslt_str = file_get_contents($file_xslt);
            $dom = new \DOMDocument('1.0', 'UTF-8');
            $dom->loadXML($xslt_str);
            $dom->documentURI = $file_xslt;
            $dom->resolveExternals = true;
            $dom->preserveWhiteSpace = true;
            //$xslt_xml = simplexml_load_string($xslt_str);

            $xslt = new \XSLTProcessor();
            $xslt->importStylesheet($dom);
            return $xslt;
        })();


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
     * @param string $file archivo en el paquete de cadena original
     *
     * @return string
     */
    private static function cadenaoriginal_path($file = '')
    {
        if (null !== static::$default_xslt_directory) {
            $directory = static::$default_xslt_directory;
        }
        else {
            $directory = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'xslt33';
            if (!file_exists($directory)) mkdir($directory, 0775, true);
        }

        return $directory . ($file ? '/' . $file : '');
    }

    private static function download()
    {
        $filename = basename(static::$XSLT_CADENAORIGINAL);
        $xslt_str = file_get_contents(static::$XSLT_CADENAORIGINAL);
        $xslt_str = str_replace("version=\"2.0\"", "version=\"1.0\"", $xslt_str);

        if (preg_match_all("/href=\"(.+)\"/i", $xslt_str, $matches, PREG_PATTERN_ORDER)) {
            foreach ($matches[1] as $link) {
                $bname = basename($link);
                $content = file_get_contents($link);
                $content = str_replace("version=\"2.0\"", "version=\"1.0\"", $content);
                file_put_contents(static::cadenaoriginal_path($bname), $content);

                $xslt_str = str_replace($link, './' . $bname, $xslt_str);
            }
        }

        file_put_contents(static::cadenaoriginal_path($filename), $xslt_str);
    }
}