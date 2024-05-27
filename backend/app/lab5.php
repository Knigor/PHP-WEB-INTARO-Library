<!DOCTYPE html>
<html>
<head>
    <title>Калькулятор AΣ и C Матриц</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #444;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .button-group {
            display: flex;
            gap: 10px;
        }

        input[type="submit"], input[type="reset"] {
            background: #5cb85c;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="reset"] {
            background: #d9534f;
        }

        input[type="submit"]:hover {
            background: #4cae4c;
        }

        input[type="reset"]:hover {
            background: #c9302c;
        }

        table {
            width: auto;
            max-width: 80%;
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        h3 {
            margin-top: 40px;
            color: #555;
        }
    </style>
</head>
<body>
<h2>Расчитываем AΣ и C Матрицы</h2>
<form method="post" action="">
    <label for="adjacency_matrix">Вводим Матрицу смежности (разделяя  пробелами):</label><br>
    <textarea id="adjacency_matrix" name="adjacency_matrix" rows="5" cols="50"></textarea><br><br>
    <div class="button-group">
        <input type="submit" name="submit" value="Расчитать">
        
    </div>
</form>
<br>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        // Function to perform matrix subtraction
        function matrixSubtraction($matrix1, $matrix2) {
            $result = array();

            // Check if the matrices have the same dimensions
            if (count($matrix1) != count($matrix2) || count($matrix1[0]) != count($matrix2[0])) {
                return "Matrices must have the same dimensions for subtraction";
            }

            for ($i = 0; $i < count($matrix1); $i++) {
                for ($j = 0; $j < count($matrix1[$i]); $j++) {
                    $result[$i][$j] = $matrix1[$i][$j] - $matrix2[$i][$j];
                }
            }

            return $result;
        }

        // Function to calculate AΣ matrix
        function calculateASigma($adjacency_matrix) {
            $n = count($adjacency_matrix);
            $A = $adjacency_matrix;
            $A1 = $adjacency_matrix;

            for ($i = 0; $i < $n; $i++) {
                $A = matrixAddition($A, matrixPower($A1, $i + 1));
            }
            $A = matrixSubtraction($A, $adjacency_matrix);
            return $A;
        }

        // Function to calculate C matrix
        function calculateC($A) {
            $n = count($A);
            $C = array();

            for ($i = 0; $i < $n; $i++) {
                for ($j = 0; $j < $n; $j++) {
                    $C[$i][$j] = ($A[$i][$j] >= 1) ? 1 : 0;
                }
            }

            return $C;
        }

        // Function to perform matrix addition
        function matrixAddition($matrix1, $matrix2) {
            $result = array();

            for ($i = 0; $i < count($matrix1); $i++) {
                for ($j = 0; $j < count($matrix1[$i]); $j++) {
                    $result[$i][$j] = $matrix1[$i][$j] + $matrix2[$i][$j];
                }
            }

            return $result;
        }

        // Function to calculate the power of a matrix
        function matrixPower($matrix, $power) {
            $result = $matrix;

            for ($i = 1; $i < $power; $i++) {
                $result = matrixMultiplication($result, $matrix);
            }

            return $result;
        }

        // Function to perform matrix multiplication
        function matrixMultiplication($matrix1, $matrix2) {
            $result = array();

            for ($i = 0; $i < count($matrix1); $i++) {
                for ($j = 0; $j < count($matrix2[0]); $j++) {
                    $result[$i][$j] = 0;
                    for ($k = 0; $k < count($matrix1[0]); $k++) {
                        $result[$i][$j] += $matrix1[$i][$k] * $matrix2[$k][$j];
                    }
                }
            }

            return $result;
        }

        // Handle form submission
        $adjacency_matrix_input = $_POST["adjacency_matrix"];
        $adjacency_matrix_rows = explode("\n", $adjacency_matrix_input);
        $adjacency_matrix = array();

        foreach ($adjacency_matrix_rows as $row) {
            $adjacency_matrix[] = array_map('intval', preg_split("/[\s,]+/", trim($row)));
        }

        // Calculate AΣ and C matrices
        $A_sigma = calculateASigma($adjacency_matrix);
        $C = calculateC($A_sigma);

        // Display AΣ matrix
        echo "<h3>Матрица AΣ:</h3>";
        echo "<table>";
        echo "<tr><th>#</th>";
        for ($i = 0; $i < count($A_sigma[0]); $i++) {
            echo "<th>" . ($i + 1) . "</th>";
        }
        echo "</tr>";
        foreach ($A_sigma as $row_index => $row) {
            echo "<tr><th>" . ($row_index + 1) . "</th>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        // Display C matrix
        echo "<h3>Матрица C:</h3>";
        echo "<table>";
        echo "<tr><th>#</th>";
        for ($i = 0; $i < count($C[0]); $i++) {
            echo "<th>" . ($i + 1) . "</th>";
        }
        echo "</tr>";
        foreach ($C as $row_index => $row) {
            echo "<tr><th>" . ($row_index + 1) . "</th>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
}
?>
</body>
</html>
