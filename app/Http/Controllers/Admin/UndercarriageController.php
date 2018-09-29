<?php

namespace App\Http\Controllers\Admin;

use App\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UndercarriageController extends Controller
{
    /**
     * @param Request $request
     * @param $gid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function undercarriage(Request $request, $gid)
    {
        $goods = DB::select('select * from goods where gid = ?', [$gid])[0];
        if ($request->isMethod('post')) {
            $undtime = date('Y-m-d', time());
            $reason = $request->input('reason');
            DB::beginTransaction();
            $update = DB::update('update goods set status = ? where gid = ?', [0, $gid]);
            $insert = DB::insert('insert into undercarriage (gid, undtime, reason) values (?, ?, ?)',
                [$gid, $undtime, $reason]);
            if ($update && $insert) {
                DB::commit();
                Helpers::popup("下架成功");
                Helpers::skip(url('admin/undercarriage/list'));
            } else {
                DB::rollBack();
                Helpers::popup("下架失败");
            }
        }
        return view('admin.undercarriage.goods', ['goods' => $goods]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listing()
    {
        $unds = DB::table('undercarriage')->orderBy('uid', 'desc')->paginate(15);
        $list = null;
        foreach ($unds as $und) {
            $gid = $und->gid;
            $goods = DB::select('select * from goods where gid = ?', [$gid])[0];
            $list[] = [
                'gname' => $goods->gname,
                'brand' => $goods->brand,
                'undtime' => $und->undtime,
                'reason' => $und->reason,
            ];
        }
        return view('admin.undercarriage.list', ['list' => $list]);
    }
}