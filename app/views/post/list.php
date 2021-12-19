<?php
foreach ($posts as $post) {
?>
    <div class="col-lg-3 col-md-3 news__item">
        <div class="news_img">
            <a href="/post/show/<?= $post['id'] ?> " target="_blank">
                <img class="img-fluid" src="<?= $post['img'] ?>" alt="">
            </a>
        </div>
        <div class="news_content">
            <a href="<?= $post['url'] ?>" target="_blank">
                <h3 class="news_text"><?= htmlspecialchars_decode($post['title']) ?></h3>
                <p class="news_description"><?= htmlspecialchars_decode($post['description']) ?></p>
            </a>
        </div>
    </div>
<?php } ?>