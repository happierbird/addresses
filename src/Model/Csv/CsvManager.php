<?php
namespace CoolBlue\Model\Csv;

use CoolBlue\Model\RepositoryManagerInterface;
use InvalidArgumentException;
use Exception;

class CsvManager implements RepositoryManagerInterface
{
    private $pathToCSV = null;

    public function __construct($pathToCsvFile)
    {
        if (empty($pathToCsvFile) || !is_readable($pathToCsvFile)) {
            throw new InvalidArgumentException('Empty or not readable path: ' . $pathToCsvFile);
        }

        $this->pathToCSV = $pathToCsvFile;
    }

    public function read($lineNumber)
    {
        $fh = fopen($this->pathToCSV, 'r');
        $i = 0;
        $line = false;
        while ($line = fgets($fh)) {
            if ($i == $lineNumber) {
               break;
            }
            $i++;
        }
        fclose($fh);

        return $line ? trim($line) : false;
    }

    public function update($oldLine, $newLine)
    {
        // contains danger when dealing with big files,
        // but I do not want to go into rocket science here, just primitive update
        try {
            $content = file_get_contents($this->pathToCSV);
            $content = str_replace($oldLine, $newLine, $content);
            file_put_contents($this->pathToCSV, $content);
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }

    public function create($newLine)
    {
        try {
            $fh = fopen($this->pathToCSV, 'a');
            fputs($fh, $newLine);
            fclose($fh);
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }

    public function delete($oldLine)
    {
        return $this->update($oldLine, "\r\n");
    }
}