import {
  ColumnType,
  Generated,
  Insertable,
  JSONColumnType,
  Selectable,
  Updateable,
} from "kysely";

declare global {
  type Role = "ROLE_USER" | "ROLE_STAFF" | "ROLE_ADMIN" | "ROLE_MEMBER";

  interface IUsersTable {
    id: Generated<number>;
    firstName: string;
    lastName: string;
    email: string;
    password: string;
    roles: JSONColumnType<Role[], string | undefined, string | undefined>;
    creatorId: ColumnType<number, number | undefined, number>;
    createdAt: ColumnType<number, never, never>;
    updatedAt: ColumnType<number | null, never, number>;
    activatedAt: ColumnType<number | null, never, number>;
  }

  type UserSelectable = Selectable<IUsersTable>;
  type UserInsertable = Insertable<IUsersTable>;
  type UserUpdateable = Updateable<IUsersTable>;

  interface ITokensTable {
    id: Generated<number>;
    data: string;
    userId: number;
    purpose:
      | "account activation"
      | "authentication"
      | "password recovery"
      | "email recovery";
    createdAt: ColumnType<number, never, never>;
    updatedAt: ColumnType<number | null, never, number>;
    expiresAt: ColumnType<number | undefined, number, number>;
  }

  type TokenSelectable = Selectable<ITokensTable>;
  type TokenInsertable = Insertable<ITokensTable>;
  type TokenUpdateable = Updateable<ITokensTable>;

  interface IDatabase {
    users: IUsersTable;
    tokens: ITokensTable;
    //membershipTypes: IMembershipTypesTable;
    //paymentMethods: IPaymentMethodsTable;
    //sales: ISalesTable;
    //saleItems: ISaleItemsTable;
    //payments: IPaymentsTable;
  }
}

export {};
