@extends('admin.layouts')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <form role="form" method="post" action="{{ url('admin/search/' . $type) }}">
                    {{ csrf_field() }}
                    <div class="col-md-1 col-sm-6 col-xs-12">
                        <input type="text" name="gname" class="form-control" placeholder="名称">
                    </div>
                    <!-- /.col -->
                    <div class="col-md-1 col-sm-6 col-xs-12">
                        <input type="text" name="brand" class="form-control" placeholder="品牌">
                    </div>
                    @if($type == 1)
                        <!-- /.col -->
                        <div class="col-md-1 col-sm-6 col-xs-12">
                            <input type="text" name="color" class="form-control" placeholder="颜色">
                        </div>
                        <!-- /.col -->
                        <div class="col-md-1 col-sm-6 col-xs-12">
                            <input type="text" name="size" class="form-control" placeholder="大小">
                        </div>
                        <!-- /.col -->
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <input type="text" name="crowd" class="form-control" placeholder="适合人群">
                        </div>
                    @else
                        <!-- /.col -->
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <input type="date" name="deadline" class="form-control" placeholder="保质期截止日期">
                            </div>
                            <!-- /.col -->
                            <div class="col-md-1 col-sm-6 col-xs-12">
                                <input type="text" name="provenance" class="form-control" placeholder="产地">
                            </div>
                    @endif
                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <input type="date" name="starttime" class="form-control" placeholder="起始日期">
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <input type="date" name="endtime" class="form-control" placeholder="截止日期">
                    </div>
                    <!-- /.col -->
                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <button type="submit" class="btn btn-default">搜索</button>
                    </div>
                    <!-- /.col -->
                </form>
            </div>
            <!-- /.row -->
            <br>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">搜索结果</h3>
                        </div>
                        <!-- /.box-header -->
                        @if($method == 'post')
                            <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>名称</th>
                                    <th>品牌</th>
                                    @if($type == 1)
                                        <th>颜色</th>
                                        <th>大小</th>
                                        <th>适合人群</th>
                                    @else
                                        <th>保质期截止日期</th>
                                        <th>产地</th>
                                    @endif
                                    <th>价格</th>
                                    <th>数量</th>
                                    @if(count($sales) > 0)
                                        <th>销售数量</th>
                                        <th>销售金额</th>
                                    @endif
                                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;管理</th>
                                </tr>
                                @for($i = 0; $i < count($list); $i++)
                                    <tr>
                                        <td>{{ $list[$i]->gname }}</td>
                                        <td>{{ $list[$i]->brand }}</td>
                                        @if($type == 1)
                                            <td>{{ $list[$i]->color }}</td>
                                            <td>{{ $list[$i]->size }}</td>
                                            <td>{{ $list[$i]->crowd }}</td>
                                        @else
                                            <td>{{ $list[$i]->deadline }}</td>
                                            <td>{{ $list[$i]->provenance }}</td>
                                        @endif
                                        <td>{{ $list[$i]->price }}</td>
                                        <td>{{ $list[$i]->count }}</td>
                                        @if(count($sales) > 0)
                                            <th>{{ $sales[$i]['salecount'] }}</th>
                                            <th>{{ $sales[$i]['totalprice'] }}</th>
                                        @endif
                                        <td>
                                            <a href="{{ url('admin/goods/stock/' . $list[$i]->gid) }}"><span class="badge bg-green"> 进货</span></a>
                                            <a href="{{ url('admin/undercarriage/goods/' . $list[$i]->gid) }}"><span class="badge bg-light-blue"> 下架</span></a>
                                        </td>
                                    </tr>
                                @endfor
                            </table>
                        </div>
                        @endif
                    <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop

@section('js')
<!-- jQuery 2.2.3 -->
<script src="/AdminLTE-2.3.11/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/AdminLTE-2.3.11/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="/AdminLTE-2.3.11/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/AdminLTE-2.3.11/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/AdminLTE-2.3.11/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/AdminLTE-2.3.11/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/AdminLTE-2.3.11/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/AdminLTE-2.3.11/dist/js/demo.js"></script>
@stop