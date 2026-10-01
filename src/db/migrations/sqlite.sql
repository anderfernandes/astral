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

CREATE TABLE IF NOT EXISTS paymentMethods (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    type TEXT NOT NULL,
    isActive INTEGER NOT NULL,
    isPublic INTEGER NOT NULL,
    creatorId INTEGER NOT NULL,
    createdAt INTEGER NOT NULL DEFAULT (unixepoch()),
    updatedAt INTEGER
);

CREATE TABLE IF NOT EXISTS sales (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    status TEXT NOT NULL,
    source TEXT NOT NULL,
    isTaxable INTEGER NOT NULL,
    checkoutId TEXT,
    customerId INTEGER NOT NULL,
    creatorId INTEGER NOT NULL,
    createdAt INTEGER NOT NULL DEFAULT (unixepoch()),
    updatedAt INTEGER
);

CREATE TABLE IF NOT EXISTS saleItems (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    saleId INTEGER NOT NULL,
    type TEXT NOT NULL,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    price INTEGER NOT NULL,
    quantity INTEGER NOT NULL,
    creatorId INTEGER NOT NULL,
    customerId INTEGER NOT NULL,
    createdAt INTEGER NOT NULL DEFAULT (unixepoch()),
    updatedAt INTEGER,
    deletedAt INTEGER
);

CREATE TABLE IF NOT EXISTS saleMemos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    saleId INTEGER NOT NULL,
    message TEXT NOT NULL,
    createdAt INTEGER NOT NULL DEFAULT (unixepoch()),
    updatedAt INTEGER
)