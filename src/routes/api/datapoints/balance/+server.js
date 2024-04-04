import { json } from '@sveltejs/kit';
import Database from '$lib/server/database.js';

/** @type {import('./$types').RequestHandler} */
export async function GET() {
  const db = new Database('db/perfin.db');

  const sources = await db.query(
    `SELECT
      CASE
        WHEN INSTR(description, 'DAILY OD INT') > 0 THEN 'DAILY OD INT'
        WHEN INSTR(description, 'Amazon Prime') > 0 THEN 'Amazon Prime'
        WHEN INSTR(description, 'COSTA COF') > 0 THEN 'COSTA'
        ELSE description
      END AS name,
      COUNT(*) AS count,
      SUM(credit_amount) AS credit_amount,
      SUM(debit_amount) AS debit_amount
    FROM
      transactions
    GROUP BY
      name;`
  );

  return json({
    sources
  });
}
