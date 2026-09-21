IF OBJECT_ID(N'dbo.users', N'U') IS NULL
BEGIN
    CREATE TABLE dbo.users (
        id INT IDENTITY(1,1) PRIMARY KEY,
        firstName NVARCHAR(255) NOT NULL,
        lastName NVARCHAR(255) NOT NULL,
        email NVARCHAR(255) NOT NULL UNIQUE,
        password NVARCHAR(MAX) NOT NULL,
        roles NVARCHAR(MAX) NOT NULL,
        creatorId INT NOT NULL,
        createdAt BIGINT NOT NULL DEFAULT (DATEDIFF(second, '1970-01-01', GETUTCDATE())),
        updatedAt BIGINT NULL,
        activatedAt BIGINT NULL
    );
END

IF OBJECT_ID(N'dbo.tokens', N'U') IS NULL
BEGIN
    CREATE TABLE dbo.tokens (
        id INT IDENTITY(1,1) PRIMARY KEY,
        userId INT NOT NULL,
        data NVARCHAR(MAX) NOT NULL,
        purpose NVARCHAR(255) NOT NULL,
        createdAt BIGINT NOT NULL DEFAULT (DATEDIFF(second, '1970-01-01', GETUTCDATE())),
        updatedAt BIGINT NULL,
        expiresAt BIGINT NOT NULL
    );
END