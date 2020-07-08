# Media Assistant (mass)

Uses docker images
* mysql
* nginx
* transmission
* sonarr
* radarr
* bazarr
* jackett
* traefik
* plex

## Get started

```bash
cp .env.example .env
```

Change variables in .env accordingly.

### Traefik

```bash
cp ./docker-compose/traefik/traefik.toml.example ./docker-compose/traefik/traefik.toml
```

Edit values in `docker-compose/traefik/traefik.toml`.

### Build & Start

```bash
docker-compose build
docker-compose up -d
```

Wait a second or two to let the containers startup...

```bash
docker exec mass composer initialize[-dev]
docker-compose restart
```
