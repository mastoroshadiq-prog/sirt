$env:Path += ";C:\laragon\bin\php\php-8.3.26-Win32-vs16-x64"
$env:Path += ";C:\laragon\bin\composer"
$env:Path += ";C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin"

Write-Host "Running CodeIgniter migrations..." -ForegroundColor Green
php spark migrate --all

if ($LASTEXITCODE -eq 0) {
    Write-Host "`nMigration completed successfully!" -ForegroundColor Green
    Write-Host "Checking created tables..." -ForegroundColor Cyan
    mysql -u root si_rt_db -e "SHOW TABLES;"
} else {
    Write-Host "`nMigration failed!" -ForegroundColor Red
}
