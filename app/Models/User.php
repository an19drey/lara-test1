<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class User extends Model
{
    protected $casts = [
        'active' => 'boolean',
    ];

    protected $validationRules = [
        'create' => [
            'email' => 'required|unique:users,email|email',
            'active' => 'required|boolean'
        ],
        'update' => [
            'email' => 'email',
            'active' => 'boolean'
        ]
    ];

    public function detail()
    {
        return $this->hasOne('App\Models\UserDetail');
    }

    /**
     * @param bool $state
     * @return mixed
     */
    public function active($state = true)
    {
        return $this->where(['active' => $state]);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function updateData(Request $request)
    {
        $validated = $request->validate($this->validationRules['update']);

        $this->setRawAttributes($validated);

        return $this->save();
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function create(Request $request)
    {
        $validated = $request->validate($this->validationRules['create']);

        $this->setRawAttributes($validated);

        $this->save();

        return $this->id;
    }
}
