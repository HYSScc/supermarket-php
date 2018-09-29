@extends('admin.layouts')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <!-- /.row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            @if($type == 1)
                                <h3 class="box-title">服装类商品</h3>
                            @else
                                <h3 class="box-title">食品类商品</h3>
                            @endif
                        </div>
                        <!-- /.box-header -->
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
                                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;管理</th>
                                </tr>
                                @foreach($list as $goods)
                                    <tr>
                                        <td>{{ $goods->gname }}</td>
                                        <td>{{ $goods->brand }}</td>
                                        @if($type == 1)
                                            <td>{{ $goods->color }}</td>
                                            <td>{{ $goods->size }}</td>
                                            <td>{{ $goods->crowd }}</td>
                                        @else
                                            <td>{{ $goods->deadline }}</td>
                                            <td>{{ $goods->provenance }}</td>
                                        @endif
                                        <td>{{ $goods->price }}</td>
                                        <td>{{ $goods->count }}</td>
                                        <td>
                                            <a href="{{ url('admin/goods/stock/' . $goods->gid) }}"><span class="badge bg-green"> 进货</span></a>
                                            <a href="{{ url('admin/undercarriage/goods/' . $goods->gid) }}"><span class="badge bg-light-blue"> 下架</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        {!! $list->links() !!}
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
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
<!-- page script -->
<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
@stop