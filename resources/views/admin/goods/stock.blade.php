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
                            <h3 class="box-title">进货</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ url('admin/goods/stock/' . $goods->gid) }}">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group">
                                    <label>名称</label>
                                    <input type="text" class="form-control" placeholder="{{ $goods->gname }}" disabled="">
                                </div>
                                <div class="form-group">
                                    <label>品牌</label>
                                    <input type="text" class="form-control" placeholder="{{ $goods->brand }}" disabled="">
                                </div>
                                @if($goods->type == 1)
                                    <div class="form-group">
                                        <label>颜色</label>
                                        <input type="text" class="form-control" placeholder="{{ $goods->color }}" disabled="">
                                    </div>
                                    <div class="form-group">
                                        <label>大小</label>
                                        <input type="text" class="form-control" placeholder="{{ $goods->size }}" disabled="">
                                    </div>
                                    <div class="form-group">
                                        <label>适合人群</label>
                                        <input type="text" class="form-control" placeholder="{{ $goods->crowd }}" disabled="">
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label>保质期截止日期</label>
                                        <input type="text" class="form-control" placeholder="{{ $goods->deadline }}" disabled="">
                                    </div>
                                    <div class="form-group">
                                        <label>产地</label>
                                        <input type="text" class="form-control" placeholder="{{ $goods->provenance }}" disabled="">
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>价格</label>
                                    <input type="text" class="form-control" placeholder="{{ $goods->price }}" disabled="">
                                </div>
                                <div class="form-group">
                                    <label>数量</label>
                                    <input type="text" class="form-control" placeholder="{{ $goods->count }}" disabled="">
                                </div>
                                <div class="form-group">
                                    <label>进货数量</label>
                                    <input type="text" name="count" class="form-control">
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">确认进货</button>
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