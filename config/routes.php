<?php

return array(

	"administrator/forms" => "admin/forms",
	"administrator/edit/([a-zA-Z]+)/([0-9]+)" => "admin/edit/$1/$2",
	"administrator/add" => "admin/add",
	"administrator" => "admin/index",

	"user/profile" => "user/index",
	"user/change-data" => "user/change",
	"user/check-data" => "user/check",

	"forgot-pass" => "forgot/index",

	"login" => "auth/login",
	"register" => "auth/register",
	"logout" => "auth/logout",
	"check-auth" => "auth/check",

	"filter" => "filter/index",
	"search" => "search/index",
	"random" => "rand/index",

	"catalog/category/(\b[a-z]{1,15}\b)" => "catalog/category/$1",
	"catalog/top" => "catalog/top",
	"catalog/item/([0-9]+)" => "catalog/view/$1",
	"catalog/item/comment" => "catalog/comment",
	"catalog" => "catalog/index",


	"news/item/([0-9]+)" => "news/view/$1",
	"news" => "news/index",

	"load-more" => "home/load",
	"" => "home/index"
);