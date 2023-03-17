provider "aws" {
  region = "us-east-1"  #подсмотрел при создании через AWS
  # получены и скопированы вручную
  access_key = ""
  secret_key = ""
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

# получить ключ для последующего подключения через SSH для remote-exec
#resource "aws_key_pair" "my-key-pair" {
#  key_name   = "my-key-pair"
#  public_key = file("~/.ssh/id_rsa.pub")
#}

#output "private_key_pem" {
#  value = aws_key_pair.my-key-pair.private_key_pem
#}

#lamp - имя
resource "aws_instance" "lamp" {
  # AMI - Amazon Machine Image
  ami = "ami-0557a15b87f6559cf" #ubuntu 22.04
  instance_type = "t2.micro"    # CPU, memory, price
  vpc_security_group_ids = [aws_security_group.my_sg.id]
  #  key_name      = aws_key_pair.my-key-pair.key_name
  #security_groups = ["sg-0676ab48dca820307"]  # взял из своего инстанса
  #security_groups = ["sg-00c943cf4319f91f1"] #default
  #security_groups = ["sg-01b6fd453f3ec16a7"] #створив сам

  associate_public_ip_address = true
  tags = {
    Name = "lamp"
  }
  # установить Ansible
  user_data              = <<EOF
#!/bin/bash
sudo apt-get update
sudo apt-get install -y ansible
EOF

#  provisioner "remote-exec" {
#    inline = [
#      "sudo apt-get update",
#      "sudo apt-get install -y ansible"
#    ]
#  }

#  provisioner "remote-exec" {
# 
#  connection {
#    type        = "ssh"
#    user        = "ubuntu"
#    private_key = aws_key_pair.my-key-pair.private_key_pem
#    host        = self.public_ip
#  }
#    inline = [
      #обновить пакеты
#      "sudo apt-get update",
      #установка
#      "sudo apt-get -y install apache2 mysql-server php libapache2-mod-php php-mysql",
      #"sudo ufw allow Apache",
      # как установить пароль на mySQL ???
#      "sudo systemctl start apache2.service",
#      "sudo systemctl start mysql.service",
#      "sudo systemctl enable apache2.service",
#      "sudo systemctl enable mysql.service",
#      "cd /var/www",
#      "sudo mkdir first.host"
      # права на доступ к каталогу
      #"sudo chown -R $USER:$USER /var/www/first.host",
      # подсунуть *.conf
      # sudo a2ensite first.host
      # sudo systemctl reload apache2  
      # cd /var/www/first.host и тут затянуть файл php
#    ]
#  }
}
