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
      ? `__Host-ASTRALSESSID=${token}; HttpOnly; Secure; SameSite=Lax; Path=/; MaxAge=0`
      : `ASTRALSESSID=${token}; HttpOnly; Path=/; MaxAge=0`,
  );

  throw redirect({ to: "/sign-in" });
});
