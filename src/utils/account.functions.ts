import { createServerFn } from "@tanstack/solid-start";
import {
  getRequestHeader,
  setResponseHeader,
} from "@tanstack/solid-start/server";
import { db } from "~db";
import { getCurrentDateTimeString } from ".";
import { redirect } from "@tanstack/solid-router";

export const signoutFn = createServerFn().handler(async () => {
  const header = getRequestHeader("Cookie");

  const token = header?.split("=")[1];

  await db
    .updateTable("tokens")
    .set({
      expiresAt: getCurrentDateTimeString() as string,
      updatedAt: getCurrentDateTimeString(),
    })
    .where("purpose", "=", "authentication")
    .where("id", "=", token as string)
    .executeTakeFirst();

  setResponseHeader(
    "Set-Cookie",
    import.meta.env.PROD
      ? `__Host-ASTRALSESSID=DELETED; HttpOnly; Secure; SameSite=Lax; Path=/; MaxAge=0`
      : `ASTRALSESSID=DELETED; HttpOnly; Path=/; MaxAge=0`,
  );

  throw redirect({ to: "/sign-in" });
});

export const getSignedInUserFn = createServerFn().handler(async () => {
  const header = getRequestHeader("Cookie");

  if (!header) {
    console.log("no header");
    return undefined;
  }

  const token = header?.split("=")[1];

  if (!token) {
    console.log("no token");
    return undefined;
  }

  return await db
    .selectFrom("users")
    .leftJoin("tokens", "users.id", "tokens.userId")
    .select([
      "users.id as id",
      "users.email as email",
      "users.firstName as firstName",
      "users.lastName as lastName",
      "users.roles",
      // "tokens.id as tokenId",
      // "tokens.expiresAt as tokenExpiresAt",
      // "tokens.purpose as tokenPurpose",
      // "tokens.createdAt as tokenCreatedAt",
    ])
    .where("tokens.id", "=", token as string)
    .where("tokens.purpose", "=", "authentication")
    .where("tokens.expiresAt", ">=", getCurrentDateTimeString() as any)
    .executeTakeFirst();
});
