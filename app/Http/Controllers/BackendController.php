<?php namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Goods;
use Request;

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

    public function listSeller()
    {
        $data = Seller::where('status',1)->select('id','name','phone','delivery_time','remark')->orderBy('id','desc')->get()->toArray();
        return view('backend/listseller',array('data'=>$data));
    }

    public function addSeller()
    {
        return view('backend/addseller');
    }

    public function addSellerPost()
    {
        //todo 时间有限 验证神马的下次再做
        $create = Seller::create(array(
            'name'=>Request::input('name'),
            'phone'=>Request::input('phone'),
            'delivery_time'=>Request::input('delivery_time'),
            'remark'=>Request::input('remark'),
            'status'=>1,
        ));
        if ($create) {
            $msg = '新建商家成功！';
            $status = 'success';
        } else {
            $msg = "新建商家失败！"; $status = 'error';
        }
        return view('backend/addseller',array('msg'=>$msg,'status'=>$status));
    }

    public function updateSellerPost()
    {
        $sellerId = Request::input('seller_id');
        $update = array();
        if (Request::input('status'))
            $update['status'] = Request::input('status');
        if (Request::input('name')) 
            $update['name'] = Request::input('name');
        if (Request::input('phone')) 
            $update['phone'] = Request::input('phone');
        if ($update) {
            Seller::where('id',$sellerId)->update($update);
        }
        return Response::redirect(Request::url());
    }

    public function listGoods($sellerId)
    {
        $data = Goods::where('seller_id',$sellerId)->where('status','!=',3)->select('id','name','price','count','status')->get()->toArray();
        $sellerName = Seller::where('id',$sellerId)->select('name')->first();
        return view('backend/listgoods',array('data'=>$data,'sellerName'=>$sellerName->name,'sellerId'=>$sellerId));
    }

    public function addGoodsPost()
    {
        $sellerId = Request::input('seller_id');
        $name = Request::input('name');
        $price = Request::input('price');
        foreach ($name as $k=>$v) {
            Goods::create(array(
                'seller_id'=>$sellerId,
                'name'=>$v,
                'price'=>$price[$k],
                'count'=>0,
                'status'=>1,
            )); 
        }
        return redirect('/admin/goods/list/' . $sellerId);
    }


    public function userList()
    {

    }
}
