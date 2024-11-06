<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
      <table>
    <thead>
        <tr>
            <th>Variant Name</th>
            <th>Expiry Date</th>
            <th>LOT</th>
            <th>Stock Uploaded - Adult</th>
            <th>Stock Uploaded - Child</th>
            <th>Stock Uploaded - Both</th>
            <th>Stock Allotted - Adult</th>
            <th>Stock Allotted - Child</th>
            <th>Stock Allotted - Both</th>
            <th>Stock Left - Adult</th>
            <th>Stock Left - Child</th>
            <th>Stock Left - Both</th>
            <th>Stock Pending for Allotment - Adult</th>
            <th>Stock Pending for Allotment - Child</th>
            <th>Stock Pending for Allotment - Both</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $record)
        <tr>
            <td>{{ @$record->variant->title}}</td>
            <td>{{ $record->valid_till ? date(config('app.date_format'), strtotime($record->valid_till)) : '' }}</td>
            <td></td>
            <td>{{ @$record->stock_uploaded_adult }}</td>
            <td>{{ @$record->stock_uploaded_child }}</td>
            <td>{{ @$record->stock_uploaded_both }}</td>
            <td>{{ @$record->stock_allotted_adult }}</td>
            <td>{{ @$record->stock_allotted_child }}</td>
            <td>{{ @$record->stock_allotted_both }}</td>
            <td>{{ @$record->stock_left_adult }}</td>
            <td>{{ @$record->stock_left_child }}</td>
            <td>{{ @$record->stock_left_both }}</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        @endforeach
    </tbody>
</table>
				</body>
</html>