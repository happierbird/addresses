<?php
namespace CoolBlue\Model;

interface RepositoryManagerInterface {
    public function read($row);
    public function create($newRow);
    public function delete($row);
    public function update($oldRow, $newRow);
}