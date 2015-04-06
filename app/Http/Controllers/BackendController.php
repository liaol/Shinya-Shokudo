<?php namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Goods;
use App\Models\Department;
use App\Models\Config as ConfigModel;
use App\User;
use Request;
use Response;
use Carbon\Carbon;

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
        $data = Seller::where('status','!=',3)->select('id','name','phone','delivery_time','remark','status')->orderBy('status','asc')->orderBy('id','desc')->get()->toArray();
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
        if (Request::input('delivery_time')) 
            $update['delivery_time'] = Request::input('delivery_time');
        if ($update) {
            if (Seller::where('id',$sellerId)->update($update)){
                //如果是ajax 则返回json
                if (Request::ajax())
                    return Response::json(array('status'=>'success'));
            }
        }
        if (Request::ajax())
            return Response::json(array('status'=>'error'));
        return redirect('/admin/seller/list');
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
        for ($i=0;$i<count($name)-1;$i++){//舍去最后一行空的
            Goods::create(array(
                'seller_id'=>$sellerId,
                'name'=>$name[$i],
                'price'=>$price[$i],
                'count'=>0,
                'status'=>1,
            )); 
        }
        return redirect('/admin/goods/list/' . $sellerId);
    }

    public function updateGoodsPost()
    {
        $goodsId = Request::input('goods_id');
        $update = array();
        if (Request::input('status'))
            $update['status'] = Request::input('status');
        if (Request::input('name')) 
            $update['name'] = Request::input('name');
        if (Request::input('price')) 
            $update['price'] = Request::input('price');
        if ($update) {
            if (Goods::where('id',$goodsId)->update($update))
                return Response::json(array('status'=>'success'));
        }
        return Response::json(array('status'=>'error'));
    }


    public function listUser()
    {
        $data = User::leftJoin('department','users.department_id','=','department.id')
            ->where('users.status',1)
            ->select('users.id','users.name','users.real_name','level','money','qq','users.department_id','department.name as department_name')
            ->orderBy('department_id','asc')
            ->orderBy('users.id','asc')
            ->get()
            ->toArray();
        $department = Department::where('status',1)->select('id','name')->get()->toArray();
        return view('backend/listuser',array('data'=>$data,'department'=>$department));
    }

    public function addUser()
    {
        $data = Department::where('status',1)->select('id','name')->get()->toArray();
        return view('backend/adduser',array('data'=>$data));
    }

    public function addUserPost()
    {
        $name = Request::input('name');
        $realName = Request::input('real_name');
        $department = Request::input('department');
        $qq = Request::input('qq');
        $defaultPw = '123456';
        $count = count($name) >1 ? count($name)-1 : 1;
        for ($i=0;$i<=$count-1;$i++){//舍去最后一行空的
            User::create(array(
                'name'=>$name[$i],
                'real_name'=>$realName[$i],
                'department_id'=>$department[$i],
                'money'=>0,
                'status'=>1,
                'level'=>1,
                'password'=>\Hash::make($defaultPw),
                'qq'=>$qq[$i],
            ));
        }
        return redirect('/admin/user/list');
    }

    public function updateUserPost()
    {
        $userId = Request::input('user_id');
        $update = array();
        if (Request::input('status'))
            $update['status'] = Request::input('status');
        if (Request::input('name')) 
            $update['name'] = Request::input('name');
        if (Request::input('real_name')) 
            $update['real_name'] = Request::input('real_name');
        if (Request::input('department')) 
            $update['department_id'] = Request::input('department');
        if (Request::input('qq')) 
            $update['qq'] = Request::input('qq');
        if ($update) {
            if (User::where('id',$userId)->update($update))
                //如果是ajax 则返回json
                if (Request::ajax())
                    return Response::json(array('status'=>'success'));
        }
        if (Request::ajax())
            return Response::json(array('status'=>'error'));
        return redirect('/admin/user/list');
    }

    public function listDepartment()
    {
        $data = Department::where('status',1)->select('id','name')->get()->toArray();
        return view('backend/listdepartment',array('data'=>$data));
    }

    public function addDepartmentPost()
    {
        $name = Request::input('name');
        Department::create(array(
            'name'=>$name,
            'status'=>1
        ));
        return redirect('/admin/department/list');
    }

    public function updateDepartmentPost()
    {
        $id = Request::input('department_id');
        $update = array();
        if (Request::input('status'))
            $update['status'] = Request::input('status');
        if ($update) {
            if (Department::where('id',$id)->update($update))
                return Response::json(array('status'=>'success'));
        }
        return Response::json(array('status'=>'error'));
    }

    public function updateMoney()
    {
        if ($userId = Request::input('userId')) {
            $userInfo = User::where('id',$userId)->select('id','real_name','money')->first();
            if (empty($userInfo)) {
                return $this->errorPage('找不着该用户');
            }
            return view('backend/updatemoney',array('userInfo'=>$userInfo));
        }
    }

    public function updateMoneyPost()
    {
        $model = User::where('id',Request::input('userId'));
        if (Request::input('type') == 1) {
            $update = $model->increment('money',Request::input('money'));
            //Todo 添加记录
        } else {
            $update = $model->decrement('money',Request::input('money'));
            //Todo 添加记录
        }
        return redirect('/admin/user/list');
    }

    private function errorPage($msg,$uri = '/index')
    {
        return $msg;
    }

    //菜单
    public function menu()
    {
         $time = $this->getTime(); 
         $seller = Seller::where('status',1)->whereIn('delivery_time',[$time,3])->select('id','name','phone','remark','delivery_time')->get()->toArray();
         foreach ($seller as $k=>$v) {
            $seller[$k]['menu'] = Goods::where('status',1)->where('seller_id',$v['id'])->select('name','count','price')->get()->toArray();
         }
         return view('/customer/menu',array('menu'=>$seller));
    }

    private function getTime()
    {
        $today = Carbon::today();
        if ($_SERVER['REQUEST_TIME'] < $today->timestamp + strtotime($this->getConfig()->lunch_time))
            return 2;//午餐
        return 3;//晚餐
    }

    private function getConfig()
    {
        return ConfigModel::select('lunch_time','supper_time')->first();
    }
}
















