import { query } from "@solidjs/router";

export const getOrganizationSettingsFn = query(
  async () => ({
    name: process.env["NAME"],
    timezone: process.env["TIMEZONE"],
    locale: process.env["LOCALE"],
    currency: process.env["USD"],
    saleTaxRate: Number(process.env["SALE_TAX_RATE"]),
    convenienceFee: Number(process.env["CONVENIENCE_FEE"]),
  }),
  "organization-settings",
);

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
