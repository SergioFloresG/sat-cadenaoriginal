<?php

namespace MrGenis\Sat;

use DOMDocument;
use SimpleXMLElement;
use XSLTProcessor;

final class Tools
{

    /**
     * @param string|SimpleXMLElement|DOMDocument $xml
     * @return DOMDocument
     */
    public static function buildDomDocumentXml($xml, $version='1.0', $encoding='UTF-8'){
        $dom_xml = new DOMDocument();
        if ($xml instanceof DOMDocument) {
            $dom_xml = $xml;
        }
        else if ($xml instanceof SimpleXMLElement) {
            $dom_xml->loadXML($xml->asXML());
        }
        else if (file_exists($xml)) {
            $dom_xml->load($xml);
        }
        else {
            $dom_xml->loadXML($xml);
        }

        return $dom_xml;
    }

    /**
     * @param string $documentPath
     * @return XSLTProcessor
     */
    public static function buildXsltProcessor($documentPath){
        $dom = Tools::buildDomDocumentXml($documentPath);
        $dom->documentURI = $documentPath;
        $dom->resolveExternals=true;
        $dom->preserveWhiteSpace=true;

        $xslt = new XSLTProcessor();
        $xslt->importStylesheet($dom);
        return $xslt;
    }

    /**
     * @param string $xsltUrl URL to download the XSLT from
     * @param string $destinationDirectory Directory where the files that make up the XSLT are stored.
     * @return string Path to local XSLT
     */
    public static function downloadXslt($xsltUrl, $destinationDirectory)
    {
        $filename = basename($xsltUrl);
        $xsltPath = $destinationDirectory . DIRECTORY_SEPARATOR . $filename;
        $xsltStr = file_get_contents($xsltUrl);
        $xsltStr = Tools::replaceXMLVersion($xsltStr);

        if (preg_match_all("/href=\"(.+)\"/i", $xsltStr, $matches, PREG_PATTERN_ORDER)) {
            foreach ($matches[1] as $link) {
                $bname = basename($link);
                $content = file_get_contents($link);
                $content = Tools::replaceXMLVersion($content);
                file_put_contents($destinationDirectory . DIRECTORY_SEPARATOR . $bname, $content);
                $xsltStr = str_replace($link, './' . $bname, $xsltStr);
            }
        }

        file_put_contents($xsltPath, $xsltStr);
        return $xsltPath;
    }

    /**
     * @param string $xml Original XML
     * @return string XML Result
     */
    protected static function replaceXMLVersion($xml)
    {
        return str_replace('version="2.0"', 'version="1.0"', $xml);
    }

}