<?php

/**
 * Web routes
 *
 * Defines how web URLs are responded to
 */

// Root path to the HomeController
Route::get('/', 'HomeController@index')
    ->name('home');

// Administrative functions -------------------------------------------------------------

// User management
Route::get('/admin/user', 'UserManagerController@index')
    ->name('usermanager');

// Web-based chat facility --------------------------------------------------------------

// Chat setup
Route::get('/contact/chat/{subject}/{key?}', 'ChatController@index')
    ->where('subject', '(property|other)')
    ->name('chat');

// JSON setup service
Route::get('/contact/chat/setup', 'ChatController@setup');

// JSON message send service
Route::match(['get', 'post'], '/contact/chat/send', 'ChatController@send');

// JSON poll for events service
Route::post('/contact/chat/poll', 'ChatController@poll');

// Admin-side panel to display pending conversations
Route::get('/contact/chat/admin', 'ChatController@adminList')
    ->name('chatadmin');

// Admin-side facility to join a conversation
Route::get('/contact/chat/join/{conversationId}', 'ChatController@join')
    ->where('conversationId', '[0-9]+');

// Admin-side facility to end a conversation
Route::get('/contact/chat/end/{conversationId}', 'ChatController@end')
    ->where('conversationId', '[0-9]+');

// JSON service called during user departure
Route::get('/contact/chat/leave/{conversationId}', 'ChatController@leave')
    ->where('conversationId', '[0-9]+');

// Web-based email contact facility -----------------------------------------------------

// Message facility
Route::get('/contact/message/{propertyId?}', 'MessageController@index')
    ->where('propertyId', '[0-9]+')
    ->name('message');

// Send a message via web form
Route::post('/contact/sendmessage', 'MessageController@send');

// Property search engine ---------------------------------------------------------------

// List of available properties (permit POST verb for search purposes)
Route::match(['get', 'post'], '/properties', 'PropertyListController@index')
    ->name('properties');

// View the property search list
Route::get('/properties/searches', 'PropertyListController@listSearches');

// View the requested search
Route::get('/properties/restore/{id}', 'PropertyListController@restore')
    ->where('id', '[0-9]+');

// Save a search
Route::post('/properties/savesearch', 'PropertyListController@saveSearch');

// View the requested property
Route::get('/property/{id}', 'PropertyController@index')
    ->name('property')
    ->where('id', '[0-9]+');

// Property display panel ---------------------------------------------------------------

// Add a new property to the system
Route::get('/property/create', 'PropertyController@create')
    ->name('addproperty');

// Edit a property
Route::get('/property/edit/{propertyId?}', 'PropertyController@edit')
    ->where('propertyId', '[0-9]+')
    ->name('addproperty');

// Save a property in a list for later reference
Route::get('/property/save/{propertyId?}', 'PropertyController@save')
    ->where('propertyId', '[0-9]+');

// Remove a property from the saved property lsit
Route::get('/property/forget/{propertyId?}', 'PropertyController@forget')
    ->where('propertyId', '[0-9]+');

// Content management and display suite -------------------------------------------------

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

// Other route --------------------------------------------------------------------------

// Laravel default authentication layer controllers
Auth::routes();
