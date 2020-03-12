RUN APPLICATION:
1. Create database
2. Import passwords from `src/Resources/dump/passwords.sql`
3. Set correct `DATABASE_URL` in `.env`
4. Run console command `bin/console password:checker`

Note:  
`bin/console password:checker -v` - run with 'verbose mode' and show validation error messages  
`bin/console password:checker --password=pass [-p pass]` - check particular password  
`bin/console password:checker --generate [-g]` - generate and check generated password
