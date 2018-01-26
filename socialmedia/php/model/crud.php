<?php
interface crud {
    public function create(array $data);
    public function read($id);
    public function update(array $data);
    public function delete(array $data);
}