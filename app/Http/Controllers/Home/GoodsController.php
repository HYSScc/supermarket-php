<?php

namespace App\Http\Controllers\Home;

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
        return view('home.goods.list', ['list' => $list, 'type' => $type]);
    }

    /**
     * @param Request $request
     * @param $gid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function buy(Request $request, $gid)
    {
        $goods = DB::select('select * from goods where gid = ?', [$gid])[0];
        if ($request->isMethod('post')) {
            $count = $request->input('count');
            $gcount = $goods->count;
            if ($count > $gcount) {
                Helpers::popup("库存不足");
                Helpers::skip(url('home/goods/buy/' . $gid));
            } else {
                $uid = Auth::id();
                $invtime = date('Y-m-d', time());
                $unitprice = $goods->price;
                $totalprice = $count * $unitprice;
                DB::beginTransaction();
                $insert = DB::insert('insert into inventory (gid, uid, invtime, issale, count, unitprice, totalprice) values (?, ?, ?, ?, ?, ?, ?)',
                    [$gid, $uid, $invtime, 1, $count, $unitprice, $totalprice]);
                $rest = $gcount - $count;
                $update = DB::update('update goods set count = ? where gid = ?', [$rest, $gid]);
                if ($insert && $update) {
                    DB::commit();
                    Helpers::popup("购买成功");
                    Helpers::skip(url('home/user/orders'));
                } else {
                    DB::rollBack();
                    Helpers::popup("购买失败");
                }
            }
        }
        return view('home.goods.buy', ['goods' => $goods]);
    }
}