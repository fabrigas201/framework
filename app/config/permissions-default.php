<?php
return  [
	'products' => [
		'title' => 'Управление товарами',
		'rules' => [
			'create' => [
				'title' => 'Создание товаров',
				'rule' => false
			],
			'edit' => [
				'title' => 'Редактирование товаров',
				'rule' => false
			],
			'delete' => [
				'title' => 'Удаление товаров',
				'rule' => false
			],
		],
	],
	'categories' => [
		'title' => 'Управление категориями',
		'rules' => [
			'create' => [
				'title' => 'Создание категорий',
				'rule' => true
			],
			'edit' => [
				'title' => 'Редактирование категорий',
				'rule' => false
			],
			'delete' => [
				'title' => 'Удаление категорий',
				'rule' => false
			],
		],
	],
];