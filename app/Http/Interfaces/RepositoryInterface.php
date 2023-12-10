<?php

namespace App\Http\Interfaces;

interface RepositoryInterface
{
    public function all();

    public function create($data);

    public function update($data, $id);

    public function destroy($id);

    public function show($id);
}
