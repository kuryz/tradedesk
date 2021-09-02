<?php
/*
|--------------------------------------------------------------
| FjFrame Application Routes
|--------------------------------------------------
|
| Here is where you place all routes for the application.
| It's a breeze. Simply tell FjFrame the URIs it should respond to
| and give it the controller to call when that URI is requested.
| An example would be $route->go('user-edit'); not ('user/edit')
|
*/




$route->go('/', 'welcome@index');
$route->go('/about', 'welcome@aboutx');
$route->go('/login', 'auth@login');
$route->go('/post-login', 'auth@postlogin');
$route->go('/signup', 'auth@register');
$route->go('/post-signup', 'auth@postregister');
$route->go('/logout', 'auth@logout');

$route->go('/user-dashboard', 'userController@index');
$route->go('/user-deposit', 'userController@deposit');

$route->go('/admin-dashboard', 'adminController@index');
$route->go('/manage-deposits', 'adminController@mdeposits');
$route->go('/manage-withdrawals', 'adminController@mwithdraws');
$route->go('/investments', 'adminController@minvestment');
$route->go('/post-invest', 'adminController@postinvestment');
$route->go('/settings', 'adminController@setting');
$route->go('/post-settings', 'adminController@postsetting');

$route->submit();
?>