<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function all()
    {
        return User::all();
    }

    public function create($data)
    {
        return User::create($data);
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function update($data, $user)
    {
        $user->name = $data['name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->save();

        return $user;
    }

    public function delete($user)
    {
        $user->delete();
    }
}
