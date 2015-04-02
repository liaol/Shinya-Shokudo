<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'department';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = ['status','name'];


}
