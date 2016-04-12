<?php

namespace tests\unit\models;

use models\UserModel;

/**
 * Tests for model SeoModel
 *
 * @package tests\unit\models
 */
class UserModelTest extends AbstractModelTest
{

	/**
	 * Model object
	 *
	 * @return UserModel
	 */
	protected function getModel()
	{
		return new UserModel;
	}

	/**
	 * Data provider for CRUD test
	 *
	 * @return array
	 */
	public function dataProviderForCRUD()
	{
		return [
			// Insert: empty fields
			[
				[],
				[
					"t.login"    => "required",
					"t.password" => "required",
				]
			],
			// Insert: empty values
			[
				[
					"t.login"    => "",
					"t.password" => "",
				],
				[
					"t.login"    => "required",
					"t.password" => "required",
				]
			],
			// Insert: small values
			[
				[
					"t.login"    => "a",
					"t.password" => "b",
				],
				[
					"t.login"    => "min",
					"t.password" => "min",
				]
			],
			// Insert: login with space
			[
				[
					"t.login"    => "login name",
					"t.password" => "password",
				],
				[
					"t.login"    => "latinDigitUnderscoreHyphen"
				]
			],
			// Insert: login with symbols
			[
				[
					"t.login"    => "login!",
					"t.password" => "password",
				],
				[
					"t.login"    => "latinDigitUnderscoreHyphen"
				]
			],
			// Insert: normal. Update: empty fields
			[
				[
					"t.login"    => "login",
					"t.password" => "password!£$%^&*()",
				],
				[],
				[
					"t.login"    => "login",
					"t.password" => UserModel::createPasswordHash("password!£$%^&*()"),
				],
				[],
				[],
				[
					"t.login"    => "login",
					"t.password" => UserModel::createPasswordHash("password!£$%^&*()"),
				],
			],
			// Insert: normal. Update: empty values
			[
				[
					"t.login"    => "login",
					"t.password" => "password",
				],
				[],
				[
					"t.login"    => "login",
					"t.password" => UserModel::createPasswordHash("password"),
				],
				[
					"t.login"    => "",
					"t.password" => "",
				],
				[
					"t.login"    => "required",
					"t.password" => "required",
				]
			],
			// Insert: normal. Update: small values
			[
				[
					"t.login"    => "login",
					"t.password" => "password",
				],
				[],
				[
					"t.login"    => "login",
					"t.password" => UserModel::createPasswordHash("password"),
				],
				[
					"t.login"    => "l",
					"t.password" => "p",
				],
				[
					"t.login"    => "min",
					"t.password" => "min",
				]
			],
			// Insert: normal. Update: login with spaces
			[
				[
					"t.login"    => "login",
					"t.password" => "password",
				],
				[],
				[
					"t.login"    => "login",
					"t.password" => UserModel::createPasswordHash("password"),
				],
				[
					"t.login"    => "new login name",
					"t.password" => "password",
				],
				[
					"t.login"    => "latinDigitUnderscoreHyphen",
				]
			],
			// Insert: normal. Update: login symbols
			[
				[
					"t.login"    => "login",
					"t.password" => "password",
				],
				[],
				[
					"t.login"    => "login",
					"t.password" => UserModel::createPasswordHash("password"),
				],
				[
					"t.login"    => "newLogin$",
					"t.password" => "password",
				],
				[
					"t.login"    => "latinDigitUnderscoreHyphen",
				]
			],
			// Insert: normal. Update: normal
			[
				[
					"t.login"    => "login_4",
					"t.password" => "password",
				],
				[],
				[
					"t.login"    => "login_4",
					"t.password" => UserModel::createPasswordHash("password"),
				],
				[
					"t.login"    => "newLogin-5",
					"t.password" => "newPassword",
				],
				[],
				[
					"t.login"    => "newLogin-5",
					"t.password" => UserModel::createPasswordHash("newPassword"),
				]
			],
			// Insert: with spaces. Update: with spaces
			[
				[
					"t.login"    => "   login_4-s   ",
					"t.password" => "     password ",
				],
				[],
				[
					"t.login"    => "login_4-s",
					"t.password" => UserModel::createPasswordHash("password"),
				],
				[
					"t.login"    => " new_3-Login ",
					"t.password" => " pas  sword!£ $%^&*()QQs  ",
				],
				[],
				[
					"t.login"    => "new_3-Login",
					"t.password" => UserModel::createPasswordHash("pas  sword!£ $%^&*()QQs"),
				]
			],
		];
	}

	/**
	 * Test for finding
	 *
	 * @param string $login
	 * @param bool   $notNull
	 *
	 * @dataProvider dataProviderForFindByLogin
	 *
	 * @return bool
	 */
	public function testFindByLogin($login, $notNull)
	{
		$model = $this->getModel()->findByLogin($login);
		$this->assertEquals($notNull, !is_null($model));
	}

	/**
	 * Data provider for testFindByLogin
	 *
	 * @return array
	 */
	public function dataProviderForFindByLogin()
	{
		return [
			// empty login
			[
				"".
				false,
			],
			// space login
			[
				"  ".
				false,
			],
			// incorrect login
			[
				"incorrect_login".
				false,
			],
			// correct login
			[
				"login".
				true,
			],
			// correct login with spaces
			[
				" login ".
				true,
			]
		];
	}
}