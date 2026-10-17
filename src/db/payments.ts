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
  return await db
    .selectFrom("payments")
    .where("saleId", "=", data.saleId)
    .selectAll()
    .execute();
}
