import {
  ColumnType,
  Generated,
  Insertable,
  Selectable,
  Updateable,
} from "kysely";

declare global {
  interface IUsersTable {
    id: Generated<number>;
    firstName: string;
    lastName: string;
    email: string;
    password: string;
    roles: string; //("ROLE_USER" | "ROLE_STAFF" | "ROLE_ADMIN")[];
    createdAt: ColumnType<Date, string | undefined, never>;
    updatedAt: ColumnType<Date, string | undefined, never>;
    activatedAt: ColumnType<Date, string | undefined, never>;
  }

  type User = Selectable<IUsersTable>;
  type UserInsertable = Insertable<IUsersTable>;
  type UserUpdateable = Updateable<IUsersTable>;

  interface ISessionsTable {
    id: string;
    userId: number;
    createdAt: ColumnType<Date, string | undefined, never>;
    expiresAt: ColumnType<Date, string | undefined, never>;
  }

  type Session = Selectable<ISessionsTable>;
  type SessionInsertable = Insertable<ISessionsTable>;
  type SessionUpdateable = Updateable<ISessionsTable>;

  interface IMembershipTypesTable {
    id: Generated<number>;
    name: string;
    description: string;
    cover: string | null;
    duration: number;
    price: number;
    maxFreeSecondaries: number;
    paidSecondaryPrice: number;
    maxPaidSecondaries: number;
    isActive: 0 | 1;
    isPublic: 0 | 1;
    createdAt: ColumnType<Date, string | undefined, never>;
    updatedAt: ColumnType<Date, string | undefined, never>;
  }

  type MembershipType = Selectable<IMembershipTypesTable>;
  type MembershipTypeInsertable = Insertable<IMembershipTypesTable>;
  type MembershipTypeUpdateable = Updateable<IMembershipTypesTable>;

  interface IPaymentMethodsTable {
    id: Generated<number>;
    name: string;
    description: string;
    type: "CASH" | "CARD" | "CHECK" | "OTHER";
    isActive: 0 | 1;
    isPublic: 0 | 1;
    createdAt: ColumnType<Date, string | undefined, never>;
    updatedAt: ColumnType<Date, string | undefined, never>;
  }

  type PaymentMethod = Selectable<IPaymentMethodsTable>;
  type PaymentTypeInsertable = Insertable<IPaymentMethodsTable>;
  type PaymentTypeUpdateable = Updateable<IPaymentMethodsTable>;

  interface IDatabase {
    users: IUsersTable;
    membershipTypes: IMembershipTypesTable;
    paymentMethods: IPaymentMethodsTable;
    sessions: ISessionsTable;
  }
}

declare namespace NodeJS {
  interface ProcessEnv {
    DB_DRIVER: "sqlite" | "postgres";
  }
}

export {};
