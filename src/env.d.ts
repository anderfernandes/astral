declare namespace NodeJS {
  interface ProcessEnv {
    DB_DRIVER?: "sqlite" | "postgres";
  }
}
