declare namespace NodeJS {
  interface ProcessEnv {
    NAME?: string;
    TIMEZONE?: string;
    LOCALE?: string;
    CURRENCY?: string;
    SALE_TAX_RATE?: string;
    CONVENIENCE_FEE?: string;
    KEY?: string;
    DB_DRIVER: "sqlite" | "postgres" | "mssql";
    DB_DATABASE: string;
    DB_SERVER?: string;
    DB_PORT?: string;
    DB_USER?: string;
    DB_PASSWORD?: string;
    DB_TRUST_SERVER_CERTIFICATE?: string;
    MAIL_FROM?: string;
    MAIL_HOST?: string;
    MAIL_PORT?: string;
    MAIL_USER?: string;
    MAIL_PASSWORD?: string;
    STRIPE_PUBLISHABLE_KEY: string;
    STRIPE_SECRET_KEY: string;
  }
}
