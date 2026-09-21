import { query, RouteDefinition, RouteProps } from "@solidjs/router";
import { respond } from "@solidjs/web";
import { createMemo, Show } from "solid-js";
import { Alert } from "~components";
import db from "~db";
import { getOrganizationSettingsFn } from "~lib";

// export const route = {
//   preload: ({ params }) => {
//     void activate(params.key!);
//   },
// } satisfies RouteDefinition;

const getOrganizationSettings = query(
  getOrganizationSettingsFn,
  "organization-settings",
);

export default function ActivatePage(props: RouteProps<"/activate/:key">) {
  const organization = createMemo(() => getOrganizationSettings());

  const result = createMemo(() => activate(props.params.key));

  return (
    <>
      <h2 class="text-center text-xl/9 font-bold tracking-tight text-gray-900">
        Sign In
      </h2>
      <span class="mb-8 text-center text-sm/6 text-gray-500">
        {organization().name}
      </span>
      <Alert
        variant={result().success ? "success" : "error"}
        text={result().message}
      />
      <p class="mt-10 text-center text-sm/6 text-gray-500">
        Already have an account?{" "}
        <a href="/sign-in" class="font-semibold text-black hover:text-black/75">
          Sign In
        </a>
        .
      </p>
    </>
  );
}

const activate = query(async (key: string) => {
  "use server";

  try {
    const userToken = await db.tokens.findBy({
      data: key,
      purpose: "account activation",
    });

    if (!userToken || !userToken?.email)
      throw new Error("Failed to activate account.");

    const { tokenId, email } = userToken;

    await db.users.activate({ tokenId, email });

    return { success: true, message: "Account activated successfuly!" };
  } catch (e) {
    const message = (e as Error).message;

    return { success: false, message };
  }
}, "activate");
