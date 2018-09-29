<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    /**
     * @var array
     */
    protected $arr = [
        'week' => 7,
        'month' => 30,
        'quarter' => 90,
        'year' => 365
    ];

    /**
     * @param $period
     * @param $gid
     * @return array
     */
    public function goods($period, $gid)
    {
        $goods = DB::select('select * from goods where gid = ?', [$gid])[0];
        $starttime = $goods->starttime;
        $orders = DB::select('select * from inventory where gid = ? and issale = ?', [$gid, 1]);
        $today = date('Y-m-d', time());
        //$today = date('Y-m-d', strtotime("2018-05-31"));
        if ($period == 'day') {
            $statistics = [];
            $days = 1;
            for ($i = $starttime; $i <= $today; $i++) {
                $statistics[$days]['date'] = $i;
                $statistics[$days]['count'] = 0;
                $statistics[$days]['totalprice'] = 0;
                foreach ($orders as $order) {
                    if ($order->invtime == $i) {
                        $statistics[$days]['count'] += $order->count;
                        $statistics[$days]['totalprice'] += $order->totalprice;
                    }
                }
                $days++;
            }
        } else {
            $statistics = [];
            $counter = 1;
            $days = 1;
            for ($i = $starttime; $i <= $today; $i++) {
                if (!isset($statistics[$counter])) {
                    $statistics[$counter]['count'] = 0;
                    $statistics[$counter]['totalprice'] = 0;
                }
                foreach ($orders as $order) {
                    if ($order->invtime == $i) {
                        $statistics[$counter]['count'] += $order->count;
                        $statistics[$counter]['totalprice'] += $order->totalprice;
                    }
                }
                if ($days == 1) {
                    $statistics[$counter]['from'] = $i;
                }
                if ($days == $this->arr[$period] || $i == $today) {
                    $statistics[$counter]['to'] = $i;
                    $days = 1;
                    $counter++;
                } else {
                    $days++;
                }
            }
        }
        return $statistics;
    }

    /**
     * @param $period
     * @param $para
     * @return array
     */
    public function listing($period, $para)
    {
        $starttime = strtotime("2018-05-08");
        $today = time();
        //$today = strtotime("2018-05-19");
        $list = null;
        if ($period == 'day') {
            if ($para == 1) {
                $list = DB::select('select GT.type,G.gname,G.brand,sum(I.count) as count,sum(I.totalprice) as totalprice
from inventory I
left join goods G on G.gid=I.gid
left join goods_type GT on G.type=GT.typeid
where I.invtime=? and I.issale=1
group by I.gid', [date('Y-m-d', $today)]);
            } else {
                $list = DB::select('select G.brand,sum(I.count) as count,sum(I.totalprice) as totalprice
from inventory I
left join goods G on G.gid=I.gid
where I.invtime=? and I.issale=1
group by G.brand', [date('Y-m-d', $today)]);
            }
        } else {
            $interval = 60 * 60 * 24 * $this->arr[$period];
            if ($today - $interval > $starttime) {
                $starttime = $today - $interval;
            }
            if ($para == 1) {
                $list = DB::select('select GT.type,G.gname,G.brand,sum(I.count) as count,sum(I.totalprice) as totalprice
from inventory I
left join goods G on G.gid=I.gid
left join goods_type GT on G.type=GT.typeid
where invtime>=? and I.issale=1
group by I.gid', [date('Y-m-d', $starttime)]);
            } else {
                $list = DB::select('select G.brand,sum(I.count) as count,sum(I.totalprice) as totalprice
from inventory I
left join goods G on G.gid=I.gid
where I.invtime>=? and I.issale=1
group by G.brand', [date('Y-m-d', $starttime)]);
            }
        }
        $totalcount = 0;
        $totalamount = 0;
        foreach ($list as $value) {
            $totalcount += $value->count;
            $totalamount += $value->totalprice;
        }
        return [
            'period' => $period,
            'para' => $para,
            'list' => $list,
            'totalcount' => $totalcount,
            'totalamount' => $totalamount,
        ];
    }

    public function export($period, $para) {
        $data = $this->listing($period, $para);
        $list = $data['list'];
        $totalcount = $data['totalcount'];
        $totalamount = $data['totalamount'];
        $cellData = null;
        if ($para == 1) {
            $cellData[] = ['类别', '名称', '品牌', '销售数量', '销售金额'];
            foreach ($list as $item) {
                $cellData[] = [$item->type, $item->gname, $item->brand, $item->count, $item->totalprice];
            }
            $cellData[] = ['合计', '', '', $totalcount, $totalamount];
        } else {
            $cellData[] = ['品牌', '销售数量', '销售金额'];
            foreach ($list as $item) {
                $cellData[] = [$item->brand, $item->count, $item->totalprice];
            }
            $cellData[] = ['合计', $totalcount, $totalamount];
        }
        return Excel::create('销售统计', function ($excel) use ($cellData) {
            $excel->sheet('statistics', function ($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    public function listView($period, $para) {
        return view('admin.sale.list', $this->listing($period, $para));
    }
}