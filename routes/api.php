<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

//CRUD
Route::apiResource('/users', 'UserController');

Route::apiResource('/questions', 'QuestionController');

Route::apiResource('/categories', 'CategoryController');

Route::apiResource('/questions/{question}/replies', 'ReplyController');


//LIKE
Route::post('/replies/{reply}/like', 'LikeController@likeIt');
Route::delete('/replies/{reply}/like', 'LikeController@unlikeIt');


//FAVOURITE
Route::get('/favourites', 'FavouriteController@getQuestions');
Route::post('/questions/{question}/favourite', 'FavouriteController@favouriteIt');
Route::delete('/questions/{question}/favourite', 'FavouriteController@unfavouriteIt');


//SEARCH
Route::post('/search', 'SearchController@getUsers');


//NOTIFICATIONS
Route::post('/notifications', 'NotificationController@index');
Route::post('/markasread', 'NotificationController@markAsRead');


//COUNT
Route::post('/maximumreplies', 'CountController@maxReplies');
Route::post('/maximumquestions', 'CountController@maxQuestions');

