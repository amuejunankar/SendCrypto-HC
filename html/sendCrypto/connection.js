const { createPool } = require('mysql');

const pool = createPool({
    host: "localhost",
    user: "root",
    password: "",
    database: "account",
});

module.exports = pool;



// // Listen for the 'connect' event
// Use the pool object as needed
// pool.query('SELECT * FROM accounttable', (err, result) => {
//     if (err) console.error(err);
//     else console.log(result);
// });

