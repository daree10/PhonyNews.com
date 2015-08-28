<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome to news channel</title>
        <link rel="stylesheet" type="text/css" href="design/style.css">
    </head>
    <body>

        <div class="container">

            <div class="welcome">
                <h1>Latest news</h1>
                <p>Welcome to PhonyNews.com <em>We never stop until you are aware.</em></p>
            </div>

            <div class="news-box">
                <?php
                $url = "http://localhost/PhonyNews.com/REST-articles/articles/";
                $client = curl_init($url);

                curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);

                $response = curl_exec($client);

                $news = json_decode($response);
                ?>
                <?php if ($news && !empty($news)) : ?>
                    <?php foreach ($news->data as $key => $article) : ?>                       
                            <h2><a href="news/<?= $article->news_id ?>"><?= stripslashes($article->news_title) ?></a></h2>
                            <p><?= stripslashes($article->news_short_description) ?></p>
                            <span>published on <?= (new DateTime($article->news_published_on))->format("l jS F Y \, g:ia"); ?> by <?= stripslashes($article->news_author) ?></span>
  
                    <?php endforeach ?>
                <?php endif ?>

            </div>

            <div class="footer">
                PhonyNews.com © <?= (new DateTime())->format("Y") ?> - all rights reserved.
            </div>

        </div>
    </body>
</html>