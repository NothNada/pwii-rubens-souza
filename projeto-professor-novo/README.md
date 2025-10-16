## Como iniciar projeto PHP no Linux

### Configuração e Instalação

Primeiro é preciso atualizar o sistema:

```bash
sudo apt update && sudo apt upgrade -y
```

Depois instalar Apache, MySQL, e PHP com suas extensões:

```bash
# Apache
sudo apt install apache2 -y

# MySQL
sudo apt install mysql-server -y

# PHP e suas extensões
sudo apt install php libapache2-mod-php php-mysql php-curl php-json php-gd php-mbstring php-xml php-zip -y
```

E logo depois reinicie o Apache:

```bash
sudo systemctl restart apache2
```

### Iniciando Projeto

Primeiro rode o comando de configuração de segurança do MySQL:

```bash
sudo mysql_secure_installation

# Daqui pra frente ele irá fazer varias perguntas para esse projeto eu respondi assim:

Securing the MySQL server deployment.

Connecting to MySQL using a blank password.

VALIDATE PASSWORD COMPONENT can be used to test passwords
and improve security. It checks the strength of password
and allows the users to set only those passwords which are
secure enough. Would you like to setup VALIDATE PASSWORD component?

Press y|Y for Yes, any other key for No: y

There are three levels of password validation policy:

LOW    Length >= 8
MEDIUM Length >= 8, numeric, mixed case, and special characters
STRONG Length >= 8, numeric, mixed case, special characters and dictionary                  file

Please enter 0 = LOW, 1 = MEDIUM and 2 = STRONG:  

Invalid option provided.

There are three levels of password validation policy:

LOW    Length >= 8
MEDIUM Length >= 8, numeric, mixed case, and special characters
STRONG Length >= 8, numeric, mixed case, special characters and dictionary                  file

Please enter 0 = LOW, 1 = MEDIUM and 2 = STRONG: 0

Skipping password set for root as authentication with auth_socket is used by default.
If you would like to use password authentication instead, this can be done with the "ALTER_USER" command.
See https://dev.mysql.com/doc/refman/8.0/en/alter-user.html#alter-user-password-management for more information.

By default, a MySQL installation has an anonymous user,
allowing anyone to log into MySQL without having to have
a user account created for them. This is intended only for
testing, and to make the installation go a bit smoother.
You should remove them before moving into a production
environment.

Remove anonymous users? (Press y|Y for Yes, any other key for No) : y
Success.


Normally, root should only be allowed to connect from
'localhost'. This ensures that someone cannot guess at
the root password from the network.

Disallow root login remotely? (Press y|Y for Yes, any other key for No) : y
Success.

By default, MySQL comes with a database named 'test' that
anyone can access. This is also intended only for testing,
and should be removed before moving into a production
environment.


Remove test database and access to it? (Press y|Y for Yes, any other key for No) : y
 - Dropping test database...
Success.

 - Removing privileges on test database...
Success.

Reloading the privilege tables will ensure that all changes
made so far will take effect immediately.

Reload privilege tables now? (Press y|Y for Yes, any other key for No) : y
Success.

All done!

```

Agora precisamos iniciar os serviços:

```bash
# Iniciar e ativar MySQL
sudo systemctl start mysql


# Iniciar e ativar Apache (se instalou)
sudo systemctl start apache2

# Utilize se quiser iniciar automaticamente no boot
sudo systemctl enable mysql
sudo systemctl enable apache2
```

Verificar o Status

```bash
# Verificar MySQL
sudo systemctl status mysql

# Verificar Apache (se instalou)
sudo systemctl status apache2

# Verificar PHP
php --version
```

### Estrutura dos Arquivos com o Apache

```bash
# Seu site fica em:
/var/www/html/

# Para colocar seus arquivos:
sudo cp -r seu_projeto/* /var/www/html/
sudo chown -R www-data:www-data /var/www/html/
```

### Se quiser usar servidor do PHP imbutido

```bash
# Cria um servidor que roda o PHP, sem necessidade de usar o Apache
php -S 127.0.0.1:8080
```

# Lembrando que esse Tutorial é apenas para Linux, Windows é somente usar o XAMPP, e colocar os arquivos do projeto dentro do htdocs

## Agora provavelmente será necessario adicionar um usuario e senha para o banco de dados

Primeiro entre no banco:

```bash
sudo mysql -u root

#Ira aparecer algo assim

Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 12
Server version: 8.0.43-0ubuntu0.24.04.2 (Ubuntu)

Copyright (c) 2000, 2025, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql>
```

E faça isso:

```bash
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'sua_nova_senha';
FLUSH PRIVILEGES;
```

E para acessar:

```bash
mysql -u root --password=sua_nova_senha
```

Depois de tudo isso, Crie a tabela para os usuarios via Terminal, ou se for no XAMPP, utilize o phpMyAdmin.

```SQL

create database teste;
use teste;

create table usuarios(
    id int auto_increment primary key,
    nome varchar(100) not null,
    cpf varchar(15) unique not null,
    email varchar(100) unique not null,
    created_data timestamp default current_timestamp
);
```

# E Pronto agora está tudo configurado!