CREATE TABLE transactions (
  `date` INT NOT NULL,
  `type` TEXT NOT NULL,
  sort_code TEXT NOT NULL,
  account_number INT NOT NULL,
  `description` TEXT NOT NULL,
  debit_amount REAL NOT NULL,
  credit_amount REAL NOT NULL,
  balance REAL NOT NULL,
  `hash` TEXT NOT NULL
);