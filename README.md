# Consumer Reports Coding Challenge
`Coded by Kevin LeGall, Designed by Anup Rai`

The React application prompts user to enter a string, after submit the backend php code checks the SQL database for any matching strings, if a match is found, it returns the result, if not found an algorithm triggers to check for 'aaa' &amp; 'aba' patterns in the string and outputs 1 or 2 for the respective match. The result is returned to the user and the entry is stored in sql with a unique id, date, original string, and output result. 


Command to Generate SQL Table:
`CREATE TABLE data ( id varchar(50) primary key, date_created datetime, user_string varchar(50), results varchar(50))`

Be sure to change `const postURL` in `src/App.js` to reflect the localhost. 

