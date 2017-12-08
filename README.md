# mrgenis/sat-cadenaoriginal

[![Latest Version](https://img.shields.io/github/release/SergioFloresG/sat-cadenaoriginal.svg?style=flat)](https://github.com/SergioFloresG/sat-cadenaorigianl/releases)
[![Build Status](https://travis-ci.org/SergioFloresG/sat-cadenaoriginal.svg?branch=master&style=for-the-badge)](https://travis-ci.org/SergioFloresG/sat-cadenaoriginal)

Clase para generar la cadena original de un CFDI v3.3

## Instalar
Puedes instalar este paquete via composer.

```bash
composer require mrgenis/sat-cadenaoriginal
```

## Usar

### Xml como texto
Se envia la cadena de texto del CFDI XML 3.3

```php
$xml = <<< EOF
<?xml version="1.0" encoding="utf-8" ?>
<cfdi:Comprobante xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd"
      Version="3.3" Folio="FOL123456" Fecha="2017-05-04T09:36:11"
      FormaPago="01"
      Sello=""
      NoCertificado=""
      Certificado=""
      CondicionesDePago="CondicionesDePago" SubTotal="1000.00" Descuento="100.00" Moneda="MXN"
      TipoCambio="1" Total="900.00" TipoDeComprobante="I" MetodoPago="PUE" LugarExpedicion="72000"
      xmlns:cfdi="http://www.sat.gob.mx/cfd/3">
      
  <cfdi:Emisor Rfc="TEST010204002" Nombre="ETHAN HUNT" RegimenFiscal="601"/>
  <cfdi:Receptor Rfc="TEST010203001" Nombre="JAMES BOND 007" UsoCFDI="G02"/>
  <cfdi:Conceptos>
  ...
EOF;

use MrGenis\Sat\CadenaOriginal33;
$cadena = CadenaOriginal33::cadenaOriginal($xml);
```

### DOMDocument

```php
$dom = new \DOMDocument();
$dom->load('documento.xml');

use MrGenis\Sat\CadenaOriginal33;
$cadena = CadenaOriginal33::cadenaOriginal($dom);
```

### SimpleXml

```php
$dom = simplexml_load_file('documento.xml');

use MrGenis\Sat\CadenaOriginal33;
$cadena = CadenaOriginal33::cadenaOriginal($dom);
```

# Licencia

MIT License (MIT). Ver [archivo de licencia](https://github.com/SergioFloresG/sat-cadenaoriginal/blob/HEAD/LICENSE) para mas información.
