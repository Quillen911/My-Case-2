<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model 
{
    protected $fillable = [
        'Cart_User_id'
    ];
    
    public function cartItem() {
        return $this->hasMany(CartItem::class,'cartItem_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'Cart_User_id');
    }
}