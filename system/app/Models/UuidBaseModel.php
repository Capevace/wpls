<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class UuidBaseModel extends Model
{
    use Uuids;
    
    // Our Primary Keys are UUIDs, not ints
	public $incrementing = false;
	public $keyType      = 'string';
}
