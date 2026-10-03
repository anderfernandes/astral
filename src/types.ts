import {
  ColumnType,
  Generated,
  Insertable,
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
    roles?: string;
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
    createdAt: ColumnType<number, never, never>;
    updatedAt: ColumnType<number | null, never, number>;
  }

  type MembershipTypeSelectable = Selectable<IMembershipTypesTable>;
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
    createdAt: ColumnType<number, never, never>;
    updatedAt: ColumnType<number | null, never, number>;
  }

  type PaymentMethodSelectable = Selectable<IPaymentMethodsTable>;
  type PaymentMethodInsertable = Insertable<IPaymentMethodsTable>;
  type PaymentMethodUpdateable = Updateable<IPaymentMethodsTable>;

  interface IPaymentsTable {
    id: Generated<number>;
    methodId: number;
    tendered: number;
    saleId: number;
    cashierId: number;
    createdAt: ColumnType<number, never, never>;
    updatedAt: ColumnType<number | null, never, number>;
  }

  type Payment = Selectable<IPaymentsTable> & {
    method?: PaymentMethodSelectable;
  };
  type PaymentInsertable = Selectable<IPaymentsTable>;
  type PaymentUpdateable = Selectable<IPaymentsTable>;

  interface ISalesTable {
    id: Generated<number>;
    status: "OPEN" | "COMPLETED" | "CANCELED";
    source: "CASHIER" | "ADMIN" | "PORTAL";
    isTaxable: 0 | 1;
    checkoutId: string | null | undefined;
    creatorId: number;
    customerId: number;
    createdAt: ColumnType<number, never, never>;
    updatedAt: ColumnType<number | null, never, number | null>;
  }

  type Sale = Selectable<ISalesTable> & {
    subtotal: number;
    tax: number;
    total: number;
    items: Partial<SaleItem>[];
    payments: Payment[];
  };
  type SaleInsertable = Insertable<ISalesTable>;
  type SaleUpdateable = Updateable<ISalesTable>;

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
    customerId: number;
    createdAt: ColumnType<number, never, never>;
    updatedAt: ColumnType<number | null, never, number | null>;
    deletedAt: ColumnType<number | null, never, number | null>;
  }

  type SaleItem = Selectable<ISaleItemsTable>;
  type SaleItemInsertable = Insertable<ISaleItemsTable>;
  type SaleItemUpdatable = Updateable<ISaleItemsTable>;

  interface ISaleMemosTable {
    id: Generated<number>;
    saleId: number;
    message: string;
    creatorId: number;
    createdAt: ColumnType<number, never, never>;
    updatedAt: ColumnType<number | null, never, number | null>;
  }

  type SaleMemo = Selectable<ISaleMemosTable>;
  type SaleMemoInsertable = Insertable<ISaleMemosTable>;
  type SaleMemoUpdateable = Updateable<ISaleMemosTable>;

  interface IDatabase {
    users: IUsersTable;
    tokens: ITokensTable;
    membershipTypes: IMembershipTypesTable;
    paymentMethods: IPaymentMethodsTable;
    sales: ISalesTable;
    saleItems: ISaleItemsTable;
    saleMemos: ISaleMemosTable;
    payments: IPaymentsTable;
  }
}
