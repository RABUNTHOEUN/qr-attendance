<h2>បញ្ជីវត្តមានសិស្ស</h2>
<table border="1">
    <tr>
        <th>Student ID</th>
        <th>Name</th>
        <th>Date</th>
        <th>Time</th>
    </tr>
    @foreach ($attendances as $attendance)
        <tr>
            <td>{{ $attendance->student->student_id }}</td>
            <td>{{ $attendance->student->name }}</td>
            <td>{{ $attendance->created_at->format('Y-m-d') }}</td>
            <td>{{ $attendance->created_at->format('H:i:s') }}</td>
        </tr>
    @endforeach
</table>
