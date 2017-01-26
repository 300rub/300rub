<?php
//
//namespace testS\tests\unit\models;
//
//use testS\models\UserModel;
//
///**
// * Tests for model SeoModel
// *
// * @package tests\unit\models
// */
//class UserModelTest extends AbstractModelTest
//{
//
//	/**
//	 * Model object
//	 *
//	 * @return UserModel
//	 */
//	protected function getModel()
//	{
//		return new UserModel;
//	}
//
//	/**
//	 * Data provider for CRUD test
//	 *
//	 * @return array
//	 */
//	public function dataProviderForCRUD()
//	{
//		return [
//			$this->_dataProviderForCRUDNull(),
//			$this->_dataProviderForCRUDEmpty(),
//			$this->_dataProviderForCRUDSmall(),
//			$this->_dataProviderForCRUDLoginWithSpace(),
//			$this->_dataProviderForCRUDLoginWithSymbols(),
//			$this->_dataProviderForCRUDUpdateNull(),
//			$this->_dataProviderForCRUDUpdateEmpty(),
//			$this->_dataProviderForCRUDUpdateSmall(),
//			$this->_dataProviderForCRUDUpdateLoginWithSpace(),
//			$this->_dataProviderForCRUDUpdateLoginWithSymbols(),
//			$this->_dataProviderForCRUDUpdateLoginWithNormal(),
//			$this->_dataProviderForCRUDUpdateLoginWithSpaces()
//		];
//	}
//
//	/**
//	 * Insert: null data.
//	 *
//	 * @return array
//	 */
//	private function _dataProviderForCRUDNull()
//	{
//		return [
//            [],
//            [
//                "login"    => ["required", "min"],
//                "password" => ["required", "min"],
//            ]
//		];
//	}
//
//	/**
//	 * Insert: empty values
//	 *
//	 * @return array
//	 */
//	private function _dataProviderForCRUDEmpty()
//	{
//		return [
//            [
//                "login"    => "",
//                "password" => "",
//            ],
//            [
//                "login"    => ["required", "min"],
//                "password" => ["required", "min"],
//            ]
//		];
//	}
//
//	/**
//	 * Insert: small values
//	 *
//	 * @return array
//	 */
//	private function _dataProviderForCRUDSmall()
//	{
//		return [
//            [
//                "login"    => "a",
//                "password" => "b",
//            ],
//            [
//                "login"    => ["min"],
//                "password" => ["min"],
//            ]
//		];
//	}
//
//	/**
//	 * Insert: login with space
//	 *
//	 * @return array
//	 */
//	private function _dataProviderForCRUDLoginWithSpace()
//	{
//		return [
//            [
//                "login"    => "login name",
//                "password" => "password",
//            ],
//            [
//                "login"    => ["latinDigitUnderscoreHyphen"]
//            ]
//		];
//	}
//
//	/**
//	 * Insert: login with symbols
//	 *
//	 * @return array
//	 */
//	private function _dataProviderForCRUDLoginWithSymbols()
//	{
//		return [
//            [
//                "login"    => "login!",
//                "password" => "password",
//            ],
//            [
//                "login"    => ["latinDigitUnderscoreHyphen"]
//            ]
//		];
//	}
//
//	/**
//	 * Insert: normal.
//	 * Update: null
//	 *
//	 * @return array
//	 */
//	private function _dataProviderForCRUDUpdateNull()
//	{
//		return [
//            [
//                "login"    => "login",
//                "password" => "password!£$%^&*()",
//            ],
//            [],
//            [
//                "login"    => "login",
//                "password" => UserModel::createPasswordHash("password!£$%^&*()"),
//            ],
//            [],
//            [],
//            [
//                "login"    => "login",
//                "password" => UserModel::createPasswordHash("password!£$%^&*()"),
//            ]
//		];
//	}
//
//	/**
//	 * Insert: normal.
//	 * Update: empty values
//	 *
//	 * @return array
//	 */
//	private function _dataProviderForCRUDUpdateEmpty()
//	{
//		return [
//            [
//                "login"    => "login",
//                "password" => "password",
//            ],
//            [
//                "login"    => "login",
//                "password" => UserModel::createPasswordHash("password"),
//            ],
//            [
//                "login"    => "",
//                "password" => "",
//            ],
//            [
//                "login"    => ["required", "min"],
//                "password" => ["required", "min"],
//            ]
//		];
//	}
//
//	/**
//	 * Insert: normal.
//	 * Update: small values
//	 *
//	 * @return array
//	 */
//	private function _dataProviderForCRUDUpdateSmall()
//	{
//		return [
//            [
//                "login"    => "login",
//                "password" => "password",
//            ],
//            [
//                "login"    => "login",
//                "password" => UserModel::createPasswordHash("password"),
//            ],
//            [
//                "login"    => "l",
//                "password" => "p",
//            ],
//            [
//                "login"    => ["min"],
//                "password" => ["min"],
//            ]
//		];
//	}
//
//	/**
//	 * Insert: normal.
//	 * Update: login with spaces
//	 *
//	 * @return array
//	 */
//	private function _dataProviderForCRUDUpdateLoginWithSpace()
//	{
//		return [
//            [
//                "login"    => "login",
//                "password" => "password",
//            ],
//            [
//                "login"    => "login",
//                "password" => UserModel::createPasswordHash("password"),
//            ],
//            [
//                "login"    => "new login name",
//                "password" => "password",
//            ],
//            [
//                "login"    => ["latinDigitUnderscoreHyphen"],
//            ]
//		];
//	}
//
//	/**
//	 * Insert: normal.
//	 * Update: login symbols
//	 *
//	 * @return array
//	 */
//	private function _dataProviderForCRUDUpdateLoginWithSymbols()
//	{
//		return [
//            [
//                "login"    => "login",
//                "password" => "password",
//            ],
//            [
//                "login"    => "login",
//                "password" => UserModel::createPasswordHash("password"),
//            ],
//            [
//                "login"    => "newLogin$",
//                "password" => "password",
//            ],
//            [
//                "login"    => ["latinDigitUnderscoreHyphen"],
//            ]
//		];
//	}
//
//	/**
//	 * Insert: normal.
//	 * Update: normal
//	 *
//	 * @return array
//	 */
//	private function _dataProviderForCRUDUpdateLoginWithNormal()
//	{
//		return [
//            [
//                "login"    => "login_4",
//                "password" => "password",
//            ],
//            [
//                "login"    => "login_4",
//                "password" => UserModel::createPasswordHash("password"),
//            ],
//            [
//                "login"    => "newLogin-5",
//                "password" => "newPassword",
//            ],
//            [
//                "login"    => "newLogin-5",
//                "password" => UserModel::createPasswordHash("newPassword"),
//            ]
//		];
//	}
//
//	/**
//	 * Insert: with spaces.
//	 * Update: with spaces
//	 *
//	 * @return array
//	 */
//	private function _dataProviderForCRUDUpdateLoginWithSpaces()
//	{
//		return [
//            [
//                "login"    => "   login_4-s   ",
//                "password" => "     password ",
//            ],
//            [
//                "login"    => "login_4-s",
//                "password" => UserModel::createPasswordHash("password"),
//            ],
//            [
//                "login"    => " new_3-Login ",
//                "password" => " pas  sword!£ $%^&*()QQs  ",
//            ],
//            [
//                "login"    => "new_3-Login",
//                "password" => UserModel::createPasswordHash("pas  sword!£ $%^&*()QQs"),
//            ]
//		];
//	}
//
//	/**
//	 * Test for finding
//	 *
//	 * @param string $login
//	 * @param bool   $notNull
//	 *
//	 * @dataProvider dataProviderForFindByLogin
//	 */
//	public function testFindByLogin($login, $notNull)
//	{
//		$model = $this->getModel()->findByLogin($login);
//		$this->assertEquals($notNull, !is_null($model));
//	}
//
//	/**
//	 * Data provider for testFindByLogin
//	 *
//	 * @return array
//	 */
//	public function dataProviderForFindByLogin()
//	{
//		return [
//			// empty login
//			[
//				"",
//				false,
//			],
//			// space login
//			[
//				"  ",
//				false,
//			],
//			// incorrect login
//			[
//				"incorrect_login",
//				false,
//			],
//			// correct login
//			[
//				"login",
//				true,
//			],
//			// correct login with spaces
//			[
//				" login ",
//				true,
//			]
//		];
//	}
//}