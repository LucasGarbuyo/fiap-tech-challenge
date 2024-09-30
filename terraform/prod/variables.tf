variable "aws_profile" {
  description = "The AWS profile to use"
  type        = string
  default     = "default"
}

variable "aws_region" {
  description = "AWS Region"
  type        = string
  default     = "us-east-1"
}

variable "AWS_ACCESS_KEY_ID" {
  description = "AWS Access Key ID"
  type        = string
}

variable "AWS_SECRET_ACCESS_KEY" {
  description = "AWS Secret Access Key"
  type        = string
}

variable "AWS_DEFAULT_REGION" {
  description = "AWS Default Region"
  type        = string
  default     = "eu-west-2"
}

variable "aws_cognito_user_pool_domain" {
  description = "Domain for Cognito User Pool"
  type        = string
}

variable "AWS_COGNITO_USER_POOL_ID" {
  description = "AWS Cognito User Pool ID"
  type        = string
}

variable "AWS_COGNITO_USER_POOL_WEB_CLIENT_ID" {
  description = "AWS Cognito User Pool Web Client ID"
  type        = string
}

variable "AWS_COGNITO_USER_POOL_WEB_CLIENT_SECRET" {
  description = "AWS Cognito User Pool Web Client Secret"
  type        = string
}

variable "AWS_COGNITO_USER_POOL_API_CLIENT_ID" {
  description = "AWS Cognito API Client ID"
  type        = string
}

variable "AWS_COGNITO_USER_POOL_API_CLIENT_SECRET" {
  description = "AWS Cognito API Client Secret"
  type        = string
}

variable "DAFED_ADMIN_USERNAME" {
  description = "Admin Username"
  type        = string
}

variable "DAFED_ADMIN_PASSWORD" {
  description = "Admin Password"
  type        = string
}
