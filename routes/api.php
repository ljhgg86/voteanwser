<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//user
Route::namespace('Api')->prefix('v1')->group(function () {

    // // 注册短信验证码
    // Route::post('register_sms', 'VerificationCodesController@registerSms')
    //     ->name('api.v1.register_sms');

    // // 用户注册
    // Route::post('register', 'UsersController@register')
    //     ->name('api.v1.users.register');

    // 登录短信验证码
    Route::post('login_sms', 'VerificationCodesController@loginSms')
        ->name('api.v1.login_sms');

    // 用户登录
    Route::post('login', 'LoginController@login')
        ->name('api.v1.login');

});

Route::prefix('v2')->group(function () {

    // user 路由
    Route::namespace('Api')->group(function(){
        Route::middleware('auth:api')->get('/userifo', 'UsersController@authUser');
        Route::middleware('auth:api')->post('/userifo/update', 'UsersController@update');
        Route::middleware('auth:api')->post('/user/votes', 'UsersController@allVotes');
        Route::middleware('auth:api')->post('/polls/{poll}/uservote_record', 'UsersController@votes');
        Route::middleware('auth:api')->post('/polls/{poll}/user/ranking', 'UsersController@ranking');
        Route::post('login', 'LoginController@adminLogin');
        Route::middleware('auth:api')->post('logout', 'LoginController@logout');
        //用户抽奖记录
        Route::middleware('auth:api')->post('/rewards/{reward}/user_reward', 'UsersController@rewardRecord');
        //用户兑奖登记
        Route::middleware('auth:api')->post('/rewards/{reward}/user_redeem', 'UsersController@redeem');
    });

    //uploadFile 路由
    Route::post('/upload', 'UploadController@upload')->middleware('auth:api');

    //category 路由
    Route::get('/categories','CategoriesController@index');
    Route::get('/categories/categories','CategoriesController@categories');
    Route::get('/categories/{category}','CategoriesController@show');
    Route::post('/categories','CategoriesController@store')->middleware('auth:api');
    Route::post('/categories/{category}/edit','CategoriesController@edit')->middleware('auth:api');
    Route::post('/categories/{category}/update','CategoriesController@update')->middleware('auth:api');
    Route::post('/categories/{category}/destroy', 'CategoriesController@destroy')->middleware('auth:api');

    //poll 路由
    Route::get('/polls','PollsController@index');
    Route::get('/admin/polls','PollsController@polls')->middleware('auth:api');
    //Route::get('/polls/{poll}','PollsController@show');
    Route::get('/pollss/{poll}/{userid?}','PollsController@show');//mofdify by 0.618 添加可选参数userid
    Route::post('/polls','PollsController@store')->middleware('auth:api');
    Route::post('/polls/{poll}/edit','PollsController@edit')->middleware('auth:api');
    Route::post('/polls/{poll}/update','PollsController@update')->middleware('auth:api');
    Route::post('/polls/{poll}/destroy', 'PollsController@destroy')->middleware('auth:api');
    Route::get('/polls/{poll}/rankinglist', 'RankinglistsController@rankingList');
    Route::post('/polls/{poll}/upload', 'PollsController@upload')->middleware('auth:api');

    //vote 路由
    Route::get('/polls/{poll}/votes','VotesController@index');
    Route::get('/admin/polls/{poll}/votes','VotesController@votes')->middleware('auth:api');
    Route::get('/polls/{poll}/votes/{vote}','VotesController@show');
    Route::get('/polls/{poll}/current_vote','VotesController@currentVote');
    Route::get('/polls/{poll}/past_vote','VotesController@pastVote');
    Route::post('/polls/{poll}/votes','VotesController@store')->middleware('auth:api');
    Route::post('/polls/{poll}/votes/{vote}/edit','VotesController@edit')->middleware('auth:api');
    Route::post('/polls/{poll}/votes/{vote}/update','VotesController@update')->middleware('auth:api');
    Route::post('/polls/{poll}/votes/{vote}/destroy', 'VotesController@destroy')->middleware('auth:api');

    //option 路由
    Route::get('/votes/{vote}/options','OptionsController@index');
    Route::get('/admin/votes/{vote}/options','OptionsController@options')->middleware('auth:api');
    Route::get('/votes/{vote}/options/{option}','OptionsController@index');
    Route::post('/votes/{vote}/options','OptionsController@store')->middleware('auth:api');
    Route::post('/votes/{vote}/options/{option}/edit','OptionsController@edit')->middleware('auth:api');
    Route::post('/votes/{vote}/options/{option}/update','OptionsController@update')->middleware('auth:api');
    Route::post('/votes/{vote}/options/{option}/destroy', 'OptionsController@destroy')->middleware('auth:api');
    Route::post('/votes/{vote}/uservoted', 'VotesController@voted')->middleware('auth:api');
    Route::post('/votes/{vote}/answer', 'VotesController@answer')->middleware('auth:api');
    Route::post('/votes/{vote}/options/bat_save', 'OptionsController@batSave')->middleware('auth:api');

    //add by 0.618 for votes
    Route::post('/votes/{poll}/uservoteds', 'VotesController@voteds')->middleware('auth:api');

    //voteInfo 路由
    Route::get('/votes/{vote}/voteInfos','VoteInfosController@index');
    Route::get('/admin/votes/{vote}/voteInfos','VoteInfosController@voteInfos')->middleware('auth:api');
    Route::get('/votes/{vote}/voteInfos/{voteInfo}','VoteInfosController@index');
    Route::post('/votes/{vote}/voteInfos','VoteInfosController@store')->middleware('auth:api');
    Route::post('/votes/{vote}/voteInfos/{voteInfo}/edit','VoteInfosController@edit')->middleware('auth:api');
    Route::post('/votes/{vote}/voteInfos/{voteInfo}/update','VoteInfosController@update')->middleware('auth:api');
    Route::post('/votes/{vote}/voteInfos/{voteInfo}/destroy', 'VoteInfosController@destroy')->middleware('auth:api');
    Route::post('/votes/{vote}/voteInfos/bat_save', 'VoteInfosController@batSave')->middleware('auth:api');


    //reward 路由
    Route::get('/admin/rewards','RewardsController@index')->middleware('auth:api');
    Route::get('/rewards/{reward}','RewardsController@show')->middleware('auth:api');
    Route::post('/rewards','RewardsController@store')->middleware('auth:api');
    Route::post('/rewards/{reward}/edit','RewardsController@edit')->middleware('auth:api');
    Route::post('/rewards/{reward}/update','RewardsController@update')->middleware('auth:api');
    Route::post('/rewards/{reward}/destroy', 'RewardsController@destroy')->middleware('auth:api');
    //根据输入条件抽奖
    Route::post('/rewards/{reward}/reward', 'RewardsController@reward')->middleware('auth:api');
    Route::post('/rewards/{reward}/rewards', 'RewardsController@rewards')->middleware('auth:api');

    //rewardItem 路由
    Route::get('/rewards/{reward}/rewardItems','RewardItemsController@index')->middleware('auth:api');
    Route::get('/rewards/{reward}/rewardItems/{rewardItem}','RewardItemsController@show')->middleware('auth:api');
    Route::post('/rewards/{reward}/rewardItems','RewardItemsController@store')->middleware('auth:api');
    Route::post('/rewards/{reward}/rewardItems/{rewardItem}/edit','RewardItemsController@edit')->middleware('auth:api');
    Route::post('/rewards/{reward}/rewardItems/{rewardItem}/update','RewardItemsController@update')->middleware('auth:api');
    Route::post('/rewards/{reward}/rewardItems/{rewardItem}/destroy', 'RewardItemsController@destroy')->middleware('auth:api');
    Route::post('/rewards/{reward}/rewardItems/bat_save','RewardItemsController@batSave')->middleware('auth:api');

    //rewardLog 路由
    Route::get('/rewards/{reward}/rewardLogs','RewardLogsController@index')->middleware('auth:api');
    Route::get('/rewards/{reward}/rewardLogs/{rewardLog}','RewardLogsController@show')->middleware('auth:api');
    Route::post('/rewards/{reward}/rewardLogs','RewardLogsController@store')->middleware('auth:api');
    Route::post('/rewards/{reward}/rewardLogs/{rewardLog}/edit','RewardLogsController@edit')->middleware('auth:api');
    Route::post('/rewards/{reward}/rewardLogs/{rewardLog}/update','RewardLogsController@update')->middleware('auth:api');
    Route::post('/rewards/{reward}/rewardLogs/{rewardLog}/destroy', 'RewardLogsController@destroy')->middleware('auth:api');

     //rewardRecords 路由
    Route::get('/rewards/{reward}/rewardRecords','RewardRecordsController@index')->middleware('auth:api');
    Route::get('/rewards/{reward}/rewardRecords/{rewardRecord}','RewardRecordsController@show')->middleware('auth:api');
    Route::post('/rewards/{reward}/rewardRecords','RewardRecordsController@store')->middleware('auth:api');
    Route::post('/rewards/{reward}/rewardRecords/{rewardRecord}/edit','RewardRecordsController@edit')->middleware('auth:api');
    Route::post('/rewards/{reward}/rewardRecords/{rewardRecord}/update','RewardRecordsController@update')->middleware('auth:api');
    Route::post('/rewards/{reward}/rewardRecords/{rewardRecord}/destroy', 'RewardRecordsController@destroy')->middleware('auth:api');
    //发送中奖短信(reward_type)
    Route::post('/rewards/{reward}/rewardRecords/sendsms', 'RewardRecordsController@sendSms')->middleware('auth:api');

    // ranglist 路由
    Route::get('/rankinglists','RankinglistsController@index');
    Route::get('/rankinglists/{rankinglist}','RankinglistsController@show');
    Route::post('/rankinglists','RankinglistsController@store')->middleware('auth:api');
    Route::post('/rankinglists/{rankinglist}/edit','RankinglistsController@edit')->middleware('auth:api');
    Route::post('/rankinglists/{rankinglist}/update','RankinglistsController@update')->middleware('auth:api');
    Route::post('/rankinglists/{rankinglist}/destroy', 'RankinglistsController@destroy')->middleware('auth:api');

    //inviterscore 路由 add by 0.618
    Route::get('/inviterscore/getScoresList','InviterscoreController@getScoresList');
    Route::get('/inviterscore/getUserScore/{userid}/{type}','InviterscoreController@getUserScore');
    //end

});
