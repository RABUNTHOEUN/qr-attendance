<!DOCTYPE html>
<html>

<head>
    <title>Scan QR</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>

<body>
    <h2>📷 ស្កេន QR Code ដើម្បីចុះវត្តមាន</h2>

    <!-- Camera selector dropdown -->
    <label for="camera-select">📸 ជ្រើសរើសកាមេរ៉ា:</label>
    <select id="camera-select" style="margin-bottom: 10px;"></select>

    <!-- QR Reader -->
    <div id="reader" style="width: 300px;"></div>

    <!-- Attendance form -->
    <form method="POST" action="{{ route('attendance.submit') }}" id="form">
        @csrf
        <input type="hidden" name="student_id" id="student_id">
    </form>

    <p id="message" style="color: red;"></p>

    <script>
        let html5QrCode = new Html5Qrcode("reader");
        const config = { fps: 10, qrbox: 250 };

        function onScanSuccess(decodedText, decodedResult) {
            let studentId = decodedText;

            // Try to extract ID from URL
            try {
                const url = new URL(decodedText);
                const parts = url.pathname.split("/");
                studentId = parts[parts.length - 1]; // Last part
            } catch (e) {
                // Not a URL, use as-is
            }

            fetch('http://127.0.0.1:8000/check-student/' + studentId)
                .then(response => {
                    if (!response.ok) throw new Error('Invalid response from server');
                    return response.json();
                })
                .then(data => {
                    if (data.exists) {
                        document.getElementById("student_id").value = studentId;
                        document.getElementById("form").submit();
                    } else {
                        document.getElementById("message").innerText = "❌ អត្តសញ្ញាណសិស្សមិនមានទេ!";
                    }
                })
                .catch(error => {
                    console.error(error);
                    document.getElementById("message").innerText = "🚫 មានបញ្ហាក្នុងការតភ្ជាប់!";
                });
        }

        function startScanner(cameraId) {
            html5QrCode.start(
                cameraId,
                config,
                onScanSuccess
            ).catch(err => {
                console.error("Start scan error:", err);
                document.getElementById("message").innerText = "🚫 មិនអាចចាប់ផ្តើមកាមេរ៉ាបានទេ!";
            });
        }

        Html5Qrcode.getCameras().then(cameras => {
            const cameraSelect = document.getElementById("camera-select");

            if (cameras.length === 0) {
                cameraSelect.innerHTML = "<option>🚫 មិនមានកាមេរ៉ាទេ</option>";
                return;
            }

            cameras.forEach((camera, index) => {
                const option = document.createElement("option");
                option.value = camera.id;
                option.text = camera.label || `Camera ${index + 1}`;
                cameraSelect.appendChild(option);
            });

            // Start with the first camera by default
            startScanner(cameras[0].id);

            // On camera change
            cameraSelect.addEventListener("change", function () {
                html5QrCode.stop().then(() => {
                    startScanner(this.value);
                }).catch(err => {
                    console.error("Stop camera error:", err);
                });
            });
        }).catch(err => {
            console.error("Camera fetch error:", err);
            document.getElementById("message").innerText = "🚫 មិនអាចទាញយកបញ្ជីកាមេរ៉ាបានទេ!";
        });
    </script>
</body>

</html>
