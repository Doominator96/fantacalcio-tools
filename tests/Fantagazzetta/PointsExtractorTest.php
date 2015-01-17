<?php
/**
 * This file is part of fantacalcio-tools.
 *
 * (c) Daniel Londero <daniel.londero@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FantacalcioTools\Tests\Fantagazzetta;

use FantacalcioTools\Fantagazzetta\PointsExtractor;
use org\bovigo\vfs\vfsStream;

class PointsExtractorTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $expectedArray = array_map('str_getcsv', file(__DIR__ . '/../Fixtures/results.csv'));
        unset($expectedArray[0]);
        $expectedArray = array_values($expectedArray);

        $pointsExtractor = new PointsExtractor(__DIR__ . '/../Fixtures/voti.xls');
        $pointsExtractor->parse();

        $this->assertSame($expectedArray, $pointsExtractor->getAsArray());
    }

    public function testParseNoCoach()
    {
        $expectedArray = array_map('str_getcsv', file(__DIR__ . '/../Fixtures/results-nocoach.csv'));
        unset($expectedArray[0]);
        $expectedArray = array_values($expectedArray);

        $pointsExtractor = new PointsExtractor(__DIR__ . '/../Fixtures/voti.xls');
        $pointsExtractor->parse(true);

        $this->assertSame($expectedArray, $pointsExtractor->getAsArray());
    }

    public function testSaveToCSV() {
        vfsStream::setup('home');
        $file = vfsStream::url('home/results.csv');

        $pointsExtractor = new PointsExtractor(__DIR__ . '/../Fixtures/voti.xls');
        $pointsExtractor->saveToCSV($file);

        $this->assertFileEquals(__DIR__ . '/../Fixtures/results.csv', $file);
    }
}
