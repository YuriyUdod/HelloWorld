variable "ami" {
  type = string
  default = "ami-09e1162c87f73958b")  #ubuntu 22.04, x86_64
}

variable "instance_type" {
  type = string
  default = "t3.micro"
}

variable "region" {
  type = string
  default = "eu-north-1"
}
