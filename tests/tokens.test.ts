import { randomBytes } from "node:crypto";
import { expect, test } from "vitest";
import * as TokenRepository from "~repositories/TokenRepository";
import { Temporal } from "@js-temporal/polyfill";

test("1: save new authentication token", async () => {
  await TokenRepository.save({
    id: randomBytes(32).toString("base64url"),
    userId: 0,
    purpose: "authentication",
    expiresAt: Temporal.Now.zonedDateTimeISO("UTC")
      .toPlainDateTime()
      .toString({ smallestUnit: "seconds" })
      .replace("T", " "),
  });

  const token = await TokenRepository.get({
    userId: 0,
    purpose: "authentication",
  });

  expect(token.userId).toBe(0);
  expect(token.createdAt).toBeDefined();
  expect(token.updatedAt).toBeNull();
});

test("2: update authentication token", async () => {
  const { id } = await TokenRepository.get({
    userId: 0,
    purpose: "authentication",
  });

  await TokenRepository.save({
    id: id,
    updatedAt: Temporal.Now.zonedDateTimeISO("UTC")
      .toPlainDateTime()
      .toString({ smallestUnit: "seconds" })
      .replace("T", " "),
  });

  const token = await TokenRepository.get({
    userId: 0,
    purpose: "authentication",
  });

  expect(token.userId).toBe(0);
  expect(token.createdAt).toBeDefined();
  expect(token.updatedAt).toBeDefined();
});
