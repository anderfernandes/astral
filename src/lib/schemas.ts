import * as v from "valibot";

export const FirstNameSchema = v.pipe(
  v.string(),
  v.minLength(2),
  v.maxLength(255),
);

export const LastNameSchema = v.pipe(
  v.string(),
  v.minLength(2),
  v.maxLength(255),
);

export const EmailSchema = v.pipe(
  v.pipe(v.string(), v.email(), v.maxLength(255)),
);
