provider "aws" {
  region = "eu-north-1"  #подсмотрел при создании через AWS
  # получены и скопированы вручную
  #access_key = ""
  #secret_key = ""
}

resource "aws_security_group" "my_sg" {
  name = "My Security Group"
  description = "My Security Group"
  # разрешить ICMP
  ingress {
    from_port   = 8
    to_port     = -1
    protocol    = "icmp"
    cidr_blocks = ["0.0.0.0/0"]
  }
  # разрешить входящий на 22 - SSH
  ingress {
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }
  # разрешить входящий на 80 - веб-сервер
  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }
  # разрешить входящий на 443 - для https - пока без него
  ingress {
    from_port   = 443
    to_port     = 443
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }
    # разрешить весь исходящий
  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
}

#lamp - имя
resource "aws_instance" "lamp" {
  # AMI - Amazon Machine Image
  ami = "ami-09e1162c87f73958b" #ubuntu 22.04, x86_64
  instance_type = "t3.micro"    # CPU, memory, price
  vpc_security_group_ids = [aws_security_group.my_sg.id]
  associate_public_ip_address = true
  tags = {
    Name = "lamp"
  }
  # установить Ansible
  user_data              = <<EOF
#!/bin/bash
sudo apt-get update
sudo apt-get install -y ansible git
EOF

}
