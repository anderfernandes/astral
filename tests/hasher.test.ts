import { expect, test } from "vitest";
import { createHash, verifyHash } from "~utils/index.server";

test("1: hasher hashers and verifies", async () => {
  const hash = await createHash("MyTestP@ssw0rd123");
  expect(await verifyHash("MyTestP@ssw0rd123", hash));
});
