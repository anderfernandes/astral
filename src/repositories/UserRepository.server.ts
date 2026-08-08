import { Temporal } from "@js-temporal/polyfill";
import { randomBytes } from "crypto";
import { db } from "~db";
import {
  getCurrentDateTimeString,
  toDate,
  toDateTimeString,
} from "~utils/index";
import { createHash } from "~utils/index.server";
import mailer from "~utils/mailer.server";
import * as TokenRepository from "./TokenRepository.server";

export async function register(
  data: IRegistrationData,
  origin = "http://localhost:3000",
) {
  try {
    await save({
      email: data.email,
      firstName: data.firstName,
      lastName: data.lastName,
      password: await createHash(data.password),
      roles: [],
      creatorId: 0,
    });

    const user = await get({ email: data.email });

    if (user === undefined) throw new Error("Failed to register user: 404");

    const token = randomBytes(32).toString("base64url");

    await TokenRepository.save({
      id: token,
      userId: user?.id,
      purpose: "activation",
      expiresAt: toDateTimeString(
        Temporal.Now.zonedDateTimeISO("UTC").add({ minutes: 15 }).toString(),
      ),
    });

    // if (process.env.NODE_ENV !== "test") {
    //   const res = await mailer.sendMail({
    //     from: process.env["MAIL_FROM"],
    //     to: user.email,
    //     subject: `Activate your ${process.env["NAME"]} account`,
    //     html: `<h1>Welcome to ${process.env["NAME"]}!</h1><p>Click <a target="_blank" href="${origin}/activate?token=${token}">here</a> to activate your account.</p>`,
    //   });

    //   console.log(res);
    // }

    console.log("registration token: ", token);

    return { success: true };
  } catch (error) {
    if (error instanceof Error) {
      if (error.message.includes("email"))
        throw new Error("Email already in use.");

      throw error;
    }

    //throw new Error("Unable to register at the moment. Please try again later");
  }
}

export async function activate(tokenId: string) {
  const token = await TokenRepository.get({
    id: tokenId,
    purpose: "activation",
  });

  // await db
  //   .updateTable("tokens")
  //   .set({
  //     updatedAt: getCurrentDateTimeString() as any,
  //     expiresAt: getCurrentDateTimeString() as any,
  //   })
  //   .where("id", "=", tokenId)
  //   .where("expiresAt", ">=", getCurrentDateTimeString() as any)
  //   .executeTakeFirst();

  const user = await get({ id: token.userId });

  await save({
    id: user.id,
    activatedAt: getCurrentDateTimeString(),
    updatedAt: getCurrentDateTimeString(),
    roles: ["ROLE_USER"],
  });

  await TokenRepository.save({
    id: token.id,
    updatedAt: getCurrentDateTimeString(),
    expiresAt: getCurrentDateTimeString(),
  } as TokenUpdateable);

  // db.updateTable("users")
  //   .set({
  //     activatedAt: getCurrentDateTimeString() as any,
  //     updatedAt: getCurrentDateTimeString() as any,
  //     roles: JSON.stringify(["ROLE_USER"]),
  //   })
  //   .where("id", "=", token?.userId)
  //   .executeTakeFirstOrThrow();

  return token.id;
}

export async function generateAccountRecoveryToken(
  email: string,
  origin = "http://localhost:3000",
) {
  // const user = await db
  //   .selectFrom("users")
  //   .where("email", "=", email)
  //   .select(["id", "email", "roles", "activatedAt"])
  //   .executeTakeFirst();

  const user = await get({ email });

  console.log(user);

  if (!user) {
    console.info(`User with email ${email} does not have an account.`);
    return { success: true };
  }

  if (!user?.roles.includes("ROLE_USER") || !user.activatedAt) {
    console.info(
      `User with email ${email} has not activated their account or their account is inactive.`,
    );
    return { success: true };
  }

  const token = randomBytes(32).toString("base64url");

  await TokenRepository.save({
    id: token,
    userId: user.id,
    purpose: "password recovery",
    expiresAt: Temporal.Now.zonedDateTimeISO("UTC")
      .add({ minutes: 15 })
      .toPlainDateTime()
      .toString({ smallestUnit: "seconds" })
      .replace("T", " "),
  });

  // await db
  //   .insertInto("tokens")
  //   .values({
  //     id: token,
  //     userId: user?.id,
  //     purpose: "password recovery",
  //     expiresAt: toDateTimeString(
  //       Temporal.Now.zonedDateTimeISO("UTC").add({ minutes: 5 }).toString(),
  //     ),
  //   })
  //   .execute();

  // if (process.env.NODE_ENV !== "test") {
  //   const res = await mailer.sendMail({
  //     from: process.env["MAIL_FROM"],
  //     to: user.email,
  //     subject: `${process.env["NAME"]} Account Recovery`,
  //     html: `<h1>Recover your ${process.env["NAME"]} account</h1><p>Click <a target="_blank" href="${origin}/reset?token=${token}">here</a> to recover your ${process.env["NAME"]} account password. The link expires in 5 minutes.</p>`,
  //   });

  //   console.log(res);
  // }

  console.log("password recovery token: ", token);

  return { success: true };
}

export async function getAccountRecoveryToken(tokenId: string) {
  // TODO: HANDLE PASSWORD OR EMAIL RECOVERY (ADD PHONE NUMBERS)

  const token = await TokenRepository.get({
    id: tokenId,
    purpose: "password recovery",
  });

  // const token = await db
  //   .selectFrom("tokens")
  //   .where("id", "=", data)
  //   .where("purpose", "=", "password recovery") // TODO: HANDLE PASSWORD OR EMAIL RECOVERY
  //   .where("expiresAt", ">=", getCurrentDateTimeString() as any)
  //   .where("updatedAt", "is", null)
  //   .selectAll()
  //   .executeTakeFirst();

  // console.log(token);

  // if (!token) return undefined;

  return token;
}

export async function save(data: UserInsertable | UserUpdateable) {
  if (data.id) {
    let query = db.updateTable("users");

    if (data.password) {
      query = query.set({ password: await createHash(data.password) }); // FIX THIS
      console.log(data.password);
    }

    if (data.roles) {
      query = query.set({ roles: JSON.stringify(data.roles) });
    }

    if ((data as UserUpdateable).activatedAt)
      query = query.set({ activatedAt: (data as UserUpdateable).activatedAt });

    await query
      .set({ updatedAt: getCurrentDateTimeString() as string })
      .where("id", "=", data.id)
      .execute();

    return;
  }

  await db
    .insertInto("users")
    .values({ ...data, roles: JSON.stringify(data.roles) } as UserInsertable)
    .execute();
}

export async function get(data: Partial<User>) {
  let query = db.selectFrom("users");

  if (data.id) query = query.where("id", "=", data.id);

  if (data.email) query = query.where("email", "=", data.email);

  const user = await query.selectAll().executeTakeFirst();

  return {
    ...user,
    roles: JSON.parse(user?.roles as string) as Role[],
    createdAt: toDate(user?.createdAt),
    updatedAt: toDate(user?.updatedAt),
    activatedAt: toDate(user?.activatedAt),
  };
}
