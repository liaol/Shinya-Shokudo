<?php namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Goods;
use App\Models\Department;
use App\Models\Config as ConfigModel;
use App\Models\Order;
use App\Models\Money;
use App\User;
use Request;
use Response;
use Carbon\Carbon;
use Auth;
use Session;

class BackendController extends Controller{

    private $userInfo;
    
    public function __construct()
    {
        if( $user = Auth::user()) {
            $this->userInfo = array('user_id'=>$user->id,'level'=>$user->level,'user_name'=>$user->name,'real_name'=>$user->real_name);
        }
    }

    public function login()
    {
        return view('auth.login'); 
    }

    public function loginPost()
    {
        if (Auth::attempt(['name'=>Request::input('username'),'password'=>Request::input('password')])) {
            return redirect('/');
        } else {
            Request::flashOnly('username');
            Session::flash('error','用户名或者密码错误！');
            return redirect('/auth/login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function index()
    {
        if ($this->userInfo['level'] == 1){
            return redirect('/menu');
        } elseif ($this->userInfo['level'] == 2){
            $date = Date('Y-m-d',$_SERVER['REQUEST_TIME']);
            $time = $this->getTime();
            return redirect('/admin/order/list?date='.$date.'&time='.$time);
        }
        return redirect('/auth/login');
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
        if ($this->updateBalance(Request::input('userId'),Request::input('money'),Request::input('type'))){
            return redirect('/admin/user/list');
        } else {
            return $this->errorPage($this->errMsg);
        }
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
            $seller[$k]['menu'] = Goods::where('status',1)->where('seller_id',$v['id'])->select('id','name','count','price')->get()->toArray();
        }
        return view('/front/menu',array('data'=>$seller));
    }

    private function getTime()
    {
        if (Date('H:i:s',$_SERVER['REQUEST_TIME']) < ($this->getConfig()->lunch_time))
            return 2;//午餐
        return 3;//晚餐
    }

    private function getConfig()
    {
        return ConfigModel::select('lunch_time','supper_time')->first();
    }

    public function makeOrder()
    {
        $sellerId = Request::input('sellerId');
        $goodsId = Request::input('goodsId');
        $seller = Seller::where('id',$sellerId)->where('status',1)->select('id','name')->first();
        if (empty($seller)) {
            return $this->errorPage('找不到该商家!');
        }
        $goods = Goods::where('id',$goodsId)->where('status',1)->select('id','name')->first();
        if (empty($goods)) {
            return $this->errorPage('找不到这道菜！');
        }
        return view('/front/makeorder',array('seller'=>$seller,'goods'=>$goods));
    }

    public function makeOrderPost()
    {
        $validator = \Validator::make(
            Request::input(),
            array(
                'seller_id' => 'required',
                'goods_id' => 'required',
                'quantity' => 'required|between:1,10',
                'time_type'=>'required|in:2,3',
                'pay_type'=>'required|in:1,2',
                'remark'=>'between:1,100'
            )
        );      
        if ($validator->fails()) {
            return $validator->messages()->all();
            return $this->errorPage('系统错误！');
        }
        if (!$this->checkTime(Request::input('time_type'))){
            return $this->errorPage('点餐时间已过，请联系前台妹纸！');
        }
        if (!Seller::where('status',1)->whereIn('delivery_time',[1,Request::input('time_type')])->select('id')->first()){
            return $this->errorPage('找不到该商家,可能这个时段不送！');
        }
        if($price = Goods::where('status',1)->where('id',Request::input('goods_id'))->select('price')->first()) {
            if ($balance = $this->updateBalance($this->userInfo['user_id'],$price->price*Request::input('quantity'),2) == false){
                return $this->errorPage($this->errMsg); 
            }
            $order = Order::create(array(
                'seller_id'=>Request::input('seller_id'),
                'goods_id'=>Request::input('goods_id'),
                'quantity'=>Request::input('quantity'),
                'money'=>$price->price*Request::input('quantity'),
                'status'=>1,
                'time_type'=>Request::input('time_type'),
                'pay_type'=>Request::input('pay_type'),
                'user_id' => $this->userInfo['user_id'],
            ));
            return redirect('/order/my');
        } else {
            return $this->errorPage('找不到这道菜,可能下架了！');
        }
    }

    private function checkTime($type)
    {
        return true;
    }

    public function myOrder()
    {
        $data = Order::join('seller','order.seller_id','=','seller.id')
            ->join('goods','order.goods_id','=','goods.id')
            ->where('order.user_id',$this->userInfo['user_id'])
            ->select('order.id','order.quantity','seller.name as seller_name','goods.name as goods_name','order.money','order.status','order.created_at as time','order.pay_type','order.time_type')
            ->orderBy('order.id','desc')
            ->paginate(5);
        return view('front/myorder',array('data'=>$data));
    }

    /**
        * @Synopsis  更新余额
        *
        * @Param $userId 用户id
        * @Param $money 变动的金额
        * @Param $type 操作类型 1为充值 2为消费
        * @Param $remark 备注
        *
        * @Returns  mix 
     */
    private function updateBalance($userId,$money,$type,$remark='')
    {
        $model = User::where('id',$userId);
        //如果是扣钱 先检查余额
        if ($type == 2) {
            if ($model->where('money','>=',$money)->select('id')->first()){
                if ($model->decrement('money',$money)) {
                    $balance = $model->select('money')->first();
                    $this->makeMoneyRecord($userId,$money,$type,$balance->money,$remark);
                    return $balance->money;//返回新的余额 
                } else {
                    $this->errMsg = '扣钱失败！';
                    return false;
                }
            } else {
                    $this->errMsg = '余额不足！';
                    return false;
            }
        } elseif ($type == 1) {//充值
            if ($model->increment('money',$money)){
                $balance = $model->select('money')->first();
                $this->makeMoneyRecord($userId,$money,$type,$balance->money,$remark);
                return $balance->money;
            } else {
                $this->errMsg = '充值失败！';
                return false;
            }
        } else {
            $this->errMsg = '参数有误！';
            return false;
        }
    }

    /**
        * @Synopsis  记录余额流水
        *
        * @Param $userId 用户id
        * @Param $money 变动的金额
        * @Param $type 操作类型 1为充值 2为消费
        * @Param $balance 新的余额
        * @Param $remark 备注
        *
        * @Returns  object 
     */
    private function makeMoneyRecord($userId,$money,$type,$balance,$remark='')
    {
        return Money::create(array(
            'user_id'=>$userId,
            'money'=>$money,
            'type'=>$type,
            'remark'=>$remark,
            'balance'=>$balance,
        ));
    }

    public function myRecord()
    {
        $data = $this->getUserRecord($this->userInfo['user_id']);
        return view('front/myrecord',array('data'=>$data)); 
    }

    private function getUserRecord($userId)
    {
        return Money::where('user_id',$userId)->select('id','money','type','remark','created_at as time','balance')->orderBy('id','desc')->paginate(15);
    }

    /**
        * @Synopsis  取消订单
        *
        * @Param $orderId 订单id array
        *
        * @Returns Response 
     */
    public function cancleOrder()
    {
        $orderId = Request::input('order_id');
        if (!is_array($orderId)) {
            $orderId = [$orderId];
        }
        //如果是普通用户
        if ($this->userInfo['level'] == 1) {
            foreach ($orderId as $v) {
                if (Order::where('user_id',$this->userInfo['user_id'])->where('id',$v)->where('status',1)->update(array('status'=>4))) {
                    $money = Order::where('id',$v)->select('money','user_id','pay_type')->first();
                    if ($money->pay_type == 1)  {//自付的退钱
                        $this->updateBalance($money->user_id,$money->money,1,'取消订单退回');
                    }
                }
            }
            return Response::json(array('status'=>'success'));
        } elseif($this->userInfo['level'] == 2) {
            //如果是管理员
            foreach ($orderId as $v) {
                if (Order::where('id',$v)->where('status',1)->update(array('status'=>3))) {
                    $money = Order::where('id',$v)->select('money','user_id','pay_type')->first();
                    if ($money->pay_type == 1)  {//自付的退钱
                        $this->updateBalance($money->user_id,$money->money,1,'订单审核不通过退回');
                    }
                }
            }
            return Response::json(array('status'=>'success'));
        }
    }

    /**
        * @Synopsis  订单审核通过
        *
        * @Returns  Response 
     */
    public function passOrder()
    {
        $orderId = Request::input('order_id');
        if (!is_array($orderId)) {
            $orderId = [$orderId];
        }
        foreach($orderId as $v){
            Order::where('id',$v)->update(array('status'=>2));
        }
        return Response::json(array('status'=>'success'));
    }


    public function listOrder()
    {
        $data = Order::join('seller','order.seller_id','=','seller.id')
            ->join('users','users.id','=','order.user_id')
            ->join('goods','order.goods_id','=','goods.id')
            ->select('order.id','order.quantity','seller.name as seller_name','goods.name as goods_name','order.money','order.status','order.created_at as time','order.pay_type','order.time_type','users.real_name as user_name')
            ->where('order.status','!=',4)
            ->orderBy('order.id','desc');
        if ($date = Request::input('date')) {
            $data = $data->whereBetween('order.created_at',[$date . ' 00:00:00',$date .' 23:59:59']);
        }
        if ($time = Request::input('time')) {
            $data = $data->where('order.time_type',$time);
        }
        $dataBak = $data;
        $data = $data->paginate(15);
        $count = array(
            'all'=>$dataBak->count(),
            'uncheck'=>$dataBak->where('order.status',1)->count(),
        );
        return view('backend/listorder',array('data'=>$data,'count'=>$count));
    }

}
















