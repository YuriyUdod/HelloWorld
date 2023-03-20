# LAMP
This repository will create a virtual host on AWS (using **Terraform** and `main.tf`, `variables.tf`) that will install the LAMP environment (**L**inux, **A**pache, **M**ySQL and **P** HP) using **Ansible** with `playbook.yml`, `vars\default.yml`.
Then a **MySQL** database is created on it and the `info.php` file is installed, which displays information about the user's IP address and statistics of visits from this address.

## Settings
The parameters of the created VM for AWS and their default values are described in **variables.tf**:
- `ami` : Application and OS Images (Amazon Machine Image)
- `instance_type` : AWS Instance type
- `region` : AWS Availability Zone
- `mysql_root_password` : the password for the MySQL root account.

and in `vars/default.yml` variable file:
- `app_user`: a remote non-root user on the Ansible host that will own the application files.
- `http_host`: your domain name.
- `http_conf`: the name of the configuration file that will be created within Apache.
- `http_port`: HTTP port, default is 80.
- `disable_default`: whether or not to disable the default Apache website. When set to true, your new virtualhost should be used as default website. Default is true.

## Using this repository

### 1. Create a script and configure settings

Template `tf.sh`:
```shell
if test -d "HelloWorld"; then
  cd HelloWorld
  git pull
else
  git clone https://github.com/YuriyUdod/HelloWorld.git
  cd HelloWorld
fi

export AWS_ACCESS_KEY_ID="<type here AWS accesskey>"
export AWS_SECRET_ACCESS_KEY="<type here AWS secret access key>"
export TF_VAR_ami="<type here AWS AMI>"
export TF_VAR_instance_type="<type here AWS Instance type>"
export TF_VAR_region="<type here AWS region>"
export TF_VAR_mysql_root_password="<type here the password for the MySQL root account>"

terraform init
terraform apply
```

### 2. Run the script

```shell
tf.sh
```
After the script is finished, the IP address of the created VM is displayed on the screen.

### 3. Browser

Copy the value of the IP address and in the browser go to the page:
```url
http:\\<IP-adress>/info.php
```
The screen will display brief information obtained on the basis of the user's IP address: 
`IP address`,
`Сity`,
`Region`,
`Country`,
`Continent`
and the number of page visits from this address.

### 4. Deleting the created VM

To remove it, you need to create a script according to a different template, `tfd.sh`. Parameters are similar to the `tf.sh` template. 

Template `tfd.sh`:
```shell
if test -d "HelloWorld"; then
  cd HelloWorld
  git pull
else
  git clone https://github.com/YuriyUdod/HelloWorld.git
  cd HelloWorld
fi

export AWS_ACCESS_KEY_ID="<type here AWS accesskey>"
export AWS_SECRET_ACCESS_KEY="<type here AWS secret access key>"
export TF_VAR_ami="<type here AWS AMI>"
export TF_VAR_instance_type="<type here AWS Instance type>"
export TF_VAR_region="<type here AWS region>"
export TF_VAR_mysql_root_password="<type here the password for the MySQL root account>"

terraform init
terraform destroy
```
