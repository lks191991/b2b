<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
          <table id="example1" class="table table-bordered table-striped">
				<thead>
          <tr>
            <th>Service Type</th>
            <th>Code</th>
                      <th>Name</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Company</th>
                      <th>City</th>
                      <th>Zip</th>
                     
                    </tr>
				  
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
                  <tr>
                  <td>{{ $record->service_type}}</td>
                    <td>{{ $record->code}}</td>
                    <td>{{ $record->name}}</td>
                    <td>{{ $record->mobile}}</td>
                  <td>{{ $record->email}}</td>
                    <td>{{ $record->company_name}}</td>
                    <td>{{ ($record->city)?$record->city->name:''}}</td>
                    <td>{{ $record->zip_code}}</td>
                  </tr>

                  @endforeach
                  </tbody>
                </table>
				</body>
</html>