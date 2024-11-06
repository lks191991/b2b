<!DOCTYPE html>
<html lang="en">
<head>
@include('inc.head')
 <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>

   <link href="{{asset('bootstrap-fileinput/themes/explorer-fa/theme.min.css')}}" rel="stylesheet">
   <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css" rel="stylesheet" type="text/css" />
      

</head>
<body class="hold-transition sidebar-mini">
<div class="row">
    @foreach($files as $file)
    <div class="col-sm-3">        
      <div class="box box-solid">
        <div class="box-body">
        <a href="/uploads/images/{{$file['basename']}}">
            <img src='{{asset("uploads/images/".$file["basename"])}}' style="max-width: 100%">
        </a>
        </div>    
      </div>
    </div>
    @endforeach
</div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>


<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>

<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
 
<!-- AdminLTE for demo purposes -->
<!--script src="{{asset('dist/js/demo.js')}}"></script-->

<script>
  $(function () {
   $('.select2').select2()
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
	
	$('.dataTable').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });

$('.datepicker').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
		format: 'yyyy-mm-dd'
    });
$('.timepicker').datetimepicker({
            format: 'hh:mm a'
        });
  });

</script>
<script type="text/javascript">
$('a[href]').on('click', function(e){
  e.preventDefault();
  window.opener.CKEDITOR.tools.callFunction(<?php echo $test; ?>,$(this).attr('href'));
  window.close();
});
</script>
</body>
</html>
