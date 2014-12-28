<?php

/**
 * This file is part of fantacalcio-tools.
 *
 * (c) Daniel Londero <daniel.londero@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FantacalcioTools\Fantagazzetta;

use Symfony\Component\DomCrawler\Crawler;

class PointsExtractor
{
    /** @var string */
    protected $_source;

    /** @var array */
    protected $_valueList;

    /**
     * @param string $source
     */
    public function __construct($source)
    {
        $this->_source = file_get_contents($source);
    }

    public function parse()
    {
        $valueList = [];
        $crawler = new Crawler($this->_source);

        $crawler->filter('table > tr')->each(function (Crawler $tr) use (&$valueList) {
            $row = [];
            $tr->filter('td')->each(function (Crawler $td) use (&$valueList, &$row) {
                $row[] = trim($td->text());
            });

            if (count($row) === 16 && $row[0] !== 'Cod.') {
                $valueList[] = $row;
            }
        });

        $this->_valueList = $valueList;
    }

    /**
     * @param string $file
     */
    public function saveToCSV($file)
    {
        $this->parse();

        $handle = fopen($file, 'w');

        $valueList = array_merge($this->getHeaderLine(), $this->_valueList);
        foreach ($valueList as $values) {
            fputcsv($handle, $values);
        }

        fclose($handle);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return $this->_valueList;
    }

    /**
     * @return array[]
     */
    private function getHeaderLine() {
        $headerLine = [];
        $headerLine[] = 'Cod.';
        $headerLine[] = 'Ruolo';
        $headerLine[] = 'Nome';
        $headerLine[] = 'VF';
        $headerLine[] = 'Gol Fatto';
        $headerLine[] = 'Gol Subito';
        $headerLine[] = 'Rigore Parato';
        $headerLine[] = 'Rigore Sbagliato';
        $headerLine[] = 'Rigore Segnato';
        $headerLine[] = 'Autorete';
        $headerLine[] = 'Ammonizione';
        $headerLine[] = 'Espulsione';
        $headerLine[] = 'Assist';
        $headerLine[] = 'Assist Fermo';
        $headerLine[] = 'Gdv';
        $headerLine[] = 'Gdp';

        return array($headerLine);
    }
}
