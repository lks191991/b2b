@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Jobs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Jobs</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Jobs</h3>
                <div class="card-tools">
                  <button id="startJobsBtn" class="btn btn-primary">Start Tour Data Sync</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="jobStatus" class="alert d-none"></div> <!-- Alert message -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <script>
      $(document).ready(function() {
          $('#startJobsBtn').click(function() {
              let button = $(this);
              button.prop('disabled', true).text('Processing...'); 
              let jobStatus = $('#jobStatus');

              jobStatus.removeClass('d-none alert-success alert-danger').addClass('alert alert-warning').text('Processing jobs... Please wait.');

              $.ajax({
                  url: "{{ route('processTourJobs') }}",
                  type: "POST",
                  data: {
                      _token: "{{ csrf_token() }}"
                  },
                  success: function(response) {
                      if (response.success) {
                          jobStatus.removeClass('alert-warning alert-danger').addClass('alert alert-success').text(response.message);
                      } else {
                          jobStatus.removeClass('alert-warning alert-success').addClass('alert alert-danger').text(response.message);
                          button.prop('disabled', false).text('Start Tour Data Sync'); 
                      }
                  },
                  error: function() {
                      jobStatus.removeClass('alert-warning alert-success').addClass('alert alert-danger').text('An error occurred while dispatching jobs.');
                      button.prop('disabled', false).text('Start Tour Data Sync'); 
                  }
              });
          });
      });
    </script>

@endsection
