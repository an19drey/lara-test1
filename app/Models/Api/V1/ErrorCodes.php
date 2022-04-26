<?php


namespace App\Models\Api\V1;


class ErrorCodes
{
    const USER_NOT_FOUND = 'USER_NOT_FOUND';
    const USER_IS_ACTIVE = 'USER_IS_ACTIVE';
    const USER_DETAILS_FOUND = 'USER_DETAILS_FOUND';
    const ACTIVE_USER_NOT_FOUND = 'ACTIVE_USER_NOT_FOUND ';
    const USER_DETAILS_ALREADY_EXIST = 'USER_DETAIL_ALREADY_EXIST';
    const USER_DETAILS_NOT_FOUND = 'USER_DETAILS_NOT_FOUND';

    public function get()
    {
        return  [
            'users' => [
                'delete' => [
                    self::USER_NOT_FOUND => [
                        'code' => 404,
                        'message' => 'User not found'
                    ],
                    self::USER_IS_ACTIVE => [
                        'code' => 404,
                        'message' => 'User is active'
                    ],
                    self::USER_DETAILS_FOUND => [
                        'code' => 404,
                        'message' => 'You can not delete user. User details found'
                    ],
                ],
                'update' => [
                    self::USER_NOT_FOUND => [
                        'code' => 404,
                        'message' => 'User not found'
                    ],
                ]
            ],
            'user_details' => [
                'delete' => [
                    self::USER_NOT_FOUND => [
                        'code' => 404,
                        'message' => 'User not found'
                    ],
                    self::USER_DETAILS_NOT_FOUND => [
                        'code' => 404,
                        'message' => 'User details not found'
                    ],
                ],
                'update' => [
                    self::USER_NOT_FOUND => [
                        'code' => 404,
                        'message' => 'User not found'
                    ],
                    self::ACTIVE_USER_NOT_FOUND => [
                        'code' => 404,
                        'message' => 'Active user not found'
                    ],
                    self::USER_DETAILS_NOT_FOUND => [
                        'code' => 404,
                        'message' => 'User details not found'
                    ],
                ],
                'create' => [
                    self::USER_NOT_FOUND => [
                        'code' => 404,
                        'message' => 'User not found'
                    ],
                    self::USER_DETAILS_ALREADY_EXIST => [
                        'code' => 404,
                        'message' => 'User details already exist'
                    ],
                ],
    ]
        ];
    }
}
