Fantacalcio Tools
=================

[![Build Status](https://travis-ci.org/dlondero/fantacalcio-tools.svg?branch=master)](https://travis-ci.org/dlondero/fantacalcio-tools)

Fantacalcio Tools è una libreria in PHP che raccoglie alcuni strumenti utili per chi gioca a Fantacalcio e magari
amministra qualche lega tra amici.

Strumenti disponibili:

- Convertitore da file voti Fantagazzetta a file csv

Coming soon:

- Scraper classifica serie A da Gazzetta

## Install

Nella tua applicazione crea un file `composer.json`. Nel caso non conoscessi [Composer](https://getcomposer.org/)
ti consiglio di dare un'occhiata a [composer.json Schema](https://getcomposer.org/doc/04-schema.md).

Nella sezione `require` o alternativamente in `require-dev` aggiungi la seguente dipendenza:

```json
"dlondero/fantacalcio-tools": "dev-master"
```

## Usage

Convertire il file dei [voti Fantagazzetta](http://www.fantagazzetta.com/voti-fantagazzetta-serie-A) in un file CSV

```php
use FantacalcioTools\Fantagazzetta\PointsExtractor;

$pointsExtractor = new PointsExtractor('file_voti_fantagazzetta.xls');
$pointsExtractor->saveToCSV('file_voti_convertiti.csv');
```

Convertire lo stesso file dei voti Fantagazzetta in un array per eseguire ulteriori operazioni

```php
use FantacalcioTools\Fantagazzetta\PointsExtractor;

$pointsExtractor = new PointsExtractor('file_voti_fantagazzetta.xls');
$pointsExtractor->parse();
$array = $pointsExtractor->getAsArray();
```