<h2>Student List with QR Code</h2>
@foreach ($students as $student)
    <div>
        <p>{{ $student->name }} ({{ $student->student_id }})</p>
        {!! QrCode::size(150)->generate(route('attendance.form', $student->student_id)) !!}
    </div>
@endforeach
