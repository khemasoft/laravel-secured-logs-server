<?php

namespace App\Http\Controllers;

use App\GDCEBlockchain\Blockchain;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
//        $blockchain = new Blockchain(User::class, 1);

//        $user = User::where(['id'=>1])->with(['roles','permissions']);

//        $blockchain->addBlock();

//        return view('dashboard', compact('blockchain'));
        return view('dashboard');
    }
}
