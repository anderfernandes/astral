import { db } from "~db";

export async function create(payment: PaymentInsertable) {
  await db
    .insertInto("payments")
    .values({
      processorPaymentId: payment.processorPaymentId,
      methodId: payment.methodId,
      tendered: payment.tendered,
      saleId: payment.saleId,
      cashierId: payment.cashierId,
      customerId: payment.customerId,
    })
    .execute();
}

export async function update(paymentId: number, payment: PaymentUpdateable) {
  await db
    .updateTable("payments")
    .set({
      processorPaymentId: payment.processorPaymentId,
      methodId: payment.methodId,
      tendered: payment.tendered,
      saleId: payment.saleId,
      cashierId: payment.cashierId,
      customerId: payment.customerId,
    })
    .where("id", "=", paymentId)
    .execute();
}

export async function findBy(data: { saleId: number }) {
  const results = await db
    .selectFrom("payments")
    .leftJoin("paymentMethods as method", "method.id", "payments.methodId")
    .leftJoin("users as customer", "customer.id", "payments.customerId")
    .leftJoin("users as cashier", "cashier.id", "payments.cashierId")
    .where("saleId", "=", data.saleId)
    .select([
      "payments.id",
      "payments.tendered",
      "payments.methodId",
      "method.name as methodName",
      "method.type as methodType",
      "payments.cashierId",
      "cashier.firstName as cashierFirstName",
      "cashier.lastName as cashierLastName",
      "payments.saleId",
      "payments.customerId as customerId",
      "customer.firstName as customerFirstName",
      "customer.lastName as customerLastName",
      "payments.createdAt",
      "payments.updatedAt",
    ])
    .execute();

  const payments = results.map((payment) => ({
    ...payment,
    createdAt: payment.createdAt * 1000,
    updatedAt: payment.updatedAt ? payment.updatedAt * 1000 : null,
    method: {
      id: payment.methodId,
      name: payment.methodName,
      type: payment.methodType,
    },
    cashier: {
      id: payment.cashierId,
      firstName: payment.cashierFirstName,
      lastName: payment.cashierLastName,
    },
    customer: {
      id: payment.customerId,
      firstName: payment.customerFirstName,
      lastName: payment.customerLastName,
    },
  }));

  return payments;
}
