<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Api\V1\ErrorCodes;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class ApiController extends BaseController
{
    protected $errrors;
    protected $resource;

    public function __construct()
    {
        $this->errrors = (new ErrorCodes())->get();
    }

    /**
     * @param string $name
     * @throws \Exception
     */
    protected function createException(string $name)
    {
        $this->unlockTables();

        $errorInfo = $this->errrors[$this->resource][debug_backtrace()[1]['function']][$name];

        throw new \Exception($errorInfo['message'], $errorInfo['code']);
    }

    protected function unlockTables()
    {
        $pdo = DB::connection()->getPdo();
        $pdo->exec('UNLOCK TABLES');
    }
}
