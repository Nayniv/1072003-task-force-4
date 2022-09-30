<?php

namespace taskForce\businessLogic;

use taskForce\businessLogic\Exceptions\SourceFileException;
use taskForce\businessLogic\Exceptions\FileFormatException;
use SplFileObject;

class DataConverter
{
    private $filename;
    private $columns;
    private $fp;
    private $result = [];

    public function __construct($filename, $columns)
    {
        $this->filename = $filename;
        $this->columns = $columns;
    }

    public function import()
    {
        if (!$this->validateColumns($this->columns)) {
            throw new FileFormatException("Заданы неверные заголовки столбцов");
        }

        if (!file_exists($this->filename)) {
            throw new SourceFileException("Файл не существует");
        }

        $this->fp = fopen($this->filename, 'r');

        if (!$this->fp) {
            throw new SourceFileException("Не удалось открыть файл на чтение");
        }

        $header_data = $this->getHeaderData();
        if ($header_data !== $this->columns) {
            throw new FileFormatException("Исходный файл не содержит необходимых столбцов");
        }

        while ($line = $this->getNextLine()) {
            $this->result[] = $line;
        }
    }

    public function getData()
    {
        return $this->result;
    }

    private function getHeaderData()
    {
        rewind($this->fp);

        return fgetcsv($this->fp);
    }

    private function getNextLine()
    {
        $result = false;
        if (!feof($this->fp)) {
            $result = fgetcsv($this->fp);
        }

        return $result;
    }

    private function validateColumns($columns)
    {
        $result = true;

        if (count($columns)) {
            foreach ($columns as $column) {
                if (!is_string($column)) {
                    $result = false;
                }
            }
        } else {
            $result = false;
        }

        return $result;
    }

    private function dataIntoSql(): void
    {
        $tableName = basename($this->filename, '.csv');
        $sqlFileName = 'data/' . $tableName . '.sql';
        $sqlQuery = 'INSERT INTO ' . $tableName;
        $sqlFile = new SplFileObject($sqlFileName, 'w');
        $sqlArray = [];


        foreach ($this->getData() as $values) {
            $queryKey = [];
            $queryValues = [];
            if ($values !== []) {
                foreach ($this->getHeaderData() as $key) {
                    $queryKey[] = '`' . $key . '`';
                }
                foreach ($values as $value) {
                    $queryValues[] = '"' . $value . '"';
                }
                $sqlArray[] = $sqlQuery . ' (' . implode(', ', $queryKey) . ') VALUE ' .
                    '(' . implode(', ', $queryValues) . ');' . PHP_EOL;
            }
        }

        foreach ($sqlArray as $query) {
            $sqlFile->fwrite($query);
        }
    }

    public function convertSql()
    {
        $this->import();
        $this->dataIntoSql();
    }
}
