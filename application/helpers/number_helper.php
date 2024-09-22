<?php
if (!function_exists('indian_number_format')) {
    /**
     * Format number in Indian number system (Lakhs/Crores)
     *
     * @param float|int $num
     * @return string
     */
    function indian_number_format($num) {
        $explore_number = explode(".", $num);
        $whole_number = $explore_number[0];
        $decimal = isset($explore_number[1]) ? "." . $explore_number[1] : "";

        // Get the last 3 digits (for thousand place) and the remaining digits
        $last3digits = substr($whole_number, -3);
        $remaining_digits = substr($whole_number, 0, -3);

        // If there are digits before the last 3, format them as per Indian system
        if ($remaining_digits != '') {
            $last3digits = ',' . $last3digits;
        }

        // Add commas after every 2 digits for the remaining part
        $formatted_number = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $remaining_digits) . $last3digits . $decimal;

        return $formatted_number;
    }
}
?>
