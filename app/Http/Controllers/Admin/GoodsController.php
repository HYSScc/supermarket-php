<?php

namespace App\Http\Controllers\Admin;

use App\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    /**
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listing($type)
    {
        $list = DB::table('goods')->where([
            'type' => $type,
            'status' => 1
        ])->paginate(15);
        return view('admin.goods.list', ['list' => $list, 'type' => $type]);
    }

    /**
     * @param Request $request
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request, $type)
    {
        if ($request->isMethod('post')) {
            $uid = Auth::id();
            $data = $request->all();
            $gname = $data['gname'];
            $brand = $data['brand'];
            $price = $data['price'];
            $count = $data['count'];
            $starttime = date('Y-m-d', time());
            DB::beginTransaction();
            if ($type == 1) {
                $color = $data['color'];
                $size = $data['size'];
                $crowd = $data['crowd'];
                $goods_insert = DB::insert('insert into goods (gname, type, brand, color, size, crowd, starttime, price, count, status) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                    [$gname, $type, $brand, $color, $size, $crowd, $starttime, $price, $count, 1]);
            } else {
                $deadline = $data['deadline'];
                $provenance = $data['provenance'];
                $goods_insert = DB::insert('insert into goods (gname, type, brand, starttime, deadline, provenance, price, count, status) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',
                    [$gname, $type, $brand, $starttime, $deadline, $provenance, $price, $count, 1]);
            }
            $gid = DB::select('select * from goods where gname = ? and brand = ?', [$gname, $brand])[0]->gid;
            $totalprice = $price * $count;
            $inv_insert = DB::insert('insert into inventory (gid, uid, invtime, issale, count, unitprice, totalprice) values (?, ?, ?, ?, ?, ?, ?)',
                [$gid, $uid, $starttime, 0, $count, $price, $totalprice]);
            if ($goods_insert && $inv_insert) {
                DB::commit();
                Helpers::popup("添加成功");
                Helpers::skip(url('admin/goods/list/' . $type));
            } else {
                DB::rollBack();
                Helpers::popup("添加失败");
            }
        }
        return view('admin.goods.add', ['type' => $type]);
    }

    /**
     * @param Request $request
     * @param $gid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stock(Request $request, $gid)
    {
        $goods = DB::select('select * from goods where gid = ?', [$gid])[0];
        if ($request->isMethod('post')) {
            $uid = Auth::id();
            $invtime = date('Y-m-d', time());
            $count = $request->count;
            $unitprice = $goods->price;
            $totalprice = $count * $unitprice;
            DB::beginTransaction();
            $insert = DB::insert('insert into inventory (gid, uid, invtime, issale, count, unitprice, totalprice) values (?, ?, ?, ?, ?, ?, ?)',
                [$gid, $uid, $invtime, 0, $count, $unitprice, $totalprice]);
            $gcount = $goods->count;
            $sum = $count + $gcount;
            $update = DB::update('update goods set count = ? where gid = ?', [$sum, $gid]);
            if ($insert && $update) {
                DB::commit();
                Helpers::popup("进货成功");
                Helpers::skip(url('admin/goods/list/' . $goods->type));
            } else {
                DB::rollBack();
                Helpers::popup("进货失败");
            }
        }
        return view('admin.goods.stock', ['goods' => $goods]);
    }
}