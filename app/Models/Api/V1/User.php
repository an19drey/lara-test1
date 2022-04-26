<?php

namespace App\Models\Api\V1;

use Illuminate\Support\Facades\DB;

class User extends \App\Models\User
{
    const DEFAULT_CITIZENSHIP_COUNTRY = 'AT';
    const DEFAULT_CURSOR_PAGINATE = 100;

    public function getActiveUsersForCitizenshipCountry(
        $citizenshipCountry = self::DEFAULT_CITIZENSHIP_COUNTRY,
        $cursorPaginate = self::DEFAULT_CURSOR_PAGINATE
    )
    {
        return DB::table('users')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->join('countries', 'countries.id', '=', 'user_details.citizenship_country_id')
            ->select('users.*')
            ->where(['countries.iso2' => $citizenshipCountry, 'users.active' => 1])
            ->orderBy('users.id')
            ->cursorPaginate($cursorPaginate);
    }
}
