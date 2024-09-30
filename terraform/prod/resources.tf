resource "aws_cognito_user_pool" "dafed" {
  name = var.cognito_user_pool_name

  password_policy {
    minimum_length    = 12
    require_lowercase = true
    require_uppercase = true
    require_numbers   = true
    require_symbols   = false
  }

  admin_create_user_config {
    allow_admin_create_user_only = true
  }

  username_attributes      = ["email"]
  auto_verified_attributes = ["email"]

  account_recovery_setting {
    recovery_mechanism {
      name     = "verified_email"
      priority = 1
    }
  }
}

# Cognito User Pool Domain
resource "aws_cognito_user_pool_domain" "dafed" {
  domain       = var.aws_cognito_user_pool_domain
  user_pool_id = aws_cognito_user_pool.dafed.id
}

resource "aws_cognito_user" "players" {
  count = length(var.cognito_user_pool_members)

  user_pool_id = aws_cognito_user_pool.dafed.id
  username     = var.cognito_user_pool_members[count.index].email
  password     = var.cognito_user_pool_members[count.index].password

  attributes = {
    email          = var.cognito_user_pool_members[count.index].email
    email_verified = true
  }
}
