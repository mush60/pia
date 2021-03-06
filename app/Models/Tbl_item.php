<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_item extends Model
{
    protected $fillable = [
        'item_code',
        'item_name',
        'item_unit',
        'gudang_id',
        'item_price',
        'desc',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function getGudang() {
        return Tbl_warehouse::find($this->gudang_id);
    }

    public function getUser() {
        return \App\User::find($this->user_id);
    }
}
