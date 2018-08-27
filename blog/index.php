<?php
/**
 * Created by PhpStorm.
 * User: friday
 * Date: 8/26/18
 * Time: 10:56 AM
 */

//will connect to database here

$dir = 'blog.sqlite';

class db extends SQLite3 {
    function __construct()
    {
        $this->open('../db/blog.db');
    }
}

try{

    $conn  = new db();
    $ret = $conn->query("SELECT * FROM articles");

//    $a = $conn->exec("CREATE TABLE articles (id INTEGER primary key AUTOINCREMENT, title varchar (200),
//description varchar (5000), link varchar (200), slug varchar (200) UNIQUE , created_at TIMESTAMP default CURRENT_TIMESTAMP )");
    $blog_data = [];
    while ($res = $ret->fetchArray(SQLITE3_ASSOC)) {
        $data = [
             "title" => $res['title'],
             "description" => $res['description'],
            "link" => $res['link'],
            "slug" => $res['slug'],
             "created_at" => $res['created_at']
         ];
        array_push($blog_data,$data);
    }

}
catch (SQLiteException $e) {
    echo $conn->lastErrorMsg();
    echo $e->getMessage(); die();
}
?>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="/css/app.css?v=0.91">
    <link href="/images/favicon.png" rel="shortcut icon" />

    <title>Blog | Friday Godswill</title>
    <meta name="description" content="Friday Godswill is a web developer currently working for hotels.ng, documenting his thoughts and processes on this blog">
    <link rel="canonical" href="//fridaygodswill.com" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Blog | Friday Godswill - Full-Stack Web Developer" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="//fridaygodswill.com" />
    <meta property="og:site_name" content="Friday Godswill" />
    <meta property="og:image" content="//fridaygodswill.com/images/favicon.png" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@faradayyg" />
    <meta name="twitter:title" content="Blog | Friday Godswill, Full-Stack Developer " />
    <meta name="twitter:description" content="Friday Godswill is a web developer currently working for hotels.ng, documenting his thoughts and processes on this blog" />
    <meta name="twitter:image" content="//fridaygodswill.com/images/favicon.png" />
</head>

<body>
    <div class="nav">
        <div class="container">
            <img class="brand" src="/images/favicon.png">
            <ul class="">
                <li><a href="/home" class="loads_content">Home</a></li>
                <li><a class="loads_content" href="/about">About</a></li>
                <li><a class="loads_content" href="/contact">Contact</a></li>
                <li><a class="active" href="/blog">Blog</a></li>
            </ul>
        </div>
    </div>
    <div class="wrap blog-page">
        <div class="textarea container line-dbl">
            <h1>Blog | Friday Godswill</h1>
            <?php foreach ($blog_data as $post){ ?>
            <article class="blog-post">
                <h2>
                    <?= $post['title'] ?>
                    <br />
                    <small><?= $post['created_at'] ?></small>
                </h2>
                <div class="blog-body">
                    <?= substr($post['description'], 0, 400); echo (strlen($post['description']) > 400) ? '...' : '' ?>
                </div>
                <div class="read-more">
                    <a href="<?= (strlen($post['link']) > 10) ? $post['link'] : '/blog/'.$post['slug'] ?>" target="_blank" rel="noopener" class="read-more-button">
                        Read More
                    </a>
                </div>
            </article>
            <?php }?>
        </div>
    </div>
</body>
</html>
