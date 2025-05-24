import moment from 'moment';
import Database from '$lib/server/database';

/** @type {import('./$types').PageServerLoad} */
export async function load({ fetch }) {
  const response = await fetch('/api/transactions');
  const data = await response.json();
  return data;
}

/** @type {import('./$types').Actions} */
export const actions = {
  default: async ({ request }) => {
    const data = await request.formData();
    const upload = data.get('upload');

    let transactions = await upload.text();
    transactions = transactions.trim().split('\n');
    transactions.shift();

    transactions = transactions.map((row) => {
      const hash = row
        .split('')
        .map((char) => char.charCodeAt(0).toString(16))
        .join('');

      let data = row.split(',');

      return {
        date: moment(data[0], 'DD/MM/YYYY').unix(),
        type: data[1],
        sort_code: data[2],
        account_number: parseInt(data[3]),
        description: data[4],
        debit_amount: parseFloat(data[5] || 0),
        credit_amount: parseFloat(data[6] || 0),
        balance: parseFloat(data[7]),
        hash
      };
    });

    const db = new Database('db/perfin.db');
    db.create('transactions', transactions);

    return;
  }
};
