SELECT
  CASE
    WHEN INSTR(description, 'DAILY OD INT') > 0
    THEN 'DAILY OD INT'
    ELSE description
  END AS group,
  COUNT(*) AS count,
  SUM(credit_amount) AS credit_amount,
  SUM(debit_amount) AS debit_amount
FROM transactions
GROUP BY group;