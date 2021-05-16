<?php

namespace App\Models;

use CodeIgniter\Model;

class TableModel extends Model
{
	protected $table            = 'transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $useTimestamps    = false;
}
