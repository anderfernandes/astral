import { query } from "@solidjs/router";
import { getRequestEvent, redirect } from "@solidjs/web";
import db from "~db";
import membershipTypes from "../db/membershipTypes";

export const getOrganizationSettingsFn = query(async () => {
  "use server";
  return {
    name: process.env["NAME"],
    timezone: process.env["TIMEZONE"],
    locale: process.env["LOCALE"],
    currency: process.env["USD"],
    saleTaxRate: Number(process.env["SALE_TAX_RATE"]),
    convenienceFee: Number(process.env["CONVENIENCE_FEE"]),
    hasMembershipTypes: (await membershipTypes.findAll()).every(
      (item) => item.isActive && item.isPublic,
    ),
  };
}, "organization-settings");

export const getUserFn = query(async (redirectIfNotSignedIn = true) => {
  "use server";

  const token = (getRequestEvent()?.request.headers.get("cookie") as string)
    ?.split("=")
    ?.at(1);

  if (!token) {
    if (redirectIfNotSignedIn) throw redirect("/sign-in");
    else return undefined;
  }

  const user = await db.tokens.findBy({
    data: token,
    purpose: "authentication",
  });

  if (!user) {
    getRequestEvent()?.response.headers.append(
      "set-cookie",
      import.meta.env.PROD
        ? "__Host-ASTRALSIGNINSESSION=; HttpOnly; Secure; SameSite=Lax; Path=/; Max-Age=0"
        : "ASTRALSIGNINSESSION=; HttpOnly; Path=/; Max-Age=0",
    );

    if (redirectIfNotSignedIn) throw redirect("/sign-in");
    else return undefined;
  }

  console.log(token, user);

  return user;
}, "get-user");

export function toCurrencyString(
  n: number,
  options: Intl.NumberFormatOptions = { maximumFractionDigits: 2 },
) {
  return (n / 100).toLocaleString("en-US", {
    style: "currency",
    currency: "USD",
    maximumFractionDigits: 2,
    ...options,
  });
}

export async function createHash(content: string, salt: string = "") {
  const randomValues = crypto.getRandomValues(new Uint8Array(16));

  const s =
    salt?.length === 0 ? Buffer.from(randomValues).toString("base64url") : salt;

  const data = new TextEncoder().encode(s + content);

  const digest = await crypto.subtle.digest("SHA-256", data);

  const h = Buffer.from(digest).toString("base64url");

  return `${s}:${h}`;
}

export async function verifyHash(plain: string, hashed: string) {
  const [salt, hash] = hashed.split(":");

  if (!salt) throw new Error("Cannot verify hash.");

  if (!hash) throw new Error("Unable to verify hash.");

  return hashed === (await createHash(plain, salt));
}

export async function encrypt(text: string) {
  const iv = crypto.getRandomValues(new Uint8Array(12));

  const key = await crypto.subtle.importKey(
    "raw",
    Buffer.from(process.env["SESSION_SECRET"], "base64"),
    "AES-GCM",
    false,
    ["encrypt"],
  );

  const encrypted = new Uint8Array(
    await crypto.subtle.encrypt(
      { name: "AES-GCM", iv, tagLength: 128 },
      key,
      new TextEncoder().encode(text),
    ),
  );

  const tag = encrypted.slice(-16);
  const ciphertext = encrypted.slice(0, -16);

  return {
    iv: Buffer.from(iv).toString("base64url"),
    cipherString: Buffer.from(ciphertext).toString("base64"),
    tag: Buffer.from(tag).toString("base64url"),
  };
}

export async function decrypt(data: {
  iv: string;
  cipherString: string;
  tag: string;
}) {
  const key = await crypto.subtle.importKey(
    "raw",
    Buffer.from(process.env["SESSION_SECRET"], "base64"),
    "AES-GCM",
    false,
    ["decrypt"],
  );

  const iv = Buffer.from(data.iv, "base64url");
  const ciphertext = Buffer.from(data.cipherString, "base64url");
  const tag = Buffer.from(data.tag, "base64url");

  const encrypted = Buffer.concat([ciphertext, tag]);

  const decrypted = await crypto.subtle.decrypt(
    { name: "AES-GCM", iv, tagLength: 128 },
    key,
    encrypted,
  );

  return new TextDecoder().decode(decrypted);
}
