compser install
npm install

create .env file

php artisan key:generate
php artisan migrate --seed

<!-- Admin user credentials -->
email: admin@gmail.com
password: 123asd

<!-- customer user credentials -->
email: customer@gmail.com
password: 123asd

<!-- stripe info -->
card no: 4242 4242 4242 4242
cvc: any number
date: provide any date of the future 