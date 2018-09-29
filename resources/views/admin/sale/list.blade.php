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
                            @if($para == 1)
                                <h3 class="box-title"> 每种商品的销售情况 /<a href="{{ url('admin/sale/' . $period . '/list/' . 2) }}"> 每个品牌的销售情况</a></h3>
                            @else
                                <h3 class="box-title"><a href="{{ url('admin/sale/' . $period . '/list/' . 1) }}"> 每种商品的销售情况</a> / 每个品牌的销售情况</h3>
                             @endif
                            <div class="box-tools">
                                <a href="{{ url('admin/sale/' . $period . '/export/' . $para) }}" class="btn btn-default">导出</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                @if($para == 1)
                                    <tbody>
                                    <tr>
                                        <th>类别</th>
                                        <th>名称</th>
                                        <th>品牌</th>
                                        <th>销售数量</th>
                                        <th>销售金额</th>
                                    </tr>
                                    @foreach($list as $value)
                                        <tr>
                                            <td>{{ $value->type }}</td>
                                            <td>{{ $value->gname }}</td>
                                            <td>{{ $value->brand }}</td>
                                            <td>{{ $value->count }}</td>
                                            <td>{{ $value->totalprice }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>合计</th>
                                        <th></th>
                                        <th></th>
                                        <th>{{ $totalcount }}</th>
                                        <th>{{ $totalamount }}</th>
                                    </tr>
                                    </tfoot>
                                @else
                                    <tbody>
                                    <tr>
                                        <th>品牌</th>
                                        <th>销售数量</th>
                                        <th>销售金额</th>
                                    </tr>
                                    @foreach($list as $value)
                                        <tr>
                                            <td>{{ $value->brand }}</td>
                                            <td>{{ $value->count }}</td>
                                            <td>{{ $value->totalprice }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>合计</th>
                                        <th>{{ $totalcount }}</th>
                                        <th>{{ $totalamount }}</th>
                                    </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
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