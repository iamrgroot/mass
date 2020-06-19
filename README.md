# mass
Media Assistant

## Get started

```bash
cp .env.example .env
docker-compose build
docker-compose up -d
docker exec mass composer initialize[-dev]
docker restart jackett mass-nginx
```
