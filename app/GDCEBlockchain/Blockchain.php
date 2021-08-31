<?php
namespace App\GDCEBlockchain;

use App\Models\BlockchainModel;
use Illuminate\Support\Facades\Log;

class Blockchain
{
    protected $clientId;
    protected $modelClass;
    protected $modelId;
    protected $timestamp;
    protected $hashAlgo;
    protected $hashSalt;
//    protected $causer;
//    protected $data;
    protected $previousHash;
    protected $nonce;

    public function __construct ($clientId, $modelClass, $modelId, $causer=null, $data=null)
    {
        $this->clientId = $clientId;
        $this->modelClass = $modelClass;
        $this->modelId = $modelId;
        $this->causer = $causer;
        $this->data = $data;
        $this->hashAlgo = $this->getHashAlgo();
        $this->hashSalt = $this->getHashSalt();
        $this->previousHash = $this->getPreviousHash();
        $this->timestamp = time();
        $this->nonce = 0;

    }

    private function getLastBlock(){
        return BlockchainModel::where(['client_id'=>$this->clientId,'model_class'=>$this->modelClass,'model_id'=>$this->modelId])->orderBy('id', 'desc')->first();
    }

    public function getChain(){
        return BlockchainModel::where(['client_id'=>$this->clientId,'model_class'=>$this->modelClass,'model_id'=>$this->modelId])->orderBy('id')->get();
    }

    public function addBlock(){
        $blockModel = new BlockchainModel();

        $blockModel->client_id = $this->clientId;
        $blockModel->model_class = $this->modelClass;
        $blockModel->model_id = $this->modelId;
        $blockModel->causer = $this->causer;
        $blockModel->timestamp = $this->timestamp;
        $blockModel->data = $this->data;
        $blockModel->previous_hash = $this->getPreviousHash();
        $blockModel->hash = $this->calculateHash($this->data)[0];
        $blockModel->nonce = $this->calculateHash($this->data)[1];
        $blockModel->save();
    }

    public function isChainValid(){
        $blocks = $this->getChain();
        for($i=0 ; $i < count($blocks); $i++){
            $current_block = $blocks[$i];
            $previous_block = $i>0?$blocks[$i - 1]:[];

            if($current_block->hash != self::calculateHash($current_block->data, $current_block->timestamp, $current_block->previous_hash.$current_block->nonce)[0]){
                return false;
            }

            if($i>0 && ($current_block->previous_hash != $previous_block->hash)){
                return false;
            }

            if($i==(count($blocks)-1)){
                if(md5($current_block->data) != md5($this->data)){
                    return false;
                }
            }
        }
        return true;
    }

    private function calculateHash($data,$timestamp=null, $previous_hash=null): array
    {
        $hash = "";
        $nonce = 0;
        $difficulty = config('blockchain.difficulty', 3);


        if($timestamp && $previous_hash){
            $hash = hash($this->hashAlgo,$this->clientId.$this->modelClass .$this->modelId.$this->causer.$timestamp.$data.$previous_hash, false);
        }else{
            while (substr($hash,0, $difficulty) !== str_pad('0',$difficulty, '0',STR_PAD_LEFT)){
                $nonce++;
                $hash = hash($this->hashAlgo,$this->clientId.$this->modelClass .$this->modelId.$this->causer.$this->timestamp.$data.$this->getPreviousHash().$nonce,false);
            }
        }
        return array($hash, $nonce);
    }

    private function getPreviousHash(): String {
        $lastBlock = self::getLastBlock();
        if($lastBlock){
            return $lastBlock->hash;
        }else{
            return '0';
        }
    }

    private function getHashAlgo(): String{
        return config('blockchain.hash_algo','sha512');
    }

    private function getHashSalt(): String{
        return config('blockchain.hash_salt',bcrypt('GDCE Blockchain v1.0'));
    }

}
