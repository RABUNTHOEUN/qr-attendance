<h2>ចុះវត្តមានសម្រាប់ {{ $student->name }}</h2>

<form method="POST" action="{{ route('attendance.submit') }}">
    @csrf
    <input type="hidden" name="student_id" value="{{ $student->student_id }}">
    <button type="submit">ចុះវត្តមាន</button>
</form>
