import { json } from '@sveltejs/kit';
import Database from '$lib/server/database.js';

/** @type {import('./$types').RequestHandler} */
export async function GET() {
  const db = new Database('db/perfin.db');

  const sources = await db.query(
    `SELECT
      rowid as id,
      CASE
        WHEN description LIKE '%daily od int%' THEN 'Overdraft Interest'
        WHEN description LIKE '%amazon prime%' THEN 'Amazon Prime'
        WHEN description LIKE '%costa%' THEN 'Costa'
        WHEN
          description LIKE '%amazon.co.uk%' OR
          description LIKE '%amzn%' THEN 'Amazon Purchase'
        WHEN description LIKE '%b&m%' THEN 'B&M'
        WHEN description LIKE '%blizzard%' THEN 'Blizzard'
        WHEN description LIKE '%boots%' THEN 'Boots'
        WHEN description LIKE '%dvla%' THEN 'DVLA'
        WHEN description LIKE '%gocardless%' THEN 'Merula'
        WHEN description LIKE '%netflix%' THEN 'Netflix'
        WHEN description LIKE '%mcdonalds%' THEN 'McDonalds'
        WHEN description LIKE '%now%' THEN 'Now Entertainment'
        WHEN description LIKE '%osborne%' THEN 'Trudi Osborne'
        WHEN description LIKE '%naomi j ryan limit%' THEN 'Naomi J Ryan'
        WHEN description LIKE '%place%' THEN 'Olivia Place'
        WHEN description LIKE '%o2%' THEN 'O2 Mobile'
        WHEN description LIKE '%perkins%' THEN 'Jack Perkins'
        WHEN description LIKE '%south west water%' THEN 'South West Water'
        WHEN description LIKE '%steam%' THEN 'Steam'
        WHEN description LIKE '%taco bell%' THEN 'Taco Bell'
        WHEN description LIKE '%tesco%' THEN 'Tesco'
        WHEN description LIKE '%tortilla%' THEN 'Tortilla'
        WHEN description LIKE '%vanquis%' THEN 'Vanquis'
        WHEN
          description LIKE '%taxi%' OR
          description LIKE '%zettle%' OR
          description LIKE '%uber%' OR
          description LIKE '%sumup%'THEN 'Taxi'
        WHEN description LIKE '%youtube%' THEN 'YouTube'
        WHEN
          description LIKE '%just eat%' OR
          description LIKE '%just-eat%' THEN 'Just Eat'
        WHEN description LIKE '%deliveroo%' THEN 'Deliveroo'
        WHEN description LIKE '%epc*%' THEN 'Epic Games'
        WHEN description LIKE '%easyjet%' THEN 'Easyjet'
        WHEN description LIKE '%e.on%' THEN 'E.ON'
        WHEN description LIKE '%disney plus%' THEN 'Disney Plus'
        WHEN description LIKE '%crunchyroll%' THEN 'Crunchyroll'
        WHEN description LIKE '%hosthavoc%' THEN 'Host Havoc'
        WHEN description LIKE '%griffiths%' THEN 'Tia Griffiths'
        WHEN description LIKE '%riot%' THEN 'Riot Games'
        WHEN description LIKE '%prime video%' THEN 'Prime Video'
        WHEN description LIKE '%pumpkin%' THEN 'Pumpkin Cafe'
        WHEN
          description LIKE '%quadlock%' OR
          description LIKE '%quad lock%' THEN 'Quad Lock'
        WHEN description LIKE '%nya*%' THEN 'Morrisons Air'
        -- WHEN description IN ('PINHOE ROAD SAINSB', 'SAINSBURY - ALPHIN', 'SAINSBURYS S/MKTS') THEN 'Sainsburys'
        -- WHEN description LIKE '%petro%' THEN 'Petrol'
        -- WHEN description LIKE '%morrisons%' THEN 'Morrisons'
        ELSE description
      END AS name,
      COUNT(*) AS count,
      SUM(credit_amount) AS credit_amount,
      SUM(debit_amount) AS debit_amount
    FROM
      transactions
    GROUP BY
      name
    ORDER BY
      name;`
  );

  return json({
    sources
  });
}
