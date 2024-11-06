@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Content Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Content Settings</li>
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
                <h3 class="card-title">Content Settings</h3>
				<div class="card-tools">
				
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Title</th>
                    <th>Content</th>
                   
                    <th>Updated</th>
					<th width="17%"></th>
                  </tr>
				 
                  </thead>
                  <tbody>
                  @foreach ($pages as $page)
				  
                  <tr>
                    <td>{{$page->title}}</td>
                    <td>{!!$page->page_content!!}</td>
                    <td>{{ $page->updated_at ? date(config('app.date_format'),strtotime($page->updated_at)) : null }}</td>
					 
                     <td>
					 
					 
					 <a class="btn btn-info btn-sm" href="{{route('pages.edit',$page->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
                       </td>
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
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
@endsection

@section('scripts')

<script type="text/javascript">
    $(function () {
        $('#course-list').dataTable(
			{
            "order": [[ 0, "asc" ]],
            "columns": [
              null,
              null,
             { "orderable": false },
			  null,
              { "orderable": false }
            ],
			initComplete: function () {
            this.api().columns([2]).every( function () {
                var column = this;
                var select = $('<select class="custom-select"><option value="">All</option></select>')
                    .appendTo( $(column.header()) )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
          }
		);
    });
</script>
@endsection