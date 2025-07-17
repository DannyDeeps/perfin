CREATE TABLE transactions (
  id               CHAR(32) PRIMARY KEY,
  transaction_date INT NOT NULL,
  type             TEXT NOT NULL,
  sort_code        TEXT NOT NULL,
  account_number   TEXT NOT NULL,
  description      TEXT NOT NULL,
  debit_amount     REAL NOT NULL,
  credit_amount    REAL NOT NULL,
  balance          REAL NOT NULL
);