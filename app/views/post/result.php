<div class="news__result border">
    <div class="news_img">
        <a href="<?= $url?>" target="_blank">
            <img class="img-fluid" src="<?= $img ?>" alt="">
        </a>
    </div>
    <div class="news_content">
        <a href="<?= $url?>" target="_blank">
            <h3 class="news_text"><?= htmlspecialchars_decode($title) ?></h3>
            <p class="news_description"><?= htmlspecialchars_decode($description) ?></p>
        </a>
    </div>
</div>