<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Api\V1\ErrorCodes;
use App\Models\Api\V1\UserDetail;
use App\Models\Api\V1\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDetailsController extends ApiController
{
    protected $resource = 'user_details';

    public function update(Request $request, $userId)
    {
        $pdo = DB::connection()->getPdo();
        $pdo->exec('LOCK TABLES users WRITE, user_details WRITE, countries READ');

        $user = User::find($userId);

        if (!$user) {
            $this->createException(ErrorCodes::USER_NOT_FOUND);
        }

        if (!$user->active) {
            $this->createException(ErrorCodes::ACTIVE_USER_NOT_FOUND);
        }

        if (!$user->detail) {
            $this->createException(ErrorCodes::USER_DETAILS_NOT_FOUND);
        }

        $result = $user->detail->updateData($request);

        $this->unlockTables();

        $response = ['data' => ['result' => $result]];
        return response()->json($response, 200);
    }

    /**
     * @param Request $request
     * @return array[]
     */
    public function create(Request $request, $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            $this->createException(ErrorCodes::USER_NOT_FOUND);
        }

        if ($user->detail) {
            $this->createException(ErrorCodes::USER_DETAILS_ALREADY_EXIST);
        }

        $id = (new UserDetail())->create($user->id, $request);
        $response = ['data' => ['result' => is_numeric($id) ? true : false, 'id' => $id]];

        return response()->json($response, 200);
    }

    /**
     * @param Request $request
     * @param $userId
     * @return array[]
     * @throws \Exception
     */
    public function delete(Request $request, $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            $this->createException(ErrorCodes::USER_NOT_FOUND);
        }

        if (!$user->detail) {
            $this->createException(ErrorCodes::USER_DETAILS_NOT_FOUND);
        }

        $result = $user->detail->delete();

        $response = ['data' => ['result' => $result]];

        return response()->json($response, 200);
    }

}
