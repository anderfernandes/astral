# Astral Server

1. Setup

```bash
podman build -t astral:beta .
```

```bash
podman-compose up
```

```bash
podman rmi localhost/astral:beta && podman build -t astral:beta .
```