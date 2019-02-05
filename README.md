# ProductsManager
Esta API corresponde al backend del sistema que permite la gestión de productos y clientes.

## Instalación
Para hacer uso de esta API podemos decidir su instalación de dos maneras.

### Instalación de manera local

Para hacer uso del sistema de manera local primero debemos configurar la base de datos. Para ello debemos seguir los siguientes pasos:
 
* Crear la base de datos con el nombre "product_manager".
* Realizar una restauración de base de datos con el backup que se encuentra en la raíz del proyecto llamado "backup.sql"

Luego para instalar la API se debe descargar el codigo fuente de este repositorio y ejecutar la siguiente sentencia:

* _php -S localhost:8089 -t public_

#### PRE-Requisitos
+ PHP >= 7
+ Lumen Framework
+ Mysql 5.7

### Instalación con Docker

Para hacer la instalación del sistema a través de Docker primero debemos configurar la base de datos. Para ello debemos seguir los siguientes pasos:
+ Descargar la imagen de Mysql 5.7
  + _docker pull mysql/mysql-server:5.7_
+ Crear el container desde la imagen descargada previamente:
  + _docker run -d --name=mysql-ADM --env=SET_CONTAINER_TIMEZONE=true --env=CONTAINER_TIMEZONE=America/Santiago --env=MYSQL_DATABASE=product_manager --env=MYSQL_USER=cm_user --env=MYSQL_PASSWORD=Cm123456 --env=MYSQL_ROOT_PASSWORD=chelsea14 mysql/mysql-server:5.7_
+ Luego verificamos que el container está arriba:
  + _docker ps_
+ Finalmente realizamos una restauración de la base de datos desde un respaldo:
  + _cat .\ProductsManager\backup.sql | docker exec -i CONTAINER-ID /usr/bin/mysql -u root --password=PWD-ROOT DB-NAME_

Para hacer la instalación de la API tenemos que descargar el código fuente de este repositorio. Luego procedemos a contruir la imagen a partir del DockerFile:
+ Construimos la imagen con el siguiente comando:
  + _docker build -t productmanager ._
+ Luego creamos el container a partir de la imagen creada:
  + _docker run -d -e DB_CONNECTION=mysql -e DB_HOST=mysql-ADM -e DB_PORT=3306 -e DB_DATABASE=product_manager -e DB_USERNAME=cm_user -e DB_PASSWORD=Cm123456 --link=mysql-ADM:mysql-ADM -p 80:80 -v .\ProductsManager:/var/www/html/ --name=api_productmanager productmanager_
+ Luego verificamos que el container está arriba:
  + _docker ps_
