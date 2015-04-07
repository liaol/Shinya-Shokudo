<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Money extends Model {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'money';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = ['user_id', 'money', 'type','status','remark','balance'];


}
