TASK TRACKER — PHP/MySQL DATABASE VERSION

Files
-----
index.php       Existing Task Tracker UI, kept as the main front end. Desktop/mobile layout is preserved.
api.php         JSON API for login, retrieval, create operations, reports and database actions.
db.php          PDO database connection.
config.php      XAMPP/MySQL connection settings.
database.sql    MySQL schema for users, clients, tasks, calendar, attendance, approvals, campaigns, integrations, metrics, meetings, notifications and imports.
install.php     Creates the database/tables and seeds demo accounts/clients/metrics.
uploads.htaccess Apache protection file for an uploads directory if you later add file storage.

XAMPP SETUP
-----------
1. Start Apache and MySQL in XAMPP.
2. Copy this folder to: C:\\xampp\\htdocs\\task-tracker\\
3. Check config.php. Default XAMPP values are root with an empty password.
4. Open: http://localhost/task-tracker/install.php
5. After successful installation, delete or rename install.php for security.
6. Open: http://localhost/task-tracker/index.php

DEMO LOGIN
----------
Manager:      manager@tasktracker.local / Admin@123
Team Leader:  leader@tasktracker.local / Admin@123
Ravi:         ravi@tasktracker.local / Member@123
Neha:         neha@tasktracker.local / Member@123
Arjun:        arjun@tasktracker.local / Member@123
Client A:     clienta@tasktracker.local / Client@123
Client B:     clientb@tasktracker.local / Client@123
Client C:     clientc@tasktracker.local / Client@123

WHAT IS STORED
--------------
Users/roles, client details, team members, tasks, publish/due dates, assignments, approvals, work URLs, proof URLs, calendar items, bulk imports, attendance punch-in/out, leave records, campaigns, client platform connections, client growth metrics, meetings, meeting notes/follow-ups and notifications.

IMPORTANT
---------
- The HTML UI is still the same application. localStorage is now only a browser cache/fallback; database data is loaded through api.php.
- Real Meta/Instagram/Google Ads/YouTube/WhatsApp publishing still requires the official OAuth/API credentials. Do not put access tokens in index.php.
- The current bulk importer is CSV-first. For XLSX parsing without manual conversion, install PhpSpreadsheet through Composer and extend api.php.
- File attachments are currently represented by attachment/work URLs. A future upload endpoint can store binary files under an uploads directory and record them in task_attachments.
- For production, move DB credentials outside the web root and use HTTPS.
