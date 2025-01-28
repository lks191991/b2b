<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
                <table id="" class="table rounded-corners table-bordered">
                  <thead>
                  <tr>
					<th>Rate Valid From</th>
					<th>Rate Valid To</th>
					<th>Activity</th>
					<th>Variant</th>
                    <th>Adult R/Wo Vat</th>
					<th>Adult R/W Vat</th>
                  </tr>
                  </thead>
                  <tbody>
				  @foreach ($records as $k => $record)
                  <tr>
					 <td>{{ $record->rate_valid_from ? date(config('app.date_format'),strtotime($record->rate_valid_from)) : null }}</td>
                    <td>{{ $record->rate_valid_to ? date(config('app.date_format'),strtotime($record->rate_valid_to)) : null }}</td>
					<td>{{ @$record->av->activity->title}}</td>
					<td>{{ @$record->av->variant->title}}</td>
                    <td>{{ $record->adult_rate_without_vat}}</td>
					<td>{{ $record->adult_rate_with_vat}}</td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
				</body>
</html>