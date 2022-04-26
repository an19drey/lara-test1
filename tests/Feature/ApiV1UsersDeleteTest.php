<?php

namespace Tests\Feature;

use App\Models\Api\V1\ErrorCodes;
use App\Models\Api\V1\User;
use League\CommonMark\Extension\CommonMark\Node\Block\ThematicBreak;
use Tests\TestCase;

class ApiV1UsersDeleteTest extends TestCase
{
    const EMAIL_DOMAIN = 'test.com';
    const MAX_USER_ID = 2147483647;

    private function getErrorInfo($resource, $method, $errorName)
    {
        $errors = (new ErrorCodes())->get();

        return $errors[$resource][$method][$errorName];
    }

    protected function getHeaders()
    {
        return ['Accept' => 'application/json'];
    }

    protected function getUserEmail($methodName)
    {
        return 'ApiV1UsersDeleteTest' . '_' . $methodName . '_' . microtime(true) . '@' . self::EMAIL_DOMAIN;
    }

    public function test_success_delete()
    {
        $email = $this->getUserEmail(__FUNCTION__);

        $responseCreateUser = $this->post(
            '/api/v1/users',
            ['email' => $email, 'active' => 0],
            $this->getHeaders()
        );

        $result = json_decode($responseCreateUser->getContent(), true);
        $userId = $result['data']['id'];

        $responseDelete = $this->deleteJson('/api/v1/users/' . $userId, [], $this->getHeaders());

        $responseDelete
            ->assertStatus(200)
            ->assertExactJson(['data' => ['result' => true]]);
    }

    public function test_user_not_found()
    {
        $userId = self::MAX_USER_ID + 1;

        $user = User::find($userId);
        $this->assertEmpty($user);

        $responseDelete = $this->deleteJson('/api/v1/users/' . $userId, [], $this->getHeaders());

        $errorInfo = $this->getErrorInfo('users', 'delete', ErrorCodes::USER_NOT_FOUND);

        $responseDelete
            ->assertJson([
                'code' => $errorInfo['code'],
                'code_message' => $errorInfo['message'],
            ]);
    }

    public function test_user_is_active()
    {
        $email = $this->getUserEmail(__FUNCTION__);
        $errorInfo = $this->getErrorInfo('users', 'delete', ErrorCodes::USER_IS_ACTIVE);

        $responseCreateUser = $this->post(
            '/api/v1/users',
            ['email' => $email, 'active' => 1],
            $this->getHeaders()
        );

        $result = json_decode($responseCreateUser->getContent(), true);
        $userId = $result['data']['id'];

        $responseDelete = $this->deleteJson('/api/v1/users/' . $userId, [], $this->getHeaders());

        $responseDelete
            ->assertJson([
                'code' => $errorInfo['code'],
                'code_message' => $errorInfo['message'],
            ]);
    }

    public function test_user_detail_found()
    {
        $email = $this->getUserEmail(__FUNCTION__);
        $errorInfo = $this->getErrorInfo(
            'users',
            'delete',
            ErrorCodes::USER_DETAILS_FOUND
        );

        $responseCreateUser = $this->post(
            '/api/v1/users',
            ['email' => $email, 'active' => 0],
            $this->getHeaders()
        );

        $result = json_decode($responseCreateUser->getContent(), true);
        $userId = $result['data']['id'];

        $responseCreateUserDetails = $this->post(
            '/api/v1/user-details/' . $userId,
            [
                'citizenship_country_id' => 1,
                'first_name' => 'Test',
                'last_name' => 'TestTest',
                'phone_number' => '7777'
            ],
            $this->getHeaders()
        );

        $responseDelete = $this->deleteJson('/api/v1/users/' . $userId, [], $this->getHeaders());

        $responseDelete
            ->assertJson([
                'code' => $errorInfo['code'],
                'code_message' => $errorInfo['message'],
            ]);
    }
}
