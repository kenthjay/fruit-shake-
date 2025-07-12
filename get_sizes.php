<?php
include("connection/connect.php");

if (isset($_POST['dish_id'])) {
    $dish_id = intval($_POST['dish_id']);
    $query = mysqli_query($db, "SELECT price_small, price_medium, price_large FROM dishes WHERE d_id = '$dish_id'");
    $row = mysqli_fetch_assoc($query);

    if ($row) {
        // Only show sizes that have a price > 0
        if ($row['price_small'] > 0) {
            echo '<div class="form-check">
                    <input class="form-check-input" type="radio" name="size" id="size_small" value="small" required>
                    <label class="form-check-label" for="size_small">Small - ₱' . number_format($row['price_small'], 2) . '</label>
                  </div>';
        }
        if ($row['price_medium'] > 0) {
            echo '<div class="form-check">
                    <input class="form-check-input" type="radio" name="size" id="size_medium" value="medium" required>
                    <label class="form-check-label" for="size_medium">Medium - ₱' . number_format($row['price_medium'], 2) . '</label>
                  </div>';
        }
        if ($row['price_large'] > 0) {
            echo '<div class="form-check">
                    <input class="form-check-input" type="radio" name="size" id="size_large" value="large" required>
                    <label class="form-check-label" for="size_large">Large - ₱' . number_format($row['price_large'], 2) . '</label>
                  </div>';
        }
    } else {
        echo '<p>No sizes available.</p>';
    }
}
?>
