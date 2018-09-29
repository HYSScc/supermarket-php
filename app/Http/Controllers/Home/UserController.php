<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders()
    {
        $uid = Auth::id();
        $orders = DB::select('select * from inventory where uid = ? and issale = ?', [$uid, 1]);
        $list = null;
        foreach ($orders as $order) {
            $gid = $order->gid;
            $goods = DB::select('select * from goods where gid = ?', [$gid])[0];
            $list[] = [
                'gname' => $goods->gname,
                'brand' => $goods->brand,
                'time' => $order->invtime,
                'count' => $order->count,
                'unitprice' => $order->unitprice,
                'totalprice' => $order->totalprice,
            ];
        }
        return view('home.user.orders', ['orders' => $list]);
    }
}