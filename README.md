<h1>How to run this laravel project</h1>
<hr>
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
