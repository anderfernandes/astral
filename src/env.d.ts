declare namespace NodeJS {
  interface ProcessEnv {
    DB_DRIVER: "sqlite" | "postgres" | "mssql";
    DB_DATABASE: string;
    DB_SERVER?: string;
    DB_PORT?: string;
    DB_USER?: string;
    DB_PASSWORD?: string;
    DB_TRUST_SERVER_CERTIFICATE?: string;
  }
}
