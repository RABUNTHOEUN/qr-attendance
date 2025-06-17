<!DOCTYPE html>
<html>

<head>
    <title>Scan QR</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>

<body>
    <h2>📷 ស្កេន QR Code ដើម្បីចុះវត្តមាន</h2>

    <div id="reader" style="width: 300px;"></div>

    <form method="POST" action="{{ route('attendance.submit') }}" id="form">
        @csrf
        <input type="hidden" name="student_id" id="student_id">
    </form>

    <p id="message" style="color: red;"></p>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            let studentId = decodedText;

            // ✅ Extract student ID if decodedText is a full URL
            try {
                const url = new URL(decodedText);
                const parts = url.pathname.split("/");
                studentId = parts[parts.length - 1]; // Last part of path
            } catch (e) {
                // Not a URL, use as-is
            }

            // ✅ Call your backend to check the student ID
            fetch('http://127.0.0.1:8000/check-student/' + studentId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Invalid response from server');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.exists) {
                        document.getElementById("student_id").value = studentId;
                        document.getElementById("form").submit();
                        // alert("✅ អត្តសញ្ញាណសិស្សបានរកឃើញ និងបានចុះវត្តមានរួចរាល់!");
                    } else {
                        document.getElementById("message").innerText = "❌ អត្តសញ្ញាណសិស្សមិនមានទេ!";
                    }
                })
                .catch(error => {
                    console.error(error);
                    document.getElementById("message").innerText = "🚫 មានបញ្ហាក្នុងការតភ្ជាប់!";
                });
        }

        const html5QrCode = new Html5Qrcode("reader");
        const config = {
            fps: 10,
            qrbox: 250
        };

        html5QrCode.start(
            { facingMode: "environment" },
            config,
            onScanSuccess
        ).catch(err => {
            console.error("Camera error:", err);
            document.getElementById("message").innerText = "🚫 មិនអាចប្រើកាមេរ៉ាថតបានទេ។";
        });
    </script>
</body>

</html>
