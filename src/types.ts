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
    roles: JSONColumnType<Role[], Role[], Role[]> | string;
    creatorId: number;
    createdAt: ColumnType<Date | string, never, never>;
    updatedAt: ColumnType<Date | string, never, string>;
    activatedAt: ColumnType<string | undefined, never>;
  }

  type User = Selectable<IUsersTable>;
  type UserInsertable = Insertable<IUsersTable>;
  type UserUpdateable = Updateable<IUsersTable>;

  interface ITokensTable {
    id: string;
    userId: number;
    purpose:
      "activation" | "authentication" | "password recovery" | "email recovery";
    createdAt: ColumnType<Date | string, never, never>;
    updatedAt: ColumnType<
      never,
      Date | string | undefined,
      Date | string | undefined
    >;
    expiresAt: ColumnType<string, string | undefined, string | undefined>;
  }

  type Token = Selectable<ITokensTable>;
  type TokenInsertable = Insertable<ITokensTable>;
  type TokenUpdateable = Updateable<ITokensTable>;

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
    creatorId: number;
    createdAt: ColumnType<Date | string, never, never>;
    updatedAt: ColumnType<Date | string, never, string>;
  }

  type MembershipType = Selectable<IMembershipTypesTable>;
  type MembershipTypeInsertable = Insertable<IMembershipTypesTable>;
  type MembershipTypeUpdateable = Updateable<IMembershipTypesTable>;

  interface ISalesTable {
    id: Generated<bigint>;
    status: "OPEN" | "COMPLETED" | "CANCELED";
    source: "CASHIER" | "ADMIN" | "PORTAL";
    isTaxable: 0 | 1;
    creatorId: number;
    createdAt: ColumnType<Date | string, never, never>;
    updatedAt: ColumnType<Date | string, never, string>;
  }

  type Sale = Selectable<ISalesTable> & {
    items: Partial<SaleItem>[];
    payments: Payment[];
  };
  type SaleInsertable = Insertable<ISalesTable> & {
    items: SaleItem[];
    payments: Payment[];
  };
  type SaleUpdateable = Updateable<ISalesTable> & {
    items: SaleItem[];
    payments: Payment[];
  };

  interface ISaleItemsTable {
    id: Generated<number>;
    saleId: bigint;
    type:
      | "TICKET"
      | "PRODUCT"
      | "MEMBERSHIP (PRIMARY)"
      | "MEMBERSHIP (FREE SECONDARY)"
      | "MEMBERSHIP (PAID SECONDARY)"
      | "CONVENIENCE FEE"
      | "SURCHARGE"
      | "DISCOUNT";
    name: string;
    description: string;
    price: number;
    quantity: number;
    creatorId: number;
    createdAt: ColumnType<Date | string, never, never>;
    updatedAt: ColumnType<Date | string, never, string>;
  }

  type SaleItem = Selectable<ISaleItemsTable>;
  type SaleItemInsertable = Insertable<ISaleItemsTable>;
  type SaleItemUpdatable = Updateable<ISaleItemsTable>;

  interface IDatabase {
    users: IUsersTable;
    membershipTypes: IMembershipTypesTable;
    paymentMethods: IPaymentMethodsTable;
    tokens: ITokensTable;
    sales: ISalesTable;
    saleItems: ISaleItemsTable;
    payments: IPaymentsTable;
  }

  interface IPaymentMethodsTable {
    id: Generated<number>;
    name: string;
    description: string;
    type: "CASH" | "CARD" | "CHECK" | "OTHER";
    isActive: 0 | 1;
    isPublic: 0 | 1;
    creatorId: number;
    createdAt: ColumnType<Date | string, never, never>;
    updatedAt: ColumnType<never, Date | string | undefined, never>;
  }

  type PaymentMethod = Selectable<IPaymentMethodsTable>;
  type PaymentTypeInsertable = Insertable<IPaymentMethodsTable>;
  type PaymentTypeUpdateable = Updateable<IPaymentMethodsTable>;

  interface IPaymentsTable {
    id: Generated<number>;
    methodId: number;
    tendered: number;
    saleId: bigint;
    cashierId: number;
    createdAt: ColumnType<string, string, never>;
    updatedAt: ColumnType<never, string, never>;
  }

  type Payment = Selectable<IPaymentsTable> & { method?: PaymentMethod };
  type PaymentInsertable = Selectable<IPaymentsTable> & {
    method?: PaymentMethod;
  };
  type PaymentUpdateable = Selectable<IPaymentsTable> & {
    method?: PaymentMethod;
  };

  interface IRegistrationData {
    firstName: string;
    firstNameConfirmation: string;
    lastName: string;
    lastNameConfirmation: string;
    email: string;
    emailConfirmation: string;
    password: string;
    passwordConfirmation: string;
  }
}

declare namespace NodeJS {
  interface ProcessEnv {
    DB_DRIVER: "sqlite" | "postgres";
  }
}

export {};
