# I set up `aws configure` with this profile
variable "aws_profile" {
  type    = string
  default = "dafed"
}

variable "aws_region" {
  type    = string
  default = "eu-west-2"
}

# The subdomain of cognito IDP for the hosted UI
variable "cognito_user_pool_domain" {
  type    = string
  default = "dafedteam"
}

# The name of our user pool
variable "cognito_user_pool_name" {
  type    = string
  default = "players"
}

# List of users in our pool
variable "cognito_user_pool_members" {
  type = list(object({
    email    = string
    password = string
  }))
}

# List of URLs that can be redirected to after login
# from the hosted UI
variable "web_callback_urls" {
  type = list(string)
  default = [
    "https://t3.dafedteam.test/login-success"
  ]
}

# List of URLs that can be redirected to after logout
# from the hosted UI
variable "web_logout_urls" {
  type = list(string)
  default = [
    "https://t3.dafedteam.test/logout-success"
  ]
}