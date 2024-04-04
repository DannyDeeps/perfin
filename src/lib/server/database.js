import sqlite3 from 'sqlite3';

export default class Database {
  db = null;

  constructor(dbPath) {
    this.dbPath = dbPath;
  }

  connect() {
    return (this.db = this.db || new sqlite3.Database(this.dbPath, sqlite3.OPEN_READWRITE));
  }

  get(table, orderBy = '') {
    const conn = this.connect();

    let query = `SELECT rowid, * FROM ${table}`;
    if (orderBy) {
      query = `${query} ORDER BY ${orderBy}`;
    }

    return new Promise((resolve, reject) => {
      conn.all(query, (err, rows) => {
        if (err) {
          reject(err);
        } else {
          resolve(rows);
        }

        conn.close();
      });
    });
  }

  query(sql) {
    const conn = this.connect();

    return new Promise((resolve, reject) => {
      conn.all(sql, [], (err, rows) => {
        if (err) {
          reject(err);
        } else {
          resolve(rows);
        }
      });

      conn.close();
    });
  }

  create(table, rows) {
    const conn = this.connect();

    rows.forEach((row) => {
      const fieldNames = Object.keys(row).join(',');
      const fieldValues = Object.values(row);
      const placeholders = '?,'.repeat(fieldValues.length).slice(0, -1);

      conn.run(
        `INSERT INTO ${table} (${fieldNames}) VALUES (${placeholders})`,
        fieldValues,
        (err) => {
          if (err) {
            console.log('Error inserting row: ', err.message);
          }
        }
      );
    });

    conn.close();
  }
}
