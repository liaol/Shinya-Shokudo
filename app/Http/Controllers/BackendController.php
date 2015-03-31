<?php namespace App\Http\Controllers;

use App\Models\Seller;

class BackendController extends Controller{

    public function login()
    {
        return view('auth.login'); 
    }

    public function loginPost()
    {

    }

    public function index()
    {
    
    }

    public function sellerList()
    {
        $data = Seller::where('status',1)->select('name','phone')->get()->toArray();
        return view('backend/sellerlist',$data);
    }

    public function goodsList()
    {
    }

    public function userList()
    {

    }
}
