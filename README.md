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

If you use nginx reverse proxy make sure to pass port and scheme variables to location. For example:
```
location /addressbook {
		# sheme and server_port is needed for LAB
		proxy_set_header X-Forwarded-Proto $scheme;
		proxy_set_header X-Forwarded-Port $server_port;
		proxy_pass http://127.0.0.1:8084;
	}

```
