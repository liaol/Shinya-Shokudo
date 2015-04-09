<?php
use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder {

    public function run()
    {
        Department::create(array('name' => '编辑部','status'=>1));
        Department::create(array('name' => '技术部','status'=>1));
        Department::create(array('name' => '行政部','status'=>1));
        Department::create(array('name' => '商务部','status'=>1));
        Department::create(array('name' => '人事部','status'=>1));
        Department::create(array('name' => '财务部','status'=>1));
        Department::create(array('name' => '总经办','status'=>1));
    }

}
