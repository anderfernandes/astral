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
    updatedAt: ColumnType<Date | string | null, never, Date | string>;
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
    updatedAt: ColumnType<Date | string | null, never, Date | string>;
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
    updatedAt: ColumnType<Date | string | null, never, Date | string>;
  }

  type MembershipType = Selectable<IMembershipTypesTable>;
  type MembershipTypeInsertable = Insertable<IMembershipTypesTable>;
  type MembershipTypeUpdateable = Updateable<IMembershipTypesTable>;

  interface ISalesTable {
    id: Generated<bigint>;
    status: "OPEN" | "COMPLETED" | "CANCELED";
    source: "CASHIER" | "ADMIN" | "PORTAL";
    isTaxable: 0 | 1;
    checkoutSessionId: string | null | undefined;
    creatorId: number;
    customerId: number;
    createdAt: ColumnType<Date | string, never, never>;
    updatedAt: ColumnType<Date | string | null, never, Date | string>;
  }

  type Sale = Selectable<ISalesTable> & {
    subtotal: number;
    tax: number;
    total: number;
    items: SaleItem[];
    payments: Payment[];
  };
  type SaleInsertable = Insertable<ISalesTable>;
  type SaleUpdateable = Updateable<ISalesTable>;

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
    updatedAt: ColumnType<Date | string | null, never, Date | string>;
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
    updatedAt: ColumnType<Date | string | null, never, Date | string>;
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
    createdAt: ColumnType<Date | string, string, never>;
    updatedAt: ColumnType<Date | string | null, never, Date | string>;
  }

  type Payment = Selectable<IPaymentsTable> & { method?: PaymentMethod };
  type PaymentInsertable = Selectable<IPaymentsTable>;
  type PaymentUpdateable = Selectable<IPaymentsTable>;

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

export {};
