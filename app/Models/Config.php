<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'config';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = ['lunch_time','supper_time'];


}
