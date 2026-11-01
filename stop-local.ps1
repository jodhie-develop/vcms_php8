$project = 'D:\vcms_php8'
$env:DOCKER_CONFIG = Join-Path $env:TEMP 'vcms-docker-config'
docker compose --project-directory $project -f (Join-Path $project 'compose.yaml') down