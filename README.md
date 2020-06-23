# Media Assistant (mass)

Uses docker images
* mysql
* nginx
* transmission
* sonarr
* radarr
* bazarr
* jackett

## Get started

```bash
cp .env.example .env
docker-compose build
docker-compose up -d
```

Wait a second or two to let the containers startup...

```bash
docker exec mass composer initialize[-dev]
docker-compose restart
```
