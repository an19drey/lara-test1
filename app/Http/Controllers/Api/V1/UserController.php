<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Api\V1\ErrorCodes;
use App\Models\Api\V1\User;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends ApiController
{
    protected $resource = 'users';

    public function getActive(Country $country)
    {
        return (new User())->getActiveUsersForCitizenshipCountry($country->iso2);
    }

    /**
     * @param Request $request
     * @return array[]
     */
    public function create(Request $request)
    {
        $id = (new User())->create($request);

        $response = ['data' => ['result' => is_numeric($id) ? true : false, 'id' => $id]];

        return response()->json($response, 200);
    }

    /**
     * @param Request $request
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(Request $request, $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            $this->createException(ErrorCodes::USER_NOT_FOUND);
        }

        $result = $user->updateData($request);

        $response = ['data' => ['result' => $result]];

        return response()->json($response, 200);;
    }

    /**
     * @param Request $request
     * @param $userId
     * @return array[]
     * @throws \Exception
     */
    public function delete(Request $request, $userId)
    {
        $pdo = DB::connection()->getPdo();
        $pdo->exec('LOCK TABLES users WRITE, user_details WRITE');

        $user = User::find($userId);

        if (!$user) {
            $this->createException(ErrorCodes::USER_NOT_FOUND);
        }

        if ($user->active) {
            $this->createException(ErrorCodes::USER_IS_ACTIVE);
        }

        if ($user->detail) {
            $this->createException(ErrorCodes::USER_DETAILS_FOUND);
        }

        $result = $user->delete();

        $this->unlockTables();

        $response = ['data' => ['result' => $result]];

        return response()->json($response, 200);
    }
}
