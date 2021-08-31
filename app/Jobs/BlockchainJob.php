<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\GDCEBlockchain\Blockchain;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BlockchainJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $clientId;
    private $modelClass;
    private $modelId;
    private $causer;
    private $object;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($clientId, $modelClass, $modelId, $causer, $object=null)
    {
        $this->clientId = $clientId;
        $this->modelClass = $modelClass;
        $this->modelId = $modelId;
        $this->causer = $causer;
        $this->object=$object;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $blockchain = new Blockchain($this->clientId, $this->modelClass, $this->modelId, $this->causer, $this->object);
        $blockchain->addBlock();
    }
}
