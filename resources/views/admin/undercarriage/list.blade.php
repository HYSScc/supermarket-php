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
                            <h3 class="box-title">下架列表</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>名称</th>
                                    <th>品牌</th>
                                    <th>下架时间</th>
                                    <th>下架原因</th>
                                </tr>
                                @foreach($list as $goods)
                                    <tr>
                                        <td>{{ $goods['gname'] }}</td>
                                        <td>{{ $goods['brand'] }}</td>
                                        <td>{{ $goods['undtime'] }}</td>
                                        <td>{{ $goods['reason'] }}</td>
                                    </tr>
                                @endforeach
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