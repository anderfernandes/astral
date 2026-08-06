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
    updatedAt: ColumnType<never, Date | string | undefined, never>;
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
    creatorId: number;
    createdAt: ColumnType<Date | string, never, never>;
    updatedAt: ColumnType<never, Date | string | undefined, never>;
  }

  type PaymentMethod = Selectable<IPaymentMethodsTable>;
  type PaymentTypeInsertable = Insertable<IPaymentMethodsTable>;
  type PaymentTypeUpdateable = Updateable<IPaymentMethodsTable>;

  interface IPaymentsTable {
    id: Generated<number>;
    method: PaymentMethod;
    tendered: number;
    saleId: number;
    cashierId: number;
    createdAt: ColumnType<string, string, never>;
    updatedAt: ColumnType<never, string, never>;
  }

  type Payment = Selectable<IPaymentsTable>;
  type PaymentInsertable = Selectable<IPaymentsTable>;
  type PaymentUpdateable = Selectable<IPaymentsTable>;

  interface ISaleItemsTable {
    id: Generated<number>;
    saleId: number;
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
    createdAt: ColumnType<string, string, never>;
    updatedAt: ColumnType<never, string, never>;
  }

  type SaleItem = Selectable<ISaleItemsTable>;
  type SaleItemInsertable = Insertable<ISaleItemsTable>;
  type SaleItemUpdatable = Updateable<ISaleItemsTable>;

  interface ISalesTable {
    id: Generated<number>;
    status: "OPEN" | "COMPLETED" | "CANCELED";
    source: "CASHIER" | "ADMIN" | "CUSTOMER";
    isTaxable: boolean;
    creatorId: number;
    createdAt: ColumnType<string, string, never>;
    updatedAt: ColumnType<never, string, never>;
    items: SaleItem[];
    payments: Payment;
  }

  type Sale = Selectable<ISalesTable>;
  type SaleInsertable = Insertable<ISalesTable>;
  type SaleUpdateable = Updateable<ISalesTable>;

  interface IDatabase {
    users: IUsersTable;
    membershipTypes: IMembershipTypesTable;
    paymentMethods: IPaymentMethodsTable;
    tokens: ITokensTable;
    saleItems: ISaleItemsTable;
    sales: ISalesTable;
  }

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
