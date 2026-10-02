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

CREATE TABLE IF NOT EXISTS "membershipTypes" (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    cover TEXT,
    duration INTEGER NOT NULL,
    price INTEGER NOT NULL,
    "maxFreeSecondaries" INTEGER NOT NULL,
    "paidSecondaryPrice" INTEGER NOT NULL,
    "maxPaidSecondaries" INTEGER NOT NULL,
    "isActive" INTEGER NOT NULL,
    "isPublic" INTEGER NOT NULL,
    "creatorId" INTEGER NOT NULL,
    "createdAt" BIGINT NOT NULL DEFAULT EXTRACT(EPOCH FROM NOW())::BIGINT,
    "updatedAt" BIGINT
);

CREATE TABLE IF NOT EXISTS "paymentMethods" (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    type TEXT NOT NULL,
    "isActive" INTEGER NOT NULL,
    "isPublic" INTEGER NOT NULL,
    "creatorId" INTEGER NOT NULL,
    "createdAt" BIGINT NOT NULL DEFAULT EXTRACT(EPOCH FROM NOW())::BIGINT,
    "updatedAt" BIGINT
);

CREATE TABLE IF NOT EXISTS sales (
    id SERIAL PRIMARY KEY,
    status TEXT NOT NULL,
    source TEXT NOT NULL,
    "isTaxable" INTEGER NOT NULL,
    checkoutId TEXT,
    "customerId" INTEGER NOT NULL,
    "creatorId" INTEGER NOT NULL,
    "createdAt" BIGINT NOT NULL DEFAULT EXTRACT(EPOCH FROM NOW())::BIGINT,
    "updatedAt" BIGINT
);

CREATE TABLE IF NOT EXISTS "saleItems" (
    id SERIAL PRIMARY KEY,
    "saleId" INTEGER NOT NULL,
    type TEXT NOT NULL,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    price INTEGER NOT NULL,
    quantity INTEGER NOT NULL,
    "customerId" INTEGER NOT NULL,
    "creatorId" INTEGER NOT NULL,
    "createdAt" BIGINT NOT NULL DEFAULT EXTRACT(EPOCH FROM NOW())::BIGINT,
    "updatedAt" BIGINT,
    "deletedAt" BIGINT
);

CREATE TABLE IF NOT EXISTS saleMemos (
    id SERIAL PRIMARY KEY,
    "saleId" INTEGER NOT NULL,
    message TEXT NOT NULL,
    "createdAt" BIGINT NOT NULL DEFAULT EXTRACT(EPOCH FROM NOW())::BIGINT,
    "updatedAt" BIGINT
)