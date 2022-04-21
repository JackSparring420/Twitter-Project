Questa App permette di programmare l'invio di un tweet

Dopo aver scaricato la repository lanciare il comando: composer update

Installere le librie di VUEJS per formattare la data dei post e per identivicare gli hashtag e i link
npm install --save vue-highlightjs
npm install vue-date-fns --save

Configuriamo il DB dal file ENV e lanciamo le migrations
php artisan migrate:refresh


Per configurare l'app con twitter bisogna creare una account developer 
https://developer.twitter.com/en
Inserire nel file ENV i seguenti dati

TWITTER_CONSUMER_KEY=
TWITTER_CONSUMER_SECRET=
TWITTER_ACCESS_TOKEN=
TWITTER_ACCESS_TOKEN_SECRET=
TWITTER_BEARER_TOKEN=

Scaricare la libreria ufficiale per le chiamate in PHP
composer require coderjerk/bird-elephant

Per utilizzare la programmazione l'invio di un tweet, è sufficiente aggiungere la seguente voce Cron al server
* * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

Per lanciare manualmente lo scheduling di laravel usare il comando: php artisan schedule:run


Le immaggini verranno caricate solamente se si possiede un account Elevated o Academic Research non con un account Essential in quanto permette solo chiamate in V2