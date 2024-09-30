# Definir o diretório atual
$baseDir = Get-Location

# Definir o caminho relativo para o arquivo .env (assumindo que o script é executado no diretório do projeto)
$envFilePath = Join-Path $baseDir ".env"

# Carregar variáveis do arquivo .env
$envVars = Get-Content $envFilePath | Where-Object { $_ -notmatch "^#" -and $_ -ne "" }

# Processar cada variável do arquivo .env
foreach ($envVar in $envVars) {
    $var, $value = $envVar -split "="
    $var = $var.Trim()
    $value = $value.Trim()

    # Definir cada variável como uma variável de ambiente no processo atual
    [System.Environment]::SetEnvironmentVariable($var, $value, [System.EnvironmentVariableTarget]::Process)
}

# Verifique se as variáveis de ambiente foram carregadas
Write-Host "DAFED_ADMIN_PASSWORD: $env:DAFED_ADMIN_PASSWORD"
Write-Host "AWS_ACCESS_KEY_ID: $env:AWS_ACCESS_KEY_ID"

# Definir o diretório relativo do terraform (assumindo que o terraform está na subpasta terraform\prod)
$terraformDir = Join-Path $baseDir "terraform\prod"

# Navegar até o diretório onde o Terraform está
Set-Location $terraformDir

# Rodar o terraform init
terraform init

# Rodar o terraform fmt
terraform fmt

# Rodar o terraform plan, utilizando as variáveis de ambiente carregadas
terraform plan `
  -var "AWS_ACCESS_KEY_ID=$env:AWS_ACCESS_KEY_ID" `
  -var "AWS_SECRET_ACCESS_KEY=$env:AWS_SECRET_ACCESS_KEY" `
  -var "AWS_DEFAULT_REGION=$env:AWS_DEFAULT_REGION" `
  -var "AWS_COGNITO_IDP_URI=$env:AWS_COGNITO_IDP_URI" `
  -var "AWS_COGNITO_USER_POOL_DOMAIN=$env:AWS_COGNITO_USER_POOL_DOMAIN" `
  -var "AWS_COGNITO_USER_POOL_ID=$env:AWS_COGNITO_USER_POOL_ID" `
  -var "AWS_COGNITO_USER_POOL_WEB_CLIENT_ID=$env:AWS_COGNITO_USER_POOL_WEB_CLIENT_ID" `
  -var "AWS_COGNITO_USER_POOL_WEB_CLIENT_SECRET=$env:AWS_COGNITO_USER_POOL_WEB_CLIENT_SECRET" `
  -var "AWS_COGNITO_USER_POOL_API_CLIENT_ID=$env:AWS_COGNITO_USER_POOL_API_CLIENT_ID" `
  -var "AWS_COGNITO_USER_POOL_API_CLIENT_SECRET=$env:AWS_COGNITO_USER_POOL_API_CLIENT_SECRET" `
  -var "DAFED_ADMIN_USERNAME=$env:DAFED_ADMIN_USERNAME" `
  -var "DAFED_ADMIN_PASSWORD=$env:DAFED_ADMIN_PASSWORD"

# Rodar o terraform apply
terraform apply -auto-approve

# Voltar ao diretório original
Set-Location $baseDir
