<?php

namespace MonoTools;

class MonoCsvTest extends \PHPUnit_Framework_TestCase
{
    public function testNext()
    {
        $csv = \MonoTools\MonoCsv::load('some;funny;string', null, ';');

        $this->assertEquals(array('some','funny','string'), $csv->next());
    }

    public function testSkip()
    {
        $csv = \MonoTools\MonoCsv::load(__DIR__.'/100.csv', null, ';');

        $this->assertEquals(
            array('10','Tucker','Velasquez','1968-02-22','Sturtevant Street 618','90305','Inglewood'),
            $csv->skip(10)->next()
        );
    }

    public function testLine()
    {
        $csv = \MonoTools\MonoCsv::load(file_get_contents(__DIR__.'/100.csv'), null, ';');
        $csv->skip(10);

        $this->assertEquals(10, $csv->line());
    }

    public function testRow()
    {
        $csv = \MonoTools\MonoCsv::load(__DIR__.'/100.csv', null, ';');
        $row = $csv->row(6);

        $this->assertEquals('San Francisco', $row[6]);
    }

    public function testRewind()
    {
        $csv = \MonoTools\MonoCsv::load(file_get_contents(__DIR__.'/100.csv'), null, ';');
        $csv->skip(123);
        $csv->rewind();

        $this->assertEquals(1, $csv->line());
    }
    
    public function testException()
    {
        $content = file_get_contents(__DIR__.'/100.csv');

        for ($i = 1; $i <= 11; $i++)
        {
            $content .= $content;
        }
        $this->setExpectedException('Exception');

        $csv = \MonoTools\MonoCsv::load($content, 8*1024*1024, ';');
    }
}
