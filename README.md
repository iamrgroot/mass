# Media Assistant (mass)

Uses docker images for Laravel (see https://github.com/IAmRGroot/docker-laravel):
* php + node
* mysql
* nginx

Uses docker images for media:
* transmission
* sonarr
* radarr
* jackett
* traefik
* plex

## Get started

```bash
cp .env.example .env
```

Change variables in `.env` accordingly.

:warning: After running the initialization, you can remove the passwords etc from the `.env` for security reasons.

### Initialize

```bash
docker-compose up -d
```

:warning: Wait a second or two to let the containers startup...

```bash
docker exec mass composer initialize
docker-compose restart
```

:warning: It can take a second or 2 for Traefik to initialize when using SSL.
