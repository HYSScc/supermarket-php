<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request, $type)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $gname = $data['gname'];
            $brand = $data['brand'];
            $starttime = $data['starttime'];
            $endtime = $data['endtime'];
            if ($type == 1) {
                $color = $data['color'];
                $size = $data['size'];
                $crowd = $data['crowd'];
                $val_arr = [$gname, $brand, $color, $size, $crowd];
                $sel_arr = $this->copy($val_arr);
                $list = DB::select('select * from goods where type = 1 and (? is null or gname like ?) and 
(? is null or brand like ?) and (? is null or color like ?) and 
(? is null or size like ?) and (? is null or crowd like ?)', $sel_arr);
            } else {
                $deadline = $data['deadline'];
                $provenance = $data['provenance'];
                $val_arr = [$gname, $brand, $deadline, $provenance];
                $sel_arr = $this->copy($val_arr);
                $list = DB::select('select * from goods where type = 2 and (? is null or gname like ?) and 
(? is null or brand like ?) and (? is null or deadline like ?) and 
(? is null or provenance like ?)', $sel_arr);
            }
            $sales = [];
            for ($i = 0; $i < count($list); $i++) {
                $gid = $list[$i]->gid;
                $sel_arr = [$starttime, $starttime, $endtime, $endtime, $gid];
                $sale = DB::select('select sum(count) as salecount, sum(totalprice) as totalprice from Inventory where
(? is null or invtime >= ?) and (? is null or invtime <= ?) and gid = ? and issale = 1 group by gid', $sel_arr);
                $sales[$i]['salecount'] = $sale[0]->salecount ?? 0;
                $sales[$i]['totalprice'] = $sale[0]->totalprice ?? 0;
            }
            return view('admin.search', [
                'method' => 'post',
                'type' => $type,
                'list' => $list,
                'sales' => $sales
            ]);
        }
        return view('admin.search', ['method' => 'get', 'type' => $type]);
    }

    public function mapped($value)
    {
        return ['%' . $value . '%', '%' . $value . '%'];
    }

    public function copy($val_arr)
    {
        $arr = [];
        foreach ($val_arr as $value) {
            $tmp = $this->mapped($value);
            array_push($arr, $tmp[0], $tmp[1]);
        }
        return $arr;
    }
}