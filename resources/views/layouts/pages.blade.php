<!DOCTYPE html>
<html lang="en">
<head>
@include('inc.head')
 <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>

 <link href="{{asset('bootstrap-fileinput/css/fileinput.min.css')}}" rel="stylesheet">
   <link href="{{asset('bootstrap-fileinput/themes/explorer-fa/theme.min.css')}}" rel="stylesheet">
   <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css" rel="stylesheet" type="text/css" />
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" integrity="sha256-yMjaV542P+q1RnH6XByCPDfUFhmOafWbeLPmqKh11zo=" crossorigin="anonymous" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
<link href="{{asset('dist/css/owl.carousel.min.css')}}" rel="stylesheet">
	<link href="{{asset('dist/css/owl.theme.default.min.css')}}" rel="stylesheet">
  <link href="{{asset('dist/css/custom.css')}}" rel="stylesheet">
<style>
  .content-wrapper
  {
    margin:0px!important;
  }
</style>
</head>
<body class="hold-transition">
<!-- Site wrapper -->
<div class="wrapper">
<div id="loader-overlay">
  <div class="loader"></div>
</div>
  <!-- Navbar -->
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->

  <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
      	<!-- Show error and messages -->
	    @include('inc.errors-and-messages')
	    @yield('content')

  <!-- /.content-wrapper -->


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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('bootstrap-fileinput/js/plugins/piexif.js')}}"></script>
  <script src="{{asset('bootstrap-fileinput/js/fileinput.js')}}"></script>
<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
    
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha256-5YmaxAwMjIpMrVlK84Y/+NjCpKnFYa8bWWBbUHSBGfU=" crossorigin="anonymous"></script>
<!-- AdminLTE for demo purposes -->
<!--script src="{{asset('dist/js/demo.js')}}"></script-->
<script src="{{ asset('dist/js/owl.carousel.min.js') }}"></script>
<script>
  $(function () {
  $("#loader-overlay").hide();
   $('.select2').select2()
   $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "bFilter": true, // show search input
    });

    $('#txt_example2_filter').keyup(function() {
    var table = $('#example2').DataTable();
    table.search($(this).val()).draw();
});
	
	$('.dataTable').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": true,
      "responsive": true,
      "bFilter": true, // show search input
    });

$('.datepicker').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
		dateFormat: 'yy-mm-dd'
    });
$('.timepicker').datetimepicker({
            format: 'hh:mm a'
        });
  });
  
  $('.datepickerdiscurdate').datepicker({
        weekStart: 1,
		minDate: 0,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
		dateFormat: 'yy-mm-dd'
    });
  
 $('.datepickerAgent').datepicker({
        weekStart: 1,
		minDate: 0,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
		dateFormat: 'dd-mm-yy'
    });
	
	$('.datepickerdmy').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
		dateFormat: 'dd-mm-yy'
    });

</script>
<!-- Google tag (gtag.js) -->

@yield('scripts')
</body>
</html>
