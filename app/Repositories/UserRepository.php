<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function findAll()
    {
        return User::latest()->get();
    }

    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function findByUsername(string $username): ?User
    {
        return User::where('username', $username)->first();
    }

    public function datatableQuery()
    {

        $query = User::query()
            ->select([
                'id',
                'name',
                'role',
                'created_at',
                'updated_at',
            ]);
        return $query;
    }

    public function update($id, array $data)
    {
        $request = User::find($id);
        $request->update($data);

        return $request;
    }

    public function delete(int $id)
    {
        $query = User::destroy($id);
        return $query;
    }
}
