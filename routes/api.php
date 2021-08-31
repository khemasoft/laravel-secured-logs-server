<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix'=>'blockchain','as'=>'blockchain.'], function (){
   Route::post('add-chain-block', [\App\Http\Controllers\BlockchainController::class,'addChainBlock'])->name('add-chain-block');
   Route::post('get-chain', [\App\Http\Controllers\BlockchainController::class,'getChain'])->name('get-chain');
   Route::post('is-chain-valid', [\App\Http\Controllers\BlockchainController::class,'isChainValid'])->name('is-chain-valid');
});
