<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'seller';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = ['name', 'phone', 'remark','status'];


}
