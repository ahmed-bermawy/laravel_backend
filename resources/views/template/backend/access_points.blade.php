@extends('template.backend.admin_template')
@section('content')

<!-- Donut chart -->
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">{{$page_title}} Chart </h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body chart-responsive">
    <div class="chart" id="access-points-chart" style="height: 300px; position: relative;"></div>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->

<div class="clear"></div>
<div class="table-responsive">

  {!! create_table('allAccessPoints','All Access Points',$header,$all_access_points) !!}
  
  {!! create_table('allUnplacedAccessPoints','All Unplaced Access Points',$header,$all_unplaced_access_points) !!}
  
  @if(isset($message))
    {!! message_pop_up_window($message) !!}
  @endif

@stop

@section('plugins')
<script type="text/javascript">
$(document).ready(function(){
  $('#allAccessPoints').DataTable();
  $('#allUnplacedAccessPoints').DataTable();

  var donut = new Morris.Donut({
    element: 'access-points-chart',
    resize: true,
    colors: ["#3c8dbc",'#ff0000'],
    data: [
      {label: "Placed Access Points", value: <?php echo $all_placed_access_points_count; ?>},
      {label: "Unplaced Access Points", value: <?php echo $all_unplaced_access_points_count; ?>},
    ],
    hideHover: 'auto'
  });
}); 
</script>
@stop