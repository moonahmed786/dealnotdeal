<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Makeanoffer extends BaseModel 
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'makeanoffers';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['post_id', 'next_post_id', 'original_price', 'offer_price', 'description_text', 'buyer_id','seller_id', 'is_read_admin', 'is_read_professional', 'is_read_individual', 'approve_seller', 'approve_buyer', 'approve_admin', 'status'];

    public function pictures()
    {
        return $this->hasMany(Picture::class, 'post_id')->orderBy('position')->orderBy('id');
    }

    
}
