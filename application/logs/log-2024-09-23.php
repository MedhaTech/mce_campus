<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2024-09-23 00:00:10 --> Severity: error --> Exception: Call to a member function createOrder() on null C:\xampp\htdocs\mce_campus\application\controllers\Student.php 247
ERROR - 2024-09-23 00:01:41 --> Severity: error --> Exception: Call to a member function createOrder() on null C:\xampp\htdocs\mce_campus\application\controllers\Student.php 247
ERROR - 2024-09-23 00:02:28 --> Severity: error --> Exception: Call to a member function createOrder() on null C:\xampp\htdocs\mce_campus\application\controllers\Student.php 248
ERROR - 2024-09-23 21:25:17 --> Query error: Unknown column 'adm_no' in 'field list' - Invalid query: SELECT `id`, `adm_no`, `quota`, `dept_id`, `sub_quota`, `student_name`, `mobile`, `usn`, `status`
FROM `students`
WHERE `academic_year` = '2024-25'
ERROR - 2024-09-23 21:25:32 --> Query error: Unknown column 'dept_id' in 'field list' - Invalid query: SELECT `id`, `quota`, `dept_id`, `sub_quota`, `student_name`, `student_number`, `usn`, `status`
FROM `students`
WHERE `academic_year` = '2024-25'
ERROR - 2024-09-23 21:25:48 --> Query error: Unknown column 'academic_year' in 'where clause' - Invalid query: SELECT `id`, `quota`, `department`, `sub_quota`, `student_name`, `student_number`, `usn`, `status`
FROM `students`
WHERE `academic_year` = '2024-25'
ERROR - 2024-09-23 21:26:07 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable F:\xampp\htdocs\mce_campus\application\views\admin\students.php 14
ERROR - 2024-09-23 17:56:07 --> 404 Page Not Found: Assets/img
ERROR - 2024-09-23 21:26:12 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable F:\xampp\htdocs\mce_campus\application\views\admin\students.php 14
ERROR - 2024-09-23 17:56:12 --> 404 Page Not Found: Assets/img
ERROR - 2024-09-23 21:26:34 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable F:\xampp\htdocs\mce_campus\application\views\admin\students.php 14
ERROR - 2024-09-23 17:56:34 --> 404 Page Not Found: Assets/img
ERROR - 2024-09-23 21:28:04 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable F:\xampp\htdocs\mce_campus\application\views\admin\students.php 14
ERROR - 2024-09-23 17:58:04 --> 404 Page Not Found: Assets/img
ERROR - 2024-09-23 21:28:06 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable F:\xampp\htdocs\mce_campus\application\views\admin\students.php 14
ERROR - 2024-09-23 17:58:06 --> 404 Page Not Found: Assets/img
ERROR - 2024-09-23 18:39:44 --> 404 Page Not Found: Admin/paymentDetail
ERROR - 2024-09-23 22:13:45 --> Query error: Unknown column 'usn' in 'where clause' - Invalid query: SELECT SUM(`amount`) AS `amount`
FROM `transactions`
WHERE `usn` = '316'
AND `transaction_status` = '1'
