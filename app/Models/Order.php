<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'order';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = ['user_id', 'seller_id', 'goods_id','status','money','quantity','pay_type','time_type','remark'];


}
