variable "ami" {
  type = string
  default = "ami-09e1162c87f73958b"
}

variable "instance_type" {
  type = string
  default = "t3.micro"
}

variable "region" {
  type = string
  default = "eu-north-1"
}
variable "mysql_root_password" {
  type = string
  default = ""
}
