<?php
use App\Models\Department;
use App\User;
use SimpleExcel\SimpleExcel;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

    public function run()
    {
        User::create(array(
            'name'=>'admin',
            'real_name'=>'管理员',
            'level'=>'2',
            'password'=>\Hash::make('123456'),
            'money'=>0,
            'status'=>1,
            'department_id'=>0,
        ));
        $department = array('技术部','编辑部','商务部','人事部','财务部','行政部','总经办');
        $departmentId = [];
        foreach($department as $v){
            $id = Department::where('name',$v)->select('id')->first();
            $departmentId[] = $id->id;
        }
        $people = $this->getPeople();
        $pinyin = App::make('pinyin');
        $pinyin->set('accent', false);
        $pinyin->set('delimiter','');
        foreach ($people as $v) {
            $key = array_search(trim($v['department']),$department);
            User::create(array(
                'name'=>$pinyin->trans($v['name']),
                'real_name'=>$v['name'],
                'level'=>'1',
                'password'=>\Hash::make('123456'),
                'money'=>0,
                'status'=>1,
                'department_id'=>$departmentId[$key],
            ));
        }
    }

    private function getPeople()
    {
        $excel = new SimpleExcel('csv');
        $excel->parser->loadFile(base_path().'/people.csv');
        $data = array();
        for($i=1;$i<56;$i++){
            $data[] = array(
                'name'=>$excel->parser->getCell($i+1,2),
                'department'=>$excel->parser->getCell($i+1,3),
            );
        }
        return $data;
    }
}
