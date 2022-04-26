<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    public $timestamps = false;

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $validationRules = [
        'create' => [
            'citizenship_country_id' => 'exists:countries,id',
            'first_name' => 'max:255',
            'last_name' => 'max:255',
            'phone_number' => 'max:255',
        ],
        'update' => [
            'citizenship_country_id' => 'exists:countries,id',
            'first_name' => 'max:255',
            'last_name' => 'max:255',
            'phone_number' => 'max:255',
        ]
    ];

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
    public function create(Int $userId, Request $request)
    {
        $validated = $request->validate($this->validationRules['create']);

        $this->setRawAttributes($validated);
        $this->setAttribute('user_id', $userId);

        $this->save();

        return $this->id;
    }
}
