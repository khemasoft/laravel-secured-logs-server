<?php

namespace App\Http\Controllers;

use App\GDCEBlockchain\Blockchain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlockchainController extends Controller
{
    public function addChainBlock(Request $request){
        $clientId = $request->client_id;
        $modelClass = $request->model_class;
        $modelId = $request->model_id;
        $data = json_encode($request->data);
        $causer = json_encode($request->causer);

        //TODO Add to queue job
        $blockchain = new Blockchain($clientId, $modelClass, $modelId, $causer, $data);
        $blockchain->addBlock();

        return response()->json($data);

    }

    public function getChain(Request $request){
        $clientId = $request->client_id;
        $modelClass = $request->model_class;
        $modelId = $request->model_id;
        $blockchain = new Blockchain($clientId, $modelClass, $modelId);
        $chain = $blockchain->getChain();

        Log::info($chain);

        return response()->json($chain);
    }

    public function isChainValid(Request $request){
        $clientId = $request->client_id;
        $modelClass = $request->model_class;
        $modelId = $request->model_id;
        $data = json_encode($request->data);
        $causer = json_encode($request->causer);

        $blockchain = new Blockchain($clientId, $modelClass, $modelId, $causer, $data);
        $status = $blockchain->isChainValid();

        return response()->json(['blockchain_status'=>$status]);
    }
}
