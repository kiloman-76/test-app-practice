<?php

namespace tests\models;

use app\models\User;
use app\tests\fixtures\UserFixture;


class UserTest extends \Codeception\Test\Unit
{
    public function _fixtures()
    {
        return [
            'profiles' => [
                'class' => UserFixture::className(),
                // fixture data located in tests/_data/user.php
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ];
    }
    
    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(100));
        expect($user->username)->equals('medved');

        expect_not(User::findIdentity(999));
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = User::findIdentityByAccessToken('100-token'));
        expect($user->username)->equals('medved');

        expect_not(User::findIdentityByAccessToken('non-existing'));        
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('medved'));
        expect_not(User::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByUsername('medved');
        expect_that($user->validateAuthKey('php_auth'));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('19922001'));
        expect_not($user->validatePassword('123456'));        
    }

}
