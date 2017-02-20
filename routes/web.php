<?php

/**
 * Web routes
 *
 * Defines how web URLs are responded to
 */

// Root path to the HomeController
Route::get('/', 'HomeController@index')
    ->name('home');

// User management
Route::get('/admin/user', 'UserManagerController@index')
    ->name('usermanager');

// List of available properties (permit POST verb for search purposes)
Route::match(['get', 'post'], '/properties', 'PropertyListController@index')
    ->name('properties');

// Chat facility
Route::get('/contact/chat/{subject}/{key?}', 'ChatController@index')
    ->where('subject', '(property|other)')
    ->name('chat');

// View the requested property
Route::get('/property/{id}', 'PropertyController@index')
    ->name('property')
    ->where('id', '[0-9]+');

// View page from content management suite
Route::get('/content/view/{page}', 'ContentController@view')
    ->name('viewcontent');

// Create/edit content page
Route::match(['get', 'post'], '/content/create/{pageId?}', 'ContentController@index')
    ->where('pageId', '[0-9]+')
    ->name('createcontent');

// List content pages
Route::match(['get', 'post'], '/content/list', 'ContentController@list')
    ->where('pageId', '[0-9]+')
    ->name('listcontent');

// View content pages
Route::get('/content/view/{page}', 'ContentController@render')
    ->name('viewcontent');

// Laravel default authentication layer controllers
Auth::routes();
