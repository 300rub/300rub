<?php

// Main settings
return [
	"host"    => "300rub.net",
	"isDebug" => true,
	"db"      => [
		"host"     => "localhost",
		"user"     => "root",
		"password" => "",
		"name"     => "project",
	],
	"release" => [
		"current" => "1.1",
		"prev"    => "1.0",
	],
	"email"   => [
		"adress" => "moyregion@inbox.ru",
	],
	"language" => "ru",
	"helpDb"      => [
		"host"     => "localhost",
		"user"     => "root",
		"password" => "",
		"name"     => "help",
	],
	"ssh" => [
		"active" => "fileServer001",
		"list" => [
			"fileServer001" => [
				"host"           => "",
				"port"           => 22,
				"username"       => "",
				"publicKeyPath"  => "",
				"privateKeyPath" => "",
				"passPhrase"     => ""
			]
		]
	],
	"siteId" => 0
];