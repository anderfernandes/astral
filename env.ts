import * as v from "valibot";

// The typed env schema (probed by the plugin from the project root): plain
// objects of Standard Schema validators — valibot here, but zod, arktype, or
// any compliant library works, even mixed per key.
//
// `server` vars come through `virtual:env/server` (server modules only —
// importing it from client code fails the build) and are read from
// process.env at BOOT, validated then: secrets rotate without a rebuild and
// never appear in build artifacts. `client` vars must carry the public
// VITE_ prefix and come through `virtual:env/client` as validated values
// baked into the bundle. Generated types land in solid-env.d.ts.
export default {
  server: {
    // Comma-separated, newest first — see src/server/session.ts for the
    // rotation story. Generate one: `openssl rand -base64 32`.
    SESSION_SECRET: v.pipe(v.string(), v.minLength(32)),
    NAME: v.pipe(v.string(), v.minLength(2), v.maxLength(127)),
    TIMEZONE: v.picklist(["America/Chicago"]),
    LOCALE: v.picklist(["en-US"]),
    CURRENCY: v.picklist(["USD"]),
    SALE_TAX_RATE: v.string(),
    CONVENIENCE_FEE: v.string(),
    //DB_DRIVER: v.picklist(["sqlite"]),
    //DB_DATABASE: v.string()
    MAIL_FROM: v.optional(v.pipe(v.string(), v.email())),
    MAIL_HOST: v.optional(v.pipe(v.string())),
    MAIL_PORT: v.optional(v.string()),
    MAIL_USER: v.optional(v.string()),
    MAIL_PASSWORD: v.pipe(v.string(), v.maxLength(255)),
    STRIPE_PUBLISHABLE_KEY: v.optional(v.pipe(v.string(), v.startsWith("pk_"))),
    STRIPE_SECRET_KEY: v.optional(v.pipe(v.string(), v.startsWith("sk_"))),
    STRIPE_TAX_RATE_ID: v.optional(v.pipe(v.string(), v.startsWith("txr_"))),
  },
  client: {
    VITE_APP_NAME: v.optional(v.pipe(v.string(), v.minLength(1)), "Solid App"),
  },
};
