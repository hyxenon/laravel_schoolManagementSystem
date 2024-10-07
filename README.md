![alt text](image.png)

![alt text](image-1.png)

Step 1:
remove ";" in
extension=zip
extension=fileinfo
extension=pdo_mysql

Step 2:
composer install

Step 3:
copy the env file in gc.

Step 4:
php artisan migrate --path=/database/migrations/2024_10_07_082112_create_employees_table.php
php artisan migrate --path=/database/migrations/2024_10_07_082056_create_departments_table.php
php artisan migrate --path=/database/migrations/2024_10_07_082106_create_courses_table.php
php artisan migrate --path=/database/migrations/2024_10_07_082118_create_students_table.php
php artisan migrate --path=/database/migrations/2024_10_07_082122_create_subjects_table.php
php artisan migrate --path=/database/migrations/2024_10_07_082131_create_grades_table.php
php artisan migrate --path=/database/migrations/2024_10_07_082135_create_rooms_table.php
php artisan migrate --path=/database/migrations/2024_10_07_082139_create_schedules_table.php
php artisan migrate --path=/database/migrations/2024_10_07_082146_create_attendances_table.php
php artisan migrate --path=/database/migrations/2024_10_07_082150_create_payrolls_table.php
php artisan migrate --path=/database/migrations/2024_10_07_082152_create_payments_table.php
php artisan migrate --path=/database/migrations/2024_10_07_082155_create_announcements_table.php
php artisan migrate --path=/database/migrations/2024_10_07_082158_create_assignments_table.php
php artisan migrate --path=/database/migrations/2024_10_07_084840_create_submissions_table.php
