<?php
namespace taskForce\businessLogic;

use taskForce\businessLogic\Exceptions\SourceFileException;
use taskForce\businessLogic\Exceptions\FileFormatException;
use \SplFileObject;

class DataConverter
{
    private  $filename;
    private  $columns;
    private  $fileObject;

    private $result = [];
    private $error = null;

    public function __construct(string $filename, array $columns)
    {
        $this->filename = $filename;
        $this->columns = $columns;
    }

    public function import():void
    {
        if (!$this->validateColumns($this->columns)) {
            throw new FileFormatException("Заданы неверные заголовки столбцов");
        }

        if (!file_exists($this->filename)) {
            throw new SourceFileException("Файл не существует");
        }

        try {
            $this->fileObject = new SplFileObject($this->filename);
        }
        catch (RuntimeException $exception) {
            throw new SourceFileException("Не удалось открыть файл на чтение");
        }

        $header_data = $this->getHeaderData();

        if ($header_data !== $this->columns) {
            throw new FileFormatException("Исходный файл не содержит необходимых столбцов");
        }

        foreach ($this->getNextLine() as $line) {
            $this->result[] = $line;
        }
    }

    public function getData():array {
        return $this->result;
    }

    private function getHeaderData():?array {
        $this->fileObject->rewind();
        $data = $this->fileObject->fgetcsv();

        return $data;
    }

    private function getNextLine():?iterable {
        $result = null;

        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }

        return $result;
    }

    private function validateColumns(array $columns):bool
    {
        $result = true;

        if (count($columns)) {
            foreach ($columns as $column) {
                if (!is_string($column)) {
                    $result = false;
                }
            }
        }
        else {
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
            if ($values !== []) {
                foreach ($this->getHeaderData() as $key) {
                    $queryKey[] = '`' . $key . '`';
                }
                foreach ($values as $value) {
                    $queryValues[] = '"' . $value . '"';
                }
                $sqlArray[] = $sqlQuery . ' (' . implode(', ', $queryKey) . ') VALUE ' .
                    '(' . implode(', ', $queryValues) . ');' . PHP_EOL;
                $queryKey = [];
                $queryValues = [];
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

