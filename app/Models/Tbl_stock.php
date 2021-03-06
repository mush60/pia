<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_stock extends Model
{
    protected $fillable = [
        'item_id',
        'stock_type',
        'item_cd',
        'item_qty',
        'user_id',
        'stock_desk',
        'stock_date',
    ];

    public function item() {
        return $this->hasOne('App\Models\Tbl_item');
    }

    public function getItem() {
        return Tbl_item::find($this->item_id);
    }

    public function getUser() {
        return \App\User::find($this->user_id);
    }
}
