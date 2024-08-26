<h1>Timesheets</h1>
<table>
    <thead>
        <th>Calendar</th>
        <th>Type</th>
        <th>Day in</th>
        <th>Day out</th>
    </thead>
    <tbody>
        @foreach ($timesheet as $item)
        <tr>
            <td>{{$item->calendar->name}}</td>
            <td>{{$item->type}}</td>
            <td>{{$item->day_in}}</td>
            <td>{{$item->day_out}}</td>
        </tr>
        @endforeach
    </tbody>

</table>