# InfinityFree Upload Notes

Upload the contents of this folder into your hosting account's `htdocs` folder.

After creating the hosting account:

1. Create a MySQL database in the hosting control panel.
2. Open phpMyAdmin for that database.
3. Import `database/hosting_schema.sql`.
4. Edit `.env` in the host file manager.
5. Replace `APP_URL` with your free subdomain.
6. Replace the `DB_*` values with the MySQL host, database name, username, and password from the hosting control panel.
7. Replace `ADMIN_PASSWORD` with a strong password.
8. Add real SMTP settings so student email OTP codes can be delivered.

The site will load without SMTP, but registration and password-reset OTP emails will not work until SMTP is configured.

Do not import `database/hosting_schema.sql` into a database that already has data you care about. It drops and recreates the app tables.
