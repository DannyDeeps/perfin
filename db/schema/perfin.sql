CREATE TABLE transactions (
  id               CHAR(32) PRIMARY KEY,
  transaction_date INTEGER NOT NULL,
  type             TEXT NOT NULL,
  sort_code        TEXT NOT NULL,
  account_number   TEXT NOT NULL,
  description      TEXT NOT NULL,
  debit_amount     REAL NOT NULL,
  credit_amount    REAL NOT NULL,
  balance          REAL NOT NULL
);

CREATE TABLE sources (
  id   INTEGER PRIMARY KEY,
  name TEXT NOT NULL
);

CREATE TABLE source_matchers (
  id         INTEGER PRIMARY KEY,
  source_id  INTEGER NOT NULL,
  pattern    TEXT NOT NULL,
  is_regex   BOOLEAN NOT NULL DEFAULT 0,
  FOREIGN KEY (source_id) REFERENCES sources (id) ON DELETE CASCADE
);

CREATE TABLE transaction_source_matches (
  transaction_id CHAR(32) NOT NULL,
  source_id      INTEGER NOT NULL,
  matcher_id     INTEGER NOT NULL,
  PRIMARY KEY (transaction_id),
  FOREIGN KEY (transaction_id) REFERENCES transactions (id) ON DELETE CASCADE,
  FOREIGN KEY (source_id) REFERENCES sources (id) ON DELETE CASCADE,
  FOREIGN KEY (matcher_id) REFERENCES source_matchers (id) ON DELETE CASCADE
);