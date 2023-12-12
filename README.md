# lab-dockerized
LDAP addressbook dockerized repo

To use in any way:
```
cp example.env .env
```
Make changes in .env file then run:
```
docker-compose up -d
```
To stop:
```
docker-compose down
```

To build unpack addressbook.zip into the ./addressbook directory along with Dockerfile in cloned root directory.

To make some customizations use config.php, styles_local.css and logo.png.
