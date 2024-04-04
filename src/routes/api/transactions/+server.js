import { json } from '@sveltejs/kit';
import Database from '$lib/server/database.js';
import moment from 'moment';

/** @type {import('./$types').RequestHandler} */
export async function GET() {
  const db = new Database('db/perfin.db');

  let transactions = await db.get('transactions', 'date DESC, balance');

  transactions = transactions.map((transaction) => {
    transaction.date = moment.unix(transaction.date).format('DD-MM-YYYY');
    return transaction;
  });

  const totals = {
    debit_amount: transactions.reduce((total, transaction) => total + transaction['debit_amount'], 0),
    credit_amount: transactions.reduce((total, transaction) => total + transaction['credit_amount'], 0)
  };

  return json({
    transactions,
    totals
  });
}
