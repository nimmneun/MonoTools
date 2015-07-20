<?php

namespace MonoTools;

use Exception;
use SplFileObject;
use SplTempFileObject;

class MonoCsv
{
    /**
     * The Spl(Temp)FileObject.
     *
     * @var SplTempFileObject
     */
    public $spl;

    /**
     * Maximum allowed input size in bytes.
     *
     * @var int
     */
    private $size;

    /**
     * Load the csv file or create a temporary file, if $input is
     * a string containing the csv data.
     *
     * @param string $input
     * @param int    $size
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape
     * @return MonoCsv
     * @throws Exception
     */
    public static function load($input, $size = null, $delimiter = ";", $enclosure = "\"", $escape = "\\")
    {
        $csv = new self;

        if (is_file($input)) {
            $csv->spl = new SplFileObject($input);
        } else {
            $csv->setMaxInputSize($size);
            $csv->validateMaxInputSize($input);
            $csv->spl = new SplTempFileObject($csv->size);
            $csv->spl->fwrite($input);
            $csv->spl->rewind();
        }

        $csv->spl->setCsvControl($delimiter, $enclosure, $escape);

        return $csv;
    }

    /**
     * Return next row or false, if we're at the EOF.
     *
     * @return array|bool
     */
    public function next()
    {
        return (null === $row = $this->spl->fgetcsv()) ? false : $row;
    }

    /**
     * Return specified row or false if it's past the EOF.
     *
     * @param int $int
     * @return array|bool
     */
    public function row($int)
    {
        $this->rewind()->skip($int-1);

        return (null === $row = $this->spl->fgetcsv()) ? false : $row;
    }

    /**
     * Skip the next [n] rows (not necessarily lines!).
     *
     * @param int $int
     * @return MonoCsv
     */
    public function skip($int)
    {
        for ($i = 0; $i < $int; $i++) {
            if (false === $this->spl->fgetcsv()) {
                break;
            }
        }

        return $this;
    }

    /**
     * Reset the file pointer.
     *
     * @return MonoCsv
     */
    public function rewind()
    {
        $this->spl->rewind();

        return $this;
    }

    /**
     * Return current line number with 1 beeing the frist.
     *
     * @return int
     */
    public function line()
    {
        return $this->spl->key()+1;
    }

    /**
     * Make sure the input string does not exceed size limit.
     *
     * @param $input
     * @return int
     * @throws Exception
     */
    private function validateMaxInputSize($input)
    {
        if (strlen($input) > $this->size) {
            throw new Exception(sprintf('Input string size exceeds allowance of %.2f megabytes', $this->size/1024/1024));
        }
    }

    /**
     * Set maximum allowed input size to specified size in bytes.
     * Set to 33% of php's memory limit if not specified.
     *
     * @param int $size
     */
    private function setMaxInputSize($size)
    {
        if (null !== $size) {
            $this->size = $size;
        } else {
            $maxBytes = 128*1024*1024;

            if (preg_match('/([0-9]+)([mMgG])/', @ini_get('memory_limit'), $m)) {
                $maxBytes = (stristr($m[2], 'm')) ? 1024*1024*$m[1] : 1024*1024*1024*$m[1];
            }

            $this->size = $maxBytes * 0.33;
        }
    }
}

