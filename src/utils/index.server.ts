import crypto from "node:crypto";

const KEY = process.env["KEY"];

if (!KEY) throw new Error("KEY not found");

const scrypt = async (text: string, salt: string): Promise<Buffer> => {
  return new Promise((resolve, reject) =>
    crypto.scrypt(text + KEY, salt, 64, (err, key) => {
      if (err) return reject(err);
      resolve(key);
    }),
  );
};

export async function createHash(text: string) {
  const salt = crypto.randomBytes(16).toString("hex");
  const hash = await scrypt(text, salt);

  return `${salt}:${hash.toString("hex")}`;
}

export async function verifyHash(text: string, hash: string) {
  const saltAndHash = hash.split(":");
  if (saltAndHash.length != 2) return false;

  const [salt, storedHash] = saltAndHash;

  if (!salt || !storedHash) return false;

  const derived = await scrypt(text, salt);
  const stored = Buffer.from(storedHash, "hex");

  if (stored.length !== derived.length) return false;

  return crypto.timingSafeEqual(stored, derived);
}
