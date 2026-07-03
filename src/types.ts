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

  interface IPaymentsTable {
    id: Generated<number>;
    method: PaymentMethod;
    tendered: number;
    saleId: number;
    createdAt: ColumnType<Date, string | undefined, never>;
    updatedAt: ColumnType<Date, string | undefined, never>;
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
    createdAt: ColumnType<Date, string | undefined, never>;
    updatedAt: ColumnType<Date, string | undefined, never>;
  }

  type SaleItem = Selectable<ISaleItemsTable>;
  type SaleItemInsertable = Insertable<ISaleItemsTable>;
  type SaleItemUpdatable = Updateable<ISaleItemsTable>;

  interface ISalesTable {
    id: Generated<number>;
    status: "OPEN" | "COMPLETED" | "CANCELED";
    source: "CASHIER" | "ADMIN" | "CUSTOMER";
    isTaxable: boolean;
    createdAt: ColumnType<Date, string | undefined, never>;
    updatedAt: ColumnType<Date, string | undefined, never>;
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
    sessions: ISessionsTable;
    saleItems: ISaleItemsTable;
    sales: ISalesTable;
  }
}

declare namespace NodeJS {
  interface ProcessEnv {
    DB_DRIVER: "sqlite" | "postgres";
  }
}

export {};
