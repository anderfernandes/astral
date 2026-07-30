import { Temporal } from "@js-temporal/polyfill";
import { getRequest } from "@tanstack/solid-start/server";
import { randomBytes } from "crypto";
import { sql } from "kysely";
import { db } from "~db";
import { getCurrentDateTimeString, toDateTimeString } from "~utils/index";
import { createHash } from "~utils/index.server";
import mailer from "~utils/mailer.server";

export async function register(
  data: {
    firstName: string;
    lastName: string;
    email: string;
    password: string;
  },
  origin = "http://localhost:3000",
) {
  try {
    await db
      .insertInto("users")
      .values({
        email: data.email,
        firstName: data.firstName,
        lastName: data.lastName,
        password: await createHash(data.password),
        roles: "[]",
        creatorId: 0,
      })
      .execute();

    const user = await db
      .selectFrom("users")
      .where("email", "=", data.email)
      .selectAll()
      .executeTakeFirstOrThrow();

    const token = randomBytes(32).toString("base64url");

    await db
      .insertInto("tokens")
      .values({
        id: token,
        userId: user?.id,
        purpose: "activation",
        expiresAt: toDateTimeString(
          Temporal.Now.zonedDateTimeISO("UTC").add({ minutes: 15 }).toString(),
        ),
      })
      .execute();

    if (process.env.NODE_ENV !== "test") {
      const res = await mailer.sendMail({
        from: process.env["MAIL_FROM"],
        to: user.email,
        subject: `Activate your ${process.env["NAME"]} account`,
        html: `<h1>Welcome to ${process.env["NAME"]}!</h1><p>Click <a target="_blank" href="${origin}/activate?token=${token}">here</a> to activate your account.</p>`,
      });

      console.log(res);
    }

    return { success: true };
  } catch (error) {
    if ((error as Error).message.includes("email"))
      throw new Error("Email already in use.");

    throw new Error("Unable to register at the moment. Please try again later");
  }
}

export async function activate(tokenId: string) {
  const token = await db
    .selectFrom("tokens")
    .where("id", "=", tokenId)
    .where("purpose", "=", "activation")
    .where("expiresAt", ">=", getCurrentDateTimeString() as any)
    .where("updatedAt", "is", null)
    .selectAll()
    .executeTakeFirst();

  if (!token) return undefined;

  await db
    .updateTable("tokens")
    .set({
      updatedAt: getCurrentDateTimeString() as any,
      expiresAt: getCurrentDateTimeString() as any,
    })
    .where("id", "=", tokenId)
    .where("expiresAt", ">=", getCurrentDateTimeString() as any)
    .executeTakeFirst();

  db.updateTable("users")
    .set({
      activatedAt: getCurrentDateTimeString() as any,
      updatedAt: getCurrentDateTimeString() as any,
      roles: JSON.stringify(["ROLE_USER"]),
    })
    .where("id", "=", token?.userId)
    .executeTakeFirstOrThrow();

  return token.id;
}
