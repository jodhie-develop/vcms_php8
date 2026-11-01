$ErrorActionPreference = 'Stop'
$project = 'D:\vcms_php8'
$env:DOCKER_CONFIG = Join-Path $env:TEMP 'vcms-docker-config'
New-Item -ItemType Directory -Force -Path $env:DOCKER_CONFIG | Out-Null
$desktop = 'C:\Program Files\Docker\Docker\Docker Desktop.exe'
if (Test-Path $desktop) { Start-Process -FilePath $desktop -ErrorAction SilentlyContinue }
$ready = $false
for ($i = 0; $i -lt 90; $i++) {
    cmd.exe /d /c 'docker info --format {{.ServerVersion}} >nul 2>&1'
    if ($LASTEXITCODE -eq 0) { $ready = $true; break }
    Start-Sleep -Seconds 2
}
if (-not $ready) { throw 'Docker belum berjalan. Buka Docker Desktop dan tunggu sampai status Running, lalu jalankan start-local.ps1 lagi.' }
docker compose --project-directory $project -f (Join-Path $project 'compose.yaml') up --build -d
if ($LASTEXITCODE -ne 0) { throw 'Gagal menjalankan V-CMS. Lihat pesan Docker di atas.' }
Write-Host 'V-CMS mulai dijalankan. Impor database pertama dapat memerlukan beberapa menit; kemudian buka http://localhost:8080.'