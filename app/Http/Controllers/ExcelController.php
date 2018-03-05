<?php

namespace App\Http\Controllers;

use App\Aether;
use DummyFullModelClass;

class ExcelController extends Controller
{
    public function export()
    {
        $cellData = [
            ['学号','姓名','成绩'],
            ['10001','AAAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];
        \Excel::create("学生成绩",function ($excel) use ($cellData){
            $excel->sheet("score",function ($sheet) use ($cellData){
               $sheet->rows($cellData);
            });
        })->store('xls')->export('xls');
    }

    public function import()
    {
        $filePath = 'storage/exports/xscj.xls';
        \Excel::load($filePath,function ($reader){
           $data = $reader->all();
           dd($data);
        });
    }

    public function video()
    {
        $videos = Aether::orderBy('id')->paginate(20);
        return compact('videos');
    }
}
