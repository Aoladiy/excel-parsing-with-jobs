<h1>How to run this laravel project</h1>
<hr>
<p>create .env file and copy to this file everything from .env.example</p>
<p>in project folder run following commands:</p>
<ol>
    <li>composer install</li>
    <li>sail up -d</li>
    <li>sail npm run build</li>
    <li>sail artisan migrate:fresh --seed</li>
    <li>sail artisan queue:work</li>
    <li>sail artisan queue:work --queue=high</li>
    <li>sail artisan reverb:start</li>
</ol>
<p>project has the following routes:</p>
<ol>
    <li>/rows</li>
    <li>/upload</li>
</ol>
<p>to get access to the /upload route login as 1@1 with password 1</p>
<p>to see progress in redis run following commands:</p>
<ol>
    <li>sail artisan tinker</li>
    <li>Illuminate\Support\Facades\Redis::get('chunk_progress:INSERT_HERE_CHUNK_INDEX_YOU_INTERESTED_IN')</li>
</ol>
