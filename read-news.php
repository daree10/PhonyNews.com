<?php require __DIR__ . '../includes/functions.php' ?>
<html>
    <head>
        <title>Welcome to news channel</title>
        <link rel="stylesheet" type="text/css" href="../design/style.css">
        <script>
            window.addEventListener("load", function (){
                var array = document.URL.split("/");
                var news_id = array[array.length-1];
                var xhr = new XMLHttpRequest();
                xhr.addEventListener("load", uploadComplete, false);
                xhr.open("GET", '../REST-articles/articles/'+news_id);  
                xhr.send();
            });
            
            function uploadComplete(evt)
            {
                var obj = JSON.parse(evt.target.responseText);
                if(obj.data.length === 0)
                {
                    document.getElementsByClassName("news")[0].innerHTML="<strong>Wrong article!</strong>";
                }
                else
                {
                    var newHTML = "<h2>"+obj.data[0].news_title+"</h2>";
                    var date = new Date(obj.data[0].news_published_on);
                    newHTML += "<span>published on "+date.getFullYear()+" by "+obj.data[0].news_author+"</span>";
                    newHTML += "<div>"+obj.data[0].news_full_content+"</div>";
                    //(new DateTime($article->news_published_on))->format("l jS F Y \, g:ia"); ?> by stripslashes($article->news_author) ?></span>
                    document.getElementsByClassName("news")[0].innerHTML = newHTML;
                }
                
            }
        </script>
    </head>
    <body>
        <div class="container">

            <div class="welcome">
                <h1>Latest news</h1>
                <p>Welcome to PhonyNews.com <em>We never stop until you are aware.</em></p>
                <a href="../">return to home page</a>
            </div>

            <div class="news-box">

                <div class="news">
<?php
// get the database handler
$dbh = connect_to_db(); // function created in dbconnect, remember?

$id_article = (int) filter_input(INPUT_GET, 'newsid');

if (!empty($id_article) && $id_article > 0) {
    // Fecth news
    $article = getAnArticle($id_article, $dbh);
    $article = $article[0];
} else {
    $article = false;
    echo "<strong>Wrong article!</strong>";
}

$other_articles = getOtherArticles($id_article, $dbh);
?>

                    <?php if ($article && !empty($article)) : ?>

                        <h2><?= stripslashes($article->news_title) ?></h2>
                        <span>published on <?= (new DateTime($article->news_published_on))->format("l jS F Y \, g:ia"); ?> by <?= stripslashes($article->news_author) ?></span>
                        <div>
    <?= stripslashes($article->news_full_content) ?>
                        </div>
                        <?php else: ?>

                    <?php endif ?>
                </div>

                <hr>
                <h1>Other articles</h1>
                <div class="similar-posts">
<?php if ($other_articles && !empty($other_articles)) : ?>

                        <?php foreach ($other_articles as $key => $article) : ?>
                            <h2><a href="<?= $article->news_id ?>"><?= stripslashes($article->news_title) ?></a></h2>
                            <p><?= stripslashes($article->news_short_description) ?></p>
                            <span>published on <?= (new DateTime($article->news_published_on))->format("l jS F Y \, g:ia"); ?> by <?= stripslashes($article->news_author) ?></span>
    <?php endforeach ?>

                    <?php endif ?>

                </div>

            </div>

            <div class="footer">
                phpocean.com © <?= (new DateTime())->format("Y") ?> - all rights reserved.
            </div>

        </div>
    </body>
</html>