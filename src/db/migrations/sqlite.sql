CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    firstName TEXT NOT NULL,
    lastName TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    roles TEXT NOT NULL,
    creatorId INTEGER NOT NULL,
    createdAt INTEGER NOT NULL DEFAULT (unixepoch()),
    updatedAt INTEGER,
    activatedAt INTEGER
);

CREATE TABLE IF NOT EXISTS tokens (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    userId INTEGER NOT NULL,
    data TEXT NOT NULL,
    purpose TEXT NOT NULL,
    createdAt INTEGER NOT NULL DEFAULT (unixepoch()),
    updatedAt INTEGER,
    expiresAt INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS membershipTypes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    cover TEXT,
    duration INTEGER NOT NULL,
    price INTEGER NOT NULL,
    maxFreeSecondaries INTEGER NOT NULL,
    paidSecondaryPrice INTEGER NOT NULL,
    maxPaidSecondaries INTEGER NOT NULL,
    isActive INTEGER NOT NULL,
    isPublic INTEGER NOT NULL,
    creatorId INTEGER NOT NULL,
    createdAt INTEGER NOT NULL DEFAULT (unixepoch()),
    updatedAt INTEGER
);