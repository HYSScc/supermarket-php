@extends('admin.layouts')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            @if($type == 1)
                                <h3 class="box-title">添加服装类商品</h3>
                            @else
                                <h3 class="box-title">添加食品类商品</h3>
                            @endif
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ url('admin/goods/add/' . $type) }}">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group">
                                    <label>名称</label>
                                    <input type="text" name="gname" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>品牌</label>
                                    <input type="text" name="brand" class="form-control">
                                </div>
                                @if($type == 1)
                                    <div class="form-group">
                                        <label>颜色</label>
                                        <input type="text" name="color" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>大小</label>
                                        <input type="text" name="size" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>适合人群</label>
                                        <input type="text" name="crowd" class="form-control">
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label>保质期截止日期</label>
                                        <input type="text" name="deadline" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>产地</label>
                                        <input type="text" name="provenance" class="form-control">
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>价格</label>
                                    <input type="text" name="price" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>数量</label>
                                    <input type="text" name="count" class="form-control">
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">确认添加</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@stop

@section('js')
<!-- jQuery 2.2.3 -->
<script src="/AdminLTE-2.3.11/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/AdminLTE-2.3.11/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/AdminLTE-2.3.11/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/AdminLTE-2.3.11/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/AdminLTE-2.3.11/dist/js/demo.js"></script>
@stop