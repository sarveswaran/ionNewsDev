<?php

use Illuminate\Routing\Router;
/** @var Router $router */

// content/users

$router->group(['prefix' =>'/content'], function (Router $router) {
    $router->bind('content', function ($id) {
        return app('Modules\Content\Repositories\ContentRepository')->find($id);
    });
    $router->get('contents', [
        'as' => 'admin.content.content.index',
        'uses' => 'ContentController@index',
        'middleware' => 'can:content.contents.index'
    ]); 
    $router->post('contents/delete_story', [
        'as' => 'admin.content.content.delete_story',
        'uses' => 'ContentController@deleteStory'
        // 'middleware' => 'can:content.contents.delete_Story'
    ]);

    $router->get('users', [
        'as' => 'Content.all.users', 
        'uses' => 'ContentController@getAllUsers'
        // 'middleware' => 'can:content.contents.getAllUsers'

      ]);


    

      $router->get('all_users', [
        'as' => 'Content.all.all_users', 
        'uses' => 'ContentController@getAllUsersInfo'
        // 'middleware' => 'can:content.contents.getAllUsers'

 ]);
           $router->get('storeUserInfo', [
        'as' => 'Content.all.storeUserInfo', 
        'uses' => 'ContentController@store_user_info'
        // 'middleware' => 'can:content.contents.getAllUsers'

 ]);

    $router->get('contents/create', [
        'as' => 'admin.content.content.create',
        'uses' => 'ContentController@create',
        'middleware' => 'can:content.contents.create'
    ]);
    $router->get('contents/ajaxcall', [
        'as' => 'admin.content.content.ajaxcall',
        'uses' => 'ContentController@ajaxcall',
        'middleware' => 'can:content.contents.ajaxcall'
    ]);
    $router->post('contents', [
        'as' => 'admin.content.content.store',
        'uses' => 'ContentController@store',
        'middleware' => 'can:content.contents.create'
    ]);
    $router->get('contents/{content}/edit', [
        'as' => 'admin.content.content.edit',
        'uses' => 'ContentController@edit',
        'middleware' => 'can:content.contents.edit'
    ]);
    $router->put('contents/{content}', [
        'as' => 'admin.content.content.update',
        'uses' => 'ContentController@update',
        'middleware' => 'can:content.contents.edit'
    ]);
    $router->delete('contents/{content}', [
        'as' => 'admin.content.content.destroy',
        'uses' => 'ContentController@destroy',
        'middleware' => 'can:content.contents.destroy'
    ]);
    $router->bind('category', function ($id) {
        return app('Modules\Content\Repositories\CategoryRepository')->find($id);
    });

    $router->get('categories', [
        'as' => 'admin.content.category.index',
        'uses' => 'CategoryController@index',
        'middleware' => 'can:content.categories.index'
    ]);
    $router->get('categories/create', [
        'as' => 'admin.content.category.create',
        'uses' => 'CategoryController@create',
        'middleware' => 'can:content.categories.create'
    ]);
   // update priority table 
      $router->post('Category/updatePriority', [
        'as' => 'Category.all.updatePriority', 
        'uses' => 'CategoryController@update_priority'
        // 'middleware' => 'can:content.contents.getAllUsers'

 ]);

    $router->post('categories', [
        'as' => 'admin.content.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:content.categories.create'
    ]);
    $router->get('categories/{category}/edit', [
        'as' => 'admin.content.category.edit',
        'uses' => 'CategoryController@edit',
        'middleware' => 'can:content.categories.edit'
    ]);
    $router->put('categories/{category}', [
        'as' => 'admin.content.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:content.categories.edit'
    ]);
    $router->delete('categories/{category}', [
        'as' => 'admin.content.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:content.categories.destroy'
    ]);
    $router->bind('contentimages', function ($id) {
        return app('Modules\Content\Repositories\ContentImagesRepository')->find($id);
    });
    $router->get('contentimages', [
        'as' => 'admin.content.contentimages.index',
        'uses' => 'ContentImagesController@index',
        'middleware' => 'can:content.contentimages.index'
    ]);
    $router->get('contentimages/create', [
        'as' => 'admin.content.contentimages.create',
        'uses' => 'ContentImagesController@create',
        'middleware' => 'can:content.contentimages.create'
    ]);
    $router->post('contentimages', [
        'as' => 'admin.content.contentimages.store',
        'uses' => 'ContentImagesController@store',
        'middleware' => 'can:content.contentimages.create'
    ]);
    $router->get('contentimages/{contentimages}/edit', [
        'as' => 'admin.content.contentimages.edit',
        'uses' => 'ContentImagesController@edit',
        'middleware' => 'can:content.contentimages.edit'
    ]);
    $router->put('contentimages/{contentimages}', [
        'as' => 'admin.content.contentimages.update',
        'uses' => 'ContentImagesController@update',
        'middleware' => 'can:content.contentimages.edit'
    ]);
    $router->delete('contentimages/{contentimages}', [
        'as' => 'admin.content.contentimages.destroy',
        'uses' => 'ContentImagesController@destroy',
        'middleware' => 'can:content.contentimages.destroy'
    ]);
    $router->bind('contentuser', function ($id) {
        return app('Modules\Content\Repositories\ContentUserRepository')->find($id);
    });
    $router->get('contentusers', [
        'as' => 'admin.content.contentuser.index',
        'uses' => 'ContentUserController@index',
        'middleware' => 'can:content.contentusers.index'
    ]);
    $router->get('contentusers/create', [
        'as' => 'admin.content.contentuser.create',
        'uses' => 'ContentUserController@create',
        'middleware' => 'can:content.contentusers.create'
    ]);
    $router->post('contentusers', [
        'as' => 'admin.content.contentuser.store',
        'uses' => 'ContentUserController@store',
        'middleware' => 'can:content.contentusers.create'
    ]);
    $router->get('contentusers/{contentuser}/edit', [
        'as' => 'admin.content.contentuser.edit',
        'uses' => 'ContentUserController@edit',
        'middleware' => 'can:content.contentusers.edit'
    ]);
    $router->put('contentusers/{contentuser}', [
        'as' => 'admin.content.contentuser.update',
        'uses' => 'ContentUserController@update',
        'middleware' => 'can:content.contentusers.edit'
    ]);
    $router->delete('contentusers/{contentuser}', [
        'as' => 'admin.content.contentuser.destroy',
        'uses' => 'ContentUserController@destroy',
        'middleware' => 'can:content.contentusers.destroy'
    ]);
    $router->bind('contentcompany', function ($id) {
        return app('Modules\Content\Repositories\ContentCompanyRepository')->find($id);
    });
    $router->get('contentcompanies', [
        'as' => 'admin.content.contentcompany.index',
        'uses' => 'ContentCompanyController@index',
        'middleware' => 'can:content.contentcompanies.index'
    ]);
    $router->get('contentcompanies/create', [
        'as' => 'admin.content.contentcompany.create',
        'uses' => 'ContentCompanyController@create',
        'middleware' => 'can:content.contentcompanies.create'
    ]);
    $router->post('contentcompanies', [
        'as' => 'admin.content.contentcompany.store',
        'uses' => 'ContentCompanyController@store',
        'middleware' => 'can:content.contentcompanies.create'
    ]);
    $router->get('contentcompanies/{contentcompany}/edit', [
        'as' => 'admin.content.contentcompany.edit',
        'uses' => 'ContentCompanyController@edit',
        'middleware' => 'can:content.contentcompanies.edit'
    ]);
    $router->put('contentcompanies/{contentcompany}', [
        'as' => 'admin.content.contentcompany.update',
        'uses' => 'ContentCompanyController@update',
        'middleware' => 'can:content.contentcompanies.edit'
    ]);
    $router->delete('contentcompanies/{contentcompany}', [
        'as' => 'admin.content.contentcompany.destroy',
        'uses' => 'ContentCompanyController@destroy',
        'middleware' => 'can:content.contentcompanies.destroy'
    ]);
    $router->bind('contentlikestory', function ($id) {
        return app('Modules\Content\Repositories\ContentLikeStoryRepository')->find($id);
    });
    $router->get('contentlikestory', [
        'as' => 'admin.content.contentlikestory.index',
        'uses' => 'ContentLikeStoryController@index',
        'middleware' => 'can:content.contentlikestories.index'
    ]);
    $router->get('contentlikestory/create', [
        'as' => 'admin.content.contentlikestory.create',
        'uses' => 'ContentLikeStoryController@create',
        'middleware' => 'can:content.contentlikestories.create'
    ]);
    $router->post('contentlikestory', [
        'as' => 'admin.content.contentlikestory.store',
        'uses' => 'ContentLikeStoryController@store',
        'middleware' => 'can:content.contentlikestories.create'
    ]);
    $router->get('contentlikestory/{contentlikestory}/edit', [
        'as' => 'admin.content.contentlikestory.edit',
        'uses' => 'ContentLikeStoryController@edit',
        'middleware' => 'can:content.contentlikestories.edit'
    ]);
    $router->put('contentlikestory/{contentlikestory}', [
        'as' => 'admin.content.contentlikestory.update',
        'uses' => 'ContentLikeStoryController@update',
        'middleware' => 'can:content.contentlikestories.edit'
    ]);
    $router->delete('contentlikestory/{contentlikestory}', [
        'as' => 'admin.content.contentlikestory.destroy',
        'uses' => 'ContentLikeStoryController@destroy',
        'middleware' => 'can:content.contentlikestories.destroy'
    ]);
// append






});
