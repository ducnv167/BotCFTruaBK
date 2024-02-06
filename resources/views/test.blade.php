<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Món Ăn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .step-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 20px;
            background-color: #f2f2f2;
        }

        .step {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .step:hover {
            background-color: #45a049;
        }

        .step.active {
            background-color: #008CBA;
        }

        .content {
            display: none;
            max-width: 600px;
            margin: auto;
        }

        button {
            background-color: #008CBA;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #004C6D;
        }
    </style>
</head>

<body>

    <div class="step-container">
        <button class="step" onclick="showStep(1)">Bước 1</button>
        <button class="step" onclick="showStep(2)">Bước 2</button>
        <button class="step" onclick="showStep(3)">Bước 3</button>
        <button class="step" onclick="showStep(4)">Bước 4</button>
    </div>

    <div id="step1" class="content">
        <h2>Bước 1: Chọn bữa và nhập số người ăn</h2>
        <!-- Thêm các input, nút next và previous cho bước 1 -->
        <button onclick="nextStep(1)">Next</button>
    </div>

    <div id="step2" class="content">
        <h2>Bước 2: Chọn nhà hàng</h2>
        <!-- Thêm các input, nút next, nút previous cho bước 2 -->
        <button onclick="nextStep(2)">Next</button>
        <button onclick="prevStep(2)">Previous</button>
    </div>

    <div id="step3" class="content">
        <h2>Bước 3: Chọn món ăn và đặt thứ tự</h2>
        <!-- Thêm các input, nút next, nút previous cho bước 3 -->
        <button onclick="nextStep(3)">Next</button>
        <button onclick="prevStep(3)">Previous</button>
    </div>

    <div id="step4" class="content">
        <h2>Bước 4: Xem lại thông tin đặt món</h2>
        <!-- Hiển thị toàn bộ thông tin đặt món từ bước 1 đến bước 3 -->
        <button onclick="prevStep(4)">Previous</button>
    </div>

    <script>
        let currentStep = 1;

        function showStep(stepNumber) {
            document.getElementById(`step${currentStep}`).style.display = "none";
            document.getElementById(`step${stepNumber}`).style.display = "block";
            currentStep = stepNumber;
            updateStepButtons();
        }

        function nextStep(stepNumber) {
            showStep(stepNumber + 1);
        }

        function prevStep(stepNumber) {
            showStep(stepNumber - 1);
        }

        function updateStepButtons() {
            for (let i = 1; i <= 4; i++) {
                const button = document.querySelector(`.step:nth-child(${i})`);
                if (i < currentStep) {
                    button.classList.remove("active");
                } else if (i === currentStep) {
                    button.classList.add("active");
                } else {
                    button.classList.remove("active");
                }
            }
        }

        updateStepButtons();
    </script>

</body>

</html>
