<?php 
// Initialize variables to empty strings
$investment = $interest_rate = $years = "";
$future_value = $investment_f = $yearly_rate_f = $future_value_f = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the form
    $investment = filter_input(INPUT_POST, 'investment', FILTER_VALIDATE_FLOAT);
    $interest_rate = filter_input(INPUT_POST, 'interest_rate', FILTER_VALIDATE_FLOAT);
    $years = filter_input(INPUT_POST, 'years', FILTER_VALIDATE_INT);

    // Validate input and calculate future value if all inputs are valid
    $error_message = '';
    if ($investment === FALSE || $investment <= 0) {
        $error_message .= 'Investment must be a valid number greater than zero.<br>';
    } 
    if ($interest_rate === FALSE || $interest_rate <= 0 || $interest_rate > 15) {
        $error_message .= 'Interest rate must be a valid number between 0 and 15.<br>';
    }
    if ($years === FALSE || $years <= 0 || $years > 30) {
        $error_message .= 'Years must be a valid number between 1 and 30.<br>';
    }

    if (empty($error_message)) {
        $future_value = $investment;
        for ($i = 1; $i <= $years; $i++) {
            $future_value += $future_value * $interest_rate * .01;
        }
        $investment_f = '$' . number_format($investment, 2);
        $yearly_rate_f = $interest_rate . '%';
        $future_value_f = '$' . number_format($future_value, 2);

        // Clear the form values
        $investment = $interest_rate = $years = "";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Future Value Calculator</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <main>
    <h1>Future Value Calculator</h1>
    <?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php } ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div id="data">
            <label>Investment Amount:</label>
            <input type="text" name="investment" value="<?php echo htmlspecialchars($investment); ?>">
            <br>

            <label>Yearly Interest Rate:</label>
            <input type="text" name="interest_rate" value="<?php echo htmlspecialchars($interest_rate); ?>">
            <br>

            <label>Number of Years:</label>
            <input type="text" name="years" value="<?php echo htmlspecialchars($years); ?>">
            <br>
        </div>

        <div id="buttons">
            <label>&nbsp;</label>
            <input type="submit" value="Calculate"><br>
        </div>

    </form>
    <?php if (!empty($future_value_f)) { ?>
        <p>Investment Amount: <?php echo $investment_f; ?></p>
        <p>Yearly Interest Rate: <?php echo $yearly_rate_f; ?></p>
        <p>Number of Years: <?php echo $years; ?></p>
        <p>Future Value: <?php echo $future_value_f; ?></p>
    <?php } ?>
    </main>
</body>
</html>
