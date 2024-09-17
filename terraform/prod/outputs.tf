output "cognito_json_web_key_set" {
  value = "https://${aws_cognito_user_pool.dafed.endpoint}/.well-known/jwks.json"
}

output "login_uri" {
  value = "https://${aws_cognito_user_pool_domain.dafed.domain}.auth.${var.aws_region}.amazoncognito.com/login?client_id=${aws_cognito_user_pool_client.web.id}&response_type=code&redirect_uri=${element(tolist(aws_cognito_user_pool_client.web.callback_urls), 0)}"
}

output "logout_uri" {
  value = "https://${aws_cognito_user_pool_domain.dafed.domain}.auth.${var.aws_region}.amazoncognito.com/logout?client_id=${aws_cognito_user_pool_client.web.id}&logout_uri=${element(tolist(aws_cognito_user_pool_client.web.logout_urls), 0)}"
}

output "AWS_COGNITO_IDP_URI" {
  value = "https://${aws_cognito_user_pool_domain.dafed.domain}.auth.${var.aws_region}.amazoncognito.com"
}

output "AWS_COGNITO_USER_POOL_ID" {
  value = aws_cognito_user_pool.dafed.id
}

output "AWS_COGNITO_USER_POOL_WEB_CLIENT_ID" {
  value = aws_cognito_user_pool_client.web.id
}

output "AWS_COGNITO_USER_POOL_WEB_CLIENT_SECRET" {
  value     = aws_cognito_user_pool_client.web.client_secret
  sensitive = true
}

output "AWS_COGNITO_USER_POOL_API_CLIENT_ID" {
  value = aws_cognito_user_pool_client.system.id
}

output "AWS_COGNITO_USER_POOL_API_CLIENT_SECRET" {
  value     = aws_cognito_user_pool_client.system.client_secret
  sensitive = true
}

output "AWS_DEFAULT_REGION" {
  value = var.aws_region
}

output "AWS_ACCESS_KEY_ID" {
  value = data.aws_caller_identity.current.user_id
}

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=eu-west-2

AWS_COGNITO_IDP_URI=
AWS_COGNITO_USER_POOL_ID=
AWS_COGNITO_USER_POOL_WEB_CLIENT_ID=
AWS_COGNITO_USER_POOL_WEB_CLIENT_SECRET=
AWS_COGNITO_USER_POOL_API_CLIENT_ID=
AWS_COGNITO_USER_POOL_API_CLIENT_SECRET=

DAFED_ADMIN_USERNAME=
DAFED_ADMIN_PASSWORD=