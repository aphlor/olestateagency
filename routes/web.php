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

// Chat facility
Route::get('/contact/chat/{subject}/{key?}', 'ChatController@index')
    ->where('subject', '(property|other)')
    ->name('chat');

// Chat json setup service
Route::get('/contact/chat/setup', 'ChatController@setup');

// Chat json message send service
Route::match(['get', 'post'], '/contact/chat/send', 'ChatController@send');

// Chat json message poll service
Route::post('/contact/chat/poll', 'ChatController@poll');

// Chat admin view
Route::get('/contact/chat/admin', 'ChatController@adminList')
    ->name('chatadmin');

// Chat admin join
Route::get('/contact/chat/join/{conversationId}', 'ChatController@join')
    ->where('conversationId', '[0-9]+');

// Chat admin join
Route::get('/contact/chat/end/{conversationId}', 'ChatController@end')
    ->where('conversationId', '[0-9]+');

// Chat user departure
Route::get('/contact/chat/leave/{conversationId}', 'ChatController@leave')
    ->where('conversationId', '[0-9]+');

// Message facility
Route::get('/contact/message/{propertyId?}', 'MessageController@index')
    ->name('message');

// Send a message via web form
Route::post('/contact/sendmessage', 'MessageController@send');

// List of available properties (permit POST verb for search purposes)
Route::match(['get', 'post'], '/properties', 'PropertyListController@index')
    ->name('properties');

// View the requested property
Route::get('/property/{id}', 'PropertyController@index')
    ->name('property')
    ->where('id', '[0-9]+');

// Add a new property to the system
Route::get('/property/create', 'PropertyController@create')
    ->name('addproperty');

// Edit a property
Route::get('/property/edit/{propertyId?}', 'PropertyController@edit')
    ->where('propertyId', '[0-9]+')
    ->name('addproperty');

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
