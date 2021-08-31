<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BlockchainModel extends Model
{
    protected $connection;
    public $table = 'blockchain_logs';
    protected $fillable = [
        'client_id',
        'model_class',
        'model_id',
        'causer',
        'timestamp',
        'data',
        'previous_hash',
        'hash',
        'nonce',
        'created_at'
    ];
    protected $hidden = array('hash', 'previous_hash');
    public function __construct ()
    {
        parent::__construct();
        $this->connection = env('DB_CONNECTION');

    }

}
