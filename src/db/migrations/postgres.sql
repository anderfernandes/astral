CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    "firstName" TEXT NOT NULL,
    "lastName" TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    roles TEXT NOT NULL,
    "creatorId" INTEGER NOT NULL,
    "createdAt" BIGINT NOT NULL DEFAULT EXTRACT(EPOCH FROM NOW())::BIGINT,
    "updatedAt" BIGINT,
    "activatedAt" BIGINT
);

CREATE TABLE IF NOT EXISTS tokens (
    id SERIAL PRIMARY KEY,
    "userId" INTEGER NOT NULL,
    data TEXT NOT NULL,
    purpose TEXT NOT NULL,
    "createdAt" BIGINT NOT NULL DEFAULT EXTRACT(EPOCH FROM NOW())::BIGINT,
    "updatedAt" BIGINT,
    "expiresAt" BIGINT NOT NULL
);